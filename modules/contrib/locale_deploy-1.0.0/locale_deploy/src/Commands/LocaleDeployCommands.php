<?php

namespace Drupal\locale_deploy\Commands;

use Consolidation\SiteAlias\SiteAlias;
use Consolidation\SiteAlias\SiteAliasManagerAwareTrait;
use Drupal\Core\Batch\BatchBuilder;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drush\Commands\DrushCommands;
use Drush\Drush;
use Drush\SiteAlias\ProcessManager;
use Drush\SiteAlias\SiteAliasManagerAwareInterface;

/**
 * A Drush command file.
 *
 * In addition to this file, you need a drush.services.yml
 * in root of your module, and a composer.json file that provides the name
 * of the services file to use.
 *
 * See these files for an example of injecting Drupal services:
 *   - http://cgit.drupalcode.org/devel/tree/src/Commands/DevelCommands.php
 *   - http://cgit.drupalcode.org/devel/tree/drush.services.yml
 */
class LocaleDeployCommands extends DrushCommands implements SiteAliasManagerAwareInterface {
  use SiteAliasManagerAwareTrait;

  /**
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected LanguageManagerInterface $languageManager;

  /**
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected ModuleHandlerInterface $moduleHandler;

  /**
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected ConfigFactoryInterface $configFactory;

  /**
   * @var \Drupal\Core\File\FileSystemInterface
   */
  protected FileSystemInterface $fileSystem;

  /**
   * A list of global options.
   *
   * @var string[]
   *
   * @see \Drush\TestTraits\DrushTestTrait::drush()
   */
  private const GLOBAL_OPTIONS = ['simulate', 'root', 'uri', 'include', 'config', 'alias-path', 'ssh-options', 'verbose'];

  /**
   * TokenCommands constructor.
   *
   * @param \Drupal\Core\Language\LanguageManagerInterface $languageManager
   *   The language manager.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $moduleHandler
   *   The module handler.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The config factory.
   * @param \Drupal\Core\File\FileSystemInterface $fileSystem
   *   The file system.
   */
  public function __construct(LanguageManagerInterface $languageManager, ModuleHandlerInterface $moduleHandler, ConfigFactoryInterface $configFactory, FileSystemInterface $fileSystem) {
    $this->languageManager = $languageManager;
    $this->moduleHandler = $moduleHandler;
    $this->configFactory = $configFactory;
    $this->fileSystem = $fileSystem;
  }

  /**
   * Ensures that translations are updated as part of a drush:deploy command.
   *
   * Translations are imported prior to configuration to ensure that the
   * configuration is the final say as it is very confusing when configuration
   * changes after running an import.
   *
   * @hook post-command updatedb
   */
  public function postUpdateDbHook(int $result): void {
    if ($result === 0) {
      if (!$this->io()->confirm(dt('Do you wish to update translations from local po files?'))) {
        return;
      }
      $this->logger()?->notice('Running post updatedb locale deploy to ensure translations are up-to-date with po files.');
      $self = $this->siteAliasManager()->getSelf();
      $redispatchOptions = Drush::redispatchOptions();
      $redispatchOptions = array_intersect_key($redispatchOptions, array_flip(self::GLOBAL_OPTIONS));
      /** @var \Drush\SiteAlias\ProcessManager $manager */
      $manager = $this->processManager();
      $this->doUpdates($self, $redispatchOptions, $manager);
    }
  }

  private function doUpdates(SiteAlias $self, array $redispatchOptions, ProcessManager $manager): void {
    $process = $manager->drush($self, 'locale:check', [], $redispatchOptions);
    $process->mustRun($process->showRealtime());
    $process = $manager->drush($self, 'locale:update', [], $redispatchOptions);
    $process->mustRun($process->showRealtime());
  }

  /**
   * Gets translations from localize.drupal.org for core and contrib.
   *
   * @command locale-deploy:localize-translations
   *
   * @bootstrap max
   *
   * @usage drush locale-deploy:localize-translations
   *   Gets translations from localize.drupal.org for core and contrib.
   *
   * @throws \Exception
   */
  public function getTranslations(): void {
    $this->moduleHandler->loadInclude('locale', 'compare.inc');

    $self = $this->siteAliasManager()->getSelf();
    $redispatchOptions = Drush::redispatchOptions();
    /** @var \Drush\SiteAlias\ProcessManager $manager */
    $manager = $this->processManager();

    // Prep system to get updates.
    locale_translation_clear_status();
    locale_translation_flush_projects();
    locale_translation_file_history_delete();

    // Remove local files. _po is matched due to testing.
    $files = $this->fileSystem->scanDirectory('translations://', '/.*\._?po$/', ['recurse' => FALSE]);
    foreach ($files as $file) {
      $this->logger()?->debug("Removing {%file}", ['%file' => $file->uri]);
      $this->fileSystem->unlink($file->uri);
    }

    // Get updates from localize.drupal.org.
    $this->logger()?->notice("Getting files from localize.drupal.org");
    $locale_config = $this->configFactory->getEditable('locale.settings');
    $locale_config->set('translation.default_server_pattern', LOCALE_TRANSLATION_DEFAULT_SERVER_PATTERN);
    $locale_config->save();
    $projects = array_keys(locale_translation_get_projects());
    $langcodes = array_keys(locale_translatable_language_list());

    $batch_builder = (new BatchBuilder())
      ->setTitle(t('Importing translations.'))
      ->setErrorMessage(t('Error importing translation files'))
      ->setFile($this->moduleHandler->getModule('locale')->getPath() . '/locale.batch.inc');
    $options = _locale_translation_default_update_options();
    $options['use_remote'] = TRUE;
    foreach ($projects as $project) {
      foreach ($langcodes as $langcode) {
        $batch_builder->addOperation('locale_translation_batch_status_check', [$project, $langcode, $options]);
        $batch_builder->addOperation('locale_translation_batch_fetch_download', [$project, $langcode]);
      }
    }
    batch_set($batch_builder->toArray());
    drush_backend_batch_process();

    // Get a list of projects so we can determine which translations have come
    // from drupal.org.
    drupal_static_reset('locale_translation_get_projects');
    $projects = locale_translation_get_projects();

    // Revert the server pattern to use only local files.
    $locale_config->set('translation.default_server_pattern', LOCALE_DEPLOY_TRANSLATION_DEFAULT_SERVER_PATTERN);
    $locale_config->save();

    // Remove versioning information from files from Drupal.org.
    $files = $this->fileSystem->scanDirectory('translations://', '/.*\.po$/');
    foreach ($files as $file) {
      if (preg_match('/([^-]*)(-.*)(\.[^\.]+\.[^\.]+)/', $file->filename, $matches)) {
        if (isset($projects[$matches[1]]) && $projects[$matches[1]]->server_pattern === LOCALE_TRANSLATION_DEFAULT_SERVER_PATTERN) {
          $new_name = $matches[1] . $matches[3];
          $this->logger()->debug("Renaming {%old} to {%new}", ['%old' => $file->filename, '%new' => $new_name]);
          $this->fileSystem->move($file->uri, 'translations://' . $new_name);
        }
      }
    }

    // Import the translations using the regular locale commands provided by
    // Drush.
    $this->doUpdates($self, $redispatchOptions, $manager);

    // Export configuration.
    $process = $manager->drush($self, 'config:export', [], $redispatchOptions);
    $process->mustRun($process->showRealtime());
  }

  /**
   * Updates custom code translations.
   *
   * @command locale-deploy:custom-translations
   *
   * @bootstrap max
   *
   * @usage drush locale-deploy:custom-translations
   *   Export .po files for custom modules.
   *
   * @throws \Exception
   *
   * @todo improve robustness and error reporting.
   */
  public function updateCustomTranslations(): void {
    $self = $this->siteAliasManager()->getSelf();
    $redispatchOptions = Drush::redispatchOptions();
    /** @var \Drush\SiteAlias\ProcessManager $manager */
    $manager = $this->processManager();

    // Install the POTX module in order to extract the strings.
    $process = $manager->drush($self, 'en', ['potx'], $redispatchOptions);
    $process->mustRun($process->showRealtime());

    $custom_directory = 'translations://custom';
    if (!$this->fileSystem->prepareDirectory($custom_directory, FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS)) {
      throw new \RuntimeException('Failed to create the directory: translations://custom. Check your locale.settings configuration.');
    }

    foreach (array_keys($this->languageManager->getLanguages()) as $langcode) {
      if (!locale_is_translatable($langcode)) {
        continue;
      }
      // Scan custom code to create the file.
      $process = $manager->drush($self, 'potx', ['single'], $redispatchOptions + [
        'folder' => 'modules/custom/',
        'language' => $langcode,
        'translations' => TRUE,
      ]);
      $process->mustRun($process->showRealtime());

      // Drush runs in Drupal root.
      if (!file_exists('general.pot')) {
        throw new \RuntimeException('Expected to be running Drupal root - working directory is: ' . getcwd());
      }
      // Remove comments from the file to make changes easier to review with
      // git.
      // @todo This would be even better if the translations were sorted
      //   alphabetically.
      $lines = file('general.pot');
      if ($lines === FALSE) {
        throw new \RuntimeException('Unable to read the general.pot file produced by the potx module');
      }
      $header = TRUE;
      foreach ($lines as $key => $line) {
        if (preg_match('/^#([ :])*modules\/custom\//', $line)) {
          unset($lines[$key]);
        }
        // Clean up header. Remove things that are not useful as the file should
        // be stored in version control.
        if ($header) {
          if (
            str_starts_with($line, '"Project-Id-Version: ') ||
            str_starts_with($line, '"Last-Translator: ') ||
            str_starts_with($line, '"POT-Creation-Date: ') ||
            str_starts_with($line, '"PO-Revision-Date: ') ||
            str_starts_with($line, '"Language-Team: ')
          ) {
            unset($lines[$key]);
          }
          // Disable header process on first msgid string with content.
          if (preg_match('/^msgid "([^"]+)"/', $line)) {
            $header = FALSE;
          }
        }
      }
      file_put_contents('general.pot', implode("", $lines));

      // Move the file to the expected location.
      $this->fileSystem->move('general.pot', 'translations://custom/custom.' . $langcode . '.po', FileSystemInterface::EXISTS_REPLACE);
    }

    // Uninstall the POTX module.
    $process = $manager->drush($self, 'pmu', ['potx'], $redispatchOptions);
    $process->mustRun($process->showRealtime());
  }

}
