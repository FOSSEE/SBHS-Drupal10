<?php

declare(strict_types=1);

namespace Drupal\Tests\locale_deploy\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests locale_deploy module.
 *
 * @group locale_deploy
 */
class LocaleDeployTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['locale_deploy'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * @see locale_deploy_form_locale_translate_settings_alter()
   */
  public function testFormAlter(): void {
    $this->drupalLogin($this->drupalCreateUser(['translate interface']));
    $this->drupalGet('admin/config/regional/translate/settings');
    $this->assertSession()->fieldDisabled('update_interval_days');
    $this->assertSession()->fieldDisabled('use_source');
    $this->assertSession()->fieldDisabled('overwrite');
    $this->assertSession()->elementTextContains('css', '#edit-update-interval-days--wrapper--description', 'This setting is managed by the locale deploy module and its Drush commands.');
    $this->assertSession()->elementTextContains('css', '#edit-use-source--wrapper--description', 'This setting is managed by the locale deploy module and its Drush commands.');
    $this->assertSession()->elementTextContains('css', '#edit-overwrite--wrapper--description', 'This setting is managed by the locale deploy module and its Drush commands.');
  }

  /**
   * @see locale_deploy_requirements()
   */
  public function testRequirements(): void {
    $this->drupalLogin($this->drupalCreateUser(['administer site configuration']));
    $this->drupalGet('admin/reports/status');
    $this->assertSession()->pageTextNotContains('Locale Deploy status');

    // Incorrect translation.use_source.
    $this->config('locale.settings')->set('translation.use_source', LOCALE_TRANSLATION_USE_SOURCE_REMOTE_AND_LOCAL)->save();
    $this->drupalGet('admin/reports/status');
    $this->assertSession()->pageTextContains('Locale Deploy status');
    $this->assertSession()->pageTextContains('Fix settings by running the following Drush command: drush php:eval "_locale_deploy_config_fix();"');
    _locale_deploy_config_fix();
    $this->drupalGet('admin/reports/status');
    $this->assertSession()->pageTextNotContains('Locale Deploy status');

    // Incorrect translation.update_interval_days.
    $this->config('locale.settings')->set('translation.update_interval_days', 7)->save();
    $this->drupalGet('admin/reports/status');
    $this->assertSession()->pageTextContains('Locale Deploy status');
    _locale_deploy_config_fix();
    $this->drupalGet('admin/reports/status');
    $this->assertSession()->pageTextNotContains('Locale Deploy status');

    // Incorrect translation.default_server_pattern.
    $this->config('locale.settings')->set('translation.default_server_pattern', LOCALE_TRANSLATION_DEFAULT_SERVER_PATTERN)->save();
    $this->drupalGet('admin/reports/status');
    $this->assertSession()->pageTextContains('Locale Deploy status');
    _locale_deploy_config_fix();
    $this->drupalGet('admin/reports/status');
    $this->assertSession()->pageTextNotContains('Locale Deploy status');

    // Incorrect translation.overwrite_customized.
    $this->config('locale.settings')->set('translation.overwrite_customized', TRUE)->save();
    $this->drupalGet('admin/reports/status');
    $this->assertSession()->pageTextContains('Locale Deploy status');
    _locale_deploy_config_fix();
    $this->drupalGet('admin/reports/status');
    $this->assertSession()->pageTextNotContains('Locale Deploy status');

    // Incorrect translation.overwrite_not_customized.
    $this->config('locale.settings')->set('translation.overwrite_not_customized', FALSE)->save();
    $this->drupalGet('admin/reports/status');
    $this->assertSession()->pageTextContains('Locale Deploy status');
    _locale_deploy_config_fix();
    $this->drupalGet('admin/reports/status');
    $this->assertSession()->pageTextNotContains('Locale Deploy status');
  }

}
