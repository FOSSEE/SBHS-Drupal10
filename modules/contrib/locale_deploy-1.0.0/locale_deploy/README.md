# Locale deploy

## Contents
* Introduction
* Requirements
* Installation
* Usage

## Introduction
Translations for Drupal core and contrib modules come from localize.drupal.org.
In traditional Drupal, you update translations by either running some Drush
commands or clicking around in the UI. This gives a site little to no visibility
about the new translations being added. Also it can mean that you're making
changes to a live site outside a deployment. Configuration and locale strings
are tied together and changes in one can result in changes in the other.

This module enables translations to follow the same deployment path as code and
configuration.

**Note:** This is about how to deploy locale strings and does not interact in
anyway with content translation.

## Requirements
* Custom code is located in modules/custom

## Installation
Install as you would normally install a contributed Drupal module.

On install this module will make adjustments to locale.settings configuration to
ensure translation can be deployment and managed like code and configuration.
These changes are to:
* ensure that non customized translations can be overridden.
* prevent customized translations from being overridden.
* ensure that your site no longer looks for new translations when cron is run.
* prevent getting new translations from localize.drupal.org through any other
means than the provided drush command.

## Usage
This module prevents users from changing locale.settings via the user interface.
The preferred way to manage translations is via Drush.

The module provides the following commands:
* locale-deploy:localize-translations
* locale-deploy:custom-translations

Additionally, the module hooks into the updatedb command to ensure that
translations are updated during a `drush deploy` command.

The `locale-deploy:localize-translations` command gets translations from
localize.drupal.org for your site. It places them in your local translations
folder. It also updates the site's translations in the database and exports
configuration so that all files are correct after the translations have been
updated.

The `locale-deploy:custom-translations` command scans the `modules/custom`
folder to extract any translations there. It will copy them to the custom folder
in your local translations folder. There will be one file per language enabled
on the site.

### Overriding translations
The module ensures that translations in translations/custom are processed last
and can override translations from core and contrib modules. For example, if you
want to override the translation of 'Paragraphs' you should:

1. Ensure the string appears in your custom modules. If it does not then add a
function to one of your custom modules like:
```php
function _modulename_will_never_be_called(): void {
  // Remember to include context in the options if necessary.
  t('Paragraphs');
}
```
2. Run `drush locale-deploy:custom-translations`
3. Update the 'Paragraphs' translation to your desired string in the
translations/custom/custom.LANGCODE.po file.
