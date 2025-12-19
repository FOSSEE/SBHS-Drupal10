<?php

declare(strict_types=1);

namespace Drupal\Tests\locale_deploy\Build;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

/**
 * Tests the locale-deploy:custom-translations drush command.
 *
 * @group locale_deploy
 */
class CustomTranslationsTest extends BuildTestBase {

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->copyCodebase();
    $fs = new Filesystem();
    $fs->chmod($this->getWorkspaceDrupalRoot() . '/sites/default', 0700, 0000);

    // Create the custom module from the fixture.
    $module_path = $this->getWorkspaceDrupalRoot() . "/modules/custom/potx_test";
    $fs->mkdir($module_path);
    $fs->copy(__DIR__ . '/../../fixtures/potx_test.module.txt', $module_path . '/potx_test.module');
    $fs->copy(__DIR__ . '/../../fixtures/potx_test.info.yml.txt', $module_path . '/potx_test.info.yml');

    // Gitlab CI puts contrib modules in custom. It's a bad decision but let's
    // deal with it.
    $module_path = $this->getWorkspaceDrupalRoot() . "/modules/custom/locale_deploy";
    if (is_dir($module_path)) {
      $fs->rename($module_path, $this->getWorkspaceDrupalRoot() . "/modules/contrib/locale_deploy");
    }

    // Composer tells you stuff in error output.
    $this->executeCommand('COMPOSER_DISCARD_CHANGES=true composer install --no-interaction');
    $this->assertErrorOutputContains('Generating autoload files');
  }

  /**
   * Tests command with a single language.
   */
  public function testDrushCommandWithSingleLanguage(): void {
    $connection_details = $this->installDrupal(__DIR__ . '/../TestSite/TestSiteLocaleDeployInstallTestScript.php');

    $this->assertFileDoesNotExist($this->getWorkspaceDirectory() . '/translations/custom/custom.de.po');

    // Run the Drush command to create custom translation files.
    $drush_process = Process::fromShellCommandline('./vendor/bin/drush locale-deploy:custom-translations');
    $drush_process->setWorkingDirectory($this->getWorkingPath())
      ->setTimeout(300)
      ->setIdleTimeout(300)
      ->setEnv(['HTTP_USER_AGENT' => $connection_details['user_agent']]);
    $drush_process->run();
    $this->assertEquals(0, $drush_process->getExitCode(),
      'COMMAND: ' . $drush_process->getCommandLine() . "\n" .
      'OUTPUT: ' . $drush_process->getOutput() . "\n" .
      'ERROR: ' . $drush_process->getErrorOutput() . "\n"
    );

    $this->assertFileExists($this->getWorkspaceDirectory() . '/translations/custom/custom.de.po');

    $expected_contents = <<<'EOT'
# $Id$
#
# German translation of Drupal (general)
# Copyright YEAR NAME <EMAIL@ADDRESS>
# Generated from files:
#
#, fuzzy
msgid ""
msgstr ""
"MIME-Version: 1.0\n"
"Content-Type: text/plain; charset=utf-8\n"
"Content-Transfer-Encoding: 8bit\n"
"Plural-Forms: nplurals=2; plural=(n != 1);\n"

msgid "TranslatableMarkup string"
msgstr ""

msgid "Another translatableMarkup string"
msgstr ""

msgid "Potx test"
msgstr ""

msgid "Testing"
msgstr ""


EOT;

    $this->assertSame($expected_contents, file_get_contents($this->getWorkspaceDirectory() . '/translations/custom/custom.de.po'));
  }

  /**
   * Tests command with multiple languages.
   */
  public function testDrushCommandWithMultipleLanguages(): void {
    $connection_details = $this->installDrupal(__DIR__ . '/../TestSite/TestSiteLocaleDeployInstallMultipleLanguagesTestScript.php');

    $this->assertFileDoesNotExist($this->getWorkspaceDirectory() . '/translations/custom/custom.de.po');
    $this->assertFileDoesNotExist($this->getWorkspaceDirectory() . '/translations/custom/custom.en.po');
    $this->assertFileDoesNotExist($this->getWorkspaceDirectory() . '/translations/custom/custom.fr.po');

    // Run the Drush command to create custom translation files.
    $drush_process = Process::fromShellCommandline('./vendor/bin/drush locale-deploy:custom-translations');
    $drush_process->setWorkingDirectory($this->getWorkingPath())
      ->setTimeout(300)
      ->setIdleTimeout(300)
      ->setEnv(['HTTP_USER_AGENT' => $connection_details['user_agent']]);
    $drush_process->run();
    $this->assertEquals(0, $drush_process->getExitCode(),
      'COMMAND: ' . $drush_process->getCommandLine() . "\n" .
      'OUTPUT: ' . $drush_process->getOutput() . "\n" .
      'ERROR: ' . $drush_process->getErrorOutput() . "\n"
    );

    $this->assertFileExists($this->getWorkspaceDirectory() . '/translations/custom/custom.de.po');
    $this->assertFileExists($this->getWorkspaceDirectory() . '/translations/custom/custom.en.po');
    $this->assertFileExists($this->getWorkspaceDirectory() . '/translations/custom/custom.fr.po');
  }

  /**
   * @param $custom_setup_file
   *   Path to custom setup file.
   *
   * @return array
   *   The connection details.
   */
  private function installDrupal(string $custom_setup_file): array {
    // We have to stand up the server first so we can know the port number to
    // pass along to the install command.
    $this->standUpServer();

    // Install Drupal.
    $php_finder = new PhpExecutableFinder();
    $install_command = [
      $php_finder->find(),
      './core/scripts/test-site.php',
      'install',
      '--base-url=http://localhost:' . $this->getPortNumber(),
      '--db-url="' . getenv('SIMPLETEST_DB') . '"',
      '--install-profile=minimal',
      '--json',
      '--setup-file ' . $custom_setup_file,
    ];
    $command = $this->executeCommand(implode(' ', $install_command), $this->getWorkingPathDrupalRoot());
    $this->assertCommandSuccessful();
    $this->assertNotEmpty($output_json = $command->getOutput(),
      'COMMAND: ' . $command->getCommandLine() . "\n" .
      'OUTPUT: ' . $command->getOutput() . "\n" .
      'ERROR: ' . $command->getErrorOutput() . "\n"
    );
    return json_decode($output_json, TRUE);
  }

}
