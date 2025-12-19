<?php

declare(strict_types=1);

namespace Drupal\Tests\locale_deploy\TestSite;

use Composer\InstalledVersions;
use Drupal\language\Entity\ConfigurableLanguage;
use Drupal\TestSite\TestPreinstallInterface;
use Drupal\TestSite\TestSetupInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Setup file used by TestSiteApplicationTest.
 *
 * @see \Drupal\Tests\Scripts\TestSiteApplicationTest
 */
class TestSiteLocaleDeployInstallMultipleLanguagesTestScript implements TestSetupInterface, TestPreinstallInterface {

  /**
   * {@inheritdoc}
   */
  public function preinstall($db_prefix, $site_directory): void {
  }

  /**
   * {@inheritdoc}
   */
  public function setup(): void {
    \Drupal::service('module_installer')->install(['locale_deploy', 'potx_test']);
    // Add languages.
    ConfigurableLanguage::createFromLangcode('de')->save();
    ConfigurableLanguage::createFromLangcode('fr')->save();
    // Set the path to use a Drupal root relative path.
    $abs_translation_path = realpath(InstalledVersions::getRootPackage()['install_path']) . '/translations';
    $drupal_root = realpath(dirname(InstalledVersions::getInstallPath('drupal/core')));
    \Drupal::configFactory()->getEditable('locale.settings')
      ->set('translation.path', (new Filesystem())->makePathRelative($abs_translation_path, $drupal_root))
      ->set('translate_english', TRUE)
      ->save();
  }

}
