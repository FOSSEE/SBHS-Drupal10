<?php

declare(strict_types=1);

namespace Drupal\Tests\locale_deploy\Functional;

// cspell:ignore aujourd\'hui avril benutzerkonto februar février heute hier
// cspell:ignore januar janvier juin juni marz menü nicht

use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\StreamWrapper\PublicStream;
use Drupal\locale\TranslationString;
use Drupal\Tests\locale\Functional\LocaleUpdateBase;
use Drush\TestTraits\DrushTestTrait;

/**
 * Tests locale-deploy:localize-translations and post updatedb drush commands.
 *
 * @group locale_deploy
 */
class LocaleDeployDrushTest extends LocaleUpdateBase {

  use DrushTestTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['locale_deploy', 'localedeploy_test'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $admin_user = $this->drupalCreateUser([
      'administer modules',
      'administer site configuration',
      'administer languages',
      'access administration pages',
      'translate interface',
    ]);
    $this->drupalLogin($admin_user);
    // We use German as test language. This language must match the translation
    // file that come with the locale_test module (test.de.po) and can therefore
    // not be chosen randomly.
    $this->addLanguage('de');
    $this->resetAll();
    // Remove config from locale_test that gets in the way.
    $this->config('locale_test.translation')->delete();
    $this->config('locale_test.translation_multiple')->delete();

    $config = $this->config('locale.settings');

    // A flag is set to let the locale_test module replace the project data with
    // a set of test projects which match the below project files.
    \Drupal::state()->set('locale.test_projects_alter', TRUE);
    \Drupal::state()->set('locale.remove_core_project', FALSE);

    // Setup the environment.
    $public_path = PublicStream::basePath();
    $this->setTranslationsDirectory($public_path . '/local');
    $config->set('translation.default_filename', '%project-%version.%language._po')->save();
  }

  /**
   * Tests basic drush command functionality.
   */
  public function testBasicCommands() {
    $this->doTestLocalizeTranslationsCommandNoCustomTranslations();

    // The test randomly fails on DrupalCI maybe due to more powerful hardware.
    // Given the number of tests as small wait is harmless here.
    sleep(1);

    $this->doTestLocaleDeployCommand();
  }

  /**
   * Tests locale-deploy:localize-translations command basic functionality.
   *
   * @see \Drupal\locale_deploy\Commands\LocaleDeployCommands::getTranslations()
   */
  public function doTestLocalizeTranslationsCommandNoCustomTranslations(): void {
    $this->setUpRemoteTranslations('de');

    // Export active config to sync.
    $this->copyConfig($this->container->get('config.storage'), $this->container->get('config.storage.sync'));

    // Get status of translation sources at local file system.
    $this->drupalGet('admin/reports/translations/check');
    $result = locale_translation_get_status();
    $this->assertEquals('', $result['contrib_module_one']['de']->type, 'Translation of contrib_module_one not found');
    $this->assertEquals('', $result['contrib_module_two']['de']->type, 'Translation of contrib_module_two not found');
    $this->assertEquals(LOCALE_TRANSLATION_LOCAL, $result['locale_test']['de']->type, 'Translation of locale_test found');
    $this->assertEquals('', $result['custom_module_one']['de']->type, 'Translation of custom_module_one not found');

    $this->drush('locale-deploy:localize-translations', ['-vvv'], ['uri' => $this->baseUrl]);
    $this->assertStringContainsString('[notice] Message: 4 translation files imported.', $this->getErrorOutput());
    $this->assertStringContainsString('[notice] Message: No configuration objects have been updated.', $this->getErrorOutput());
    $this->rebuildAll();
    $result = locale_translation_get_status();
    $this->assertEquals(LOCALE_TRANSLATION_CURRENT, $result['contrib_module_one']['de']->type, 'Translation of contrib_module_one found');
    $this->assertEquals(LOCALE_TRANSLATION_CURRENT, $result['contrib_module_two']['de']->type, 'Translation of contrib_module_two found');
    $this->assertEquals(LOCALE_TRANSLATION_CURRENT, $result['locale_test']['de']->type, 'Translation of locale_test found');
    $this->assertEquals('', $result['custom_module_one']['de']->type, 'Translation of custom_module_one not found');
  }

  /**
   * Tests post updatedb command basic functionality by running deploy.
   *
   * @see \Drupal\locale_deploy\Commands\LocaleDeployCommands::postUpdateDbHook()
   */
  public function doTestLocaleDeployCommand(): void {
    $translations_one = [
      '@site is currently under maintenance. We should be back shortly. Thank you for your patience.' => 'Heute nicht hier!',
      'User account menu' => 'User account menu (de)',
    ];
    $this->makePoFile('remote/all/contrib_module_one', "contrib_module_one-8.x-1.1.de._po", $this->timestampNow, $translations_one);
    copy('public://remote/all/contrib_module_one/contrib_module_one-8.x-1.1.de._po', 'translations://contrib_module_one-8.x-1.1.de._po');
    $config = $this->container->get('config.storage.sync')->createCollection('language.de');
    $config->write('system.maintenance', ['message' => 'Heute nicht hier!']);
    $config->write('system.menu.account', ['label' => 'Benutzerkonto-Menü']);

    $this->drush('deploy', ['-vvv'], ['uri' => $this->baseUrl]);
    $this->assertStringContainsString('[notice] Running post updatedb locale deploy to ensure translations are up-to-date with po files.', $this->getErrorOutput());
    $this->assertStringContainsString('[notice] Message: One translation file imported.', $this->getErrorOutput());
    $this->rebuildAll();
    /** @var \Drupal\locale\StringDatabaseStorage $storage */
    $storage = \Drupal::service('locale.storage');
    $translation = $storage->findTranslation(['language' => 'de', 'source' => '@site is currently under maintenance. We should be back shortly. Thank you for your patience.']);
    $this->assertInstanceOf(TranslationString::class, $translation);
    $this->assertSame('Heute nicht hier!', $translation->translation);
    $this->assertFalse((bool) $translation->customized);

    $translation = $storage->findTranslation(['language' => 'de', 'source' => 'User account menu']);
    $this->assertInstanceOf(TranslationString::class, $translation);
    $this->assertSame('Benutzerkonto-Menü', $translation->translation);
    $this->assertTrue((bool) $translation->customized);
  }

  /**
   * Tests command with a custom translation file.
   */
  public function testLocalizeTranslationsCommandWithCustomTranslations(): void {
    $this->setUpRemoteTranslations('de');

    // Set up custom translation.
    $custom_path = PublicStream::basePath() . '/local/custom';
    \Drupal::service('file_system')->prepareDirectory($custom_path, FileSystemInterface::CREATE_DIRECTORY);
    $translations = ['@site is currently under maintenance. We should be back shortly. Thank you for your patience.' => 'Not here today!'];
    $this->makePoFile('local/custom', 'custom.de.po', $this->timestampNew, $translations);

    $translations = [];
    $translations['@site is currently under maintenance. We should be back shortly. Thank you for your patience.'] = 'Yeah, right.';
    $translations['Testing testing testing!'] = 'Test test test!';
    $this->makePoFile('local/custom', 'zzzzz.de.po', $this->timestampNew, $translations);

    // Export active config to sync.
    $this->copyConfig($this->container->get('config.storage'), $this->container->get('config.storage.sync'));

    // Ensure the expected configuration change occurs.
    $this->drush('locale-deploy:localize-translations', [], ['uri' => $this->baseUrl]);
    $this->assertStringContainsString('[notice] Message: 6 translation files imported.', $this->getErrorOutput());
    $this->assertStringContainsString('| language.de | system.maintenance | Create', $this->getErrorOutput(), 'Translated configuration is created.');

    // Ensure that custom translations provided by the locale_deploy module come
    // last.
    $this->rebuildAll();
    $this->assertSame('Test test test!', (string) t('Testing testing testing!', [], ['langcode' => 'de']));
    $this->assertSame('Not here today!', (string) t('@site is currently under maintenance. We should be back shortly. Thank you for your patience.', [], ['langcode' => 'de']));
  }

  /**
   * Tests command with multiple translations.
   */
  public function testLocalizeTranslationsCommandWithMultiple(): void {
    $this->addLanguage('fr');
    $this->setUpRemoteTranslations('de');
    $this->setUpRemoteTranslations('fr');

    // Set up custom translation.
    $custom_path = PublicStream::basePath() . '/local/custom';
    \Drupal::service('file_system')->prepareDirectory($custom_path, FileSystemInterface::CREATE_DIRECTORY);
    $translations = ['@site is currently under maintenance. We should be back shortly. Thank you for your patience.' => 'Heute nicht hier!'];
    $this->makePoFile('local/custom', 'custom.de.po', $this->timestampNew, $translations);
    $translations = ['@site is currently under maintenance. We should be back shortly. Thank you for your patience.' => 'Pas ici aujourd\'hui!'];
    $this->makePoFile('local/custom', 'custom.fr.po', $this->timestampNew, $translations);

    // Export active config to sync.
    $this->copyConfig($this->container->get('config.storage'), $this->container->get('config.storage.sync'));

    // Get status of translation sources at local file system.
    $this->drupalGet('admin/reports/translations/check');
    $result = locale_translation_get_status();
    $this->assertEquals('', $result['contrib_module_one']['fr']->type, 'Translation of contrib_module_one not found');
    $this->assertEquals('', $result['contrib_module_two']['fr']->type, 'Translation of contrib_module_two not found');

    $this->drush('locale-deploy:localize-translations', ['-vvv'], ['uri' => $this->baseUrl]);
    $this->assertStringContainsString('[notice] Message: 9 translation files imported.', $this->getErrorOutput());
    $this->assertStringContainsString('| language.de | system.maintenance | Create', $this->getErrorOutput(), 'Translated configuration is created.');
    $this->assertStringContainsString('| language.fr | system.maintenance | Create', $this->getErrorOutput(), 'Translated configuration is created.');

    $this->rebuildAll();
    $result = locale_translation_get_status();
    $this->assertEquals(LOCALE_TRANSLATION_CURRENT, $result['contrib_module_one']['fr']->type, 'Translation of contrib_module_one found');
    $this->assertEquals(LOCALE_TRANSLATION_CURRENT, $result['contrib_module_two']['fr']->type, 'Translation of contrib_module_two found');
  }

  /**
   * Sets up remote translations.
   *
   * @param $langcode
   *   The langcode to set up translations for,
   */
  private function setUpRemoteTranslations(string $langcode): void {
    // Setting up sets of translations for the translation files.
    $translations_one = [
      'de' => ['January' => 'Januar_1', 'February' => 'Februar_1', 'March' => 'Marz_1'],
      'fr' => ['January' => 'Janvier_1', 'February' => 'Février_1', 'March' => 'Mars_1'],
    ];
    $translations_two = [
      'de' => ['February' => 'Februar_2', 'March' => 'Marz_2', 'April' => 'April_2'],
      'fr' => ['February' => 'Février_2', 'March' => 'Mars_2', 'April' => 'Avril_2'],
    ];
    $translations_three = [
      'de' => ['April' => 'April_3', 'May' => 'Mai_3', 'June' => 'Juni_3'],
      'fr' => ['April' => 'Avril_3', 'May' => 'Mai_3', 'June' => 'Juin_3'],
    ];

    // Add a number of files to the local file system to serve as remote
    // translation server and match the project definitions set in
    // locale_test_locale_translation_projects_alter().
    $this->makePoFile('remote/all/contrib_module_one', "contrib_module_one-8.x-1.1.$langcode._po", $this->timestampNew, $translations_one[$langcode]);
    $this->makePoFile('remote/all/contrib_module_two', "contrib_module_two-8.x-2.0-beta4.$langcode._po", $this->timestampOld, $translations_two[$langcode]);
    $this->makePoFile('remote/all/contrib_module_three', "contrib_module_three-8.x-1.0.$langcode._po", $this->timestampOld, $translations_three[$langcode]);

  }

}
