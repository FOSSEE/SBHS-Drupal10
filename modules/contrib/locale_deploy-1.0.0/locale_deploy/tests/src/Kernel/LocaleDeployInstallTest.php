<?php

declare(strict_types=1);

namespace Drupal\Tests\locale_deploy\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Tests the Locale Deploy module.
 *
 * @group locale_deploy
 */
class LocaleDeployInstallTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['user', 'language', 'locale'];

  /**
   * Tests installation of the Locale Deploy module.
   *
   * @see \locale_deploy_install()
   */
  public function testInstall(): void {
    $this->installConfig(['language', 'locale']);
    $this->assertSame(LOCALE_TRANSLATION_USE_SOURCE_REMOTE_AND_LOCAL, $this->config('locale.settings')->get('translation.use_source'));
    $this->config('locale.settings')
      ->set('translation.update_interval_days', 7)
      ->set('translation.overwrite_customized', TRUE)
      ->save();
    $this->container->get('module_installer')->install(['locale_deploy']);
    $this->assertSame(LOCALE_TRANSLATION_USE_SOURCE_LOCAL, $this->config('locale.settings')->get('translation.use_source'));
    $this->assertSame(0, $this->config('locale.settings')->get('translation.update_interval_days'));
    $this->assertFalse($this->config('locale.settings')->get('translation.overwrite_customized'));
  }

}
