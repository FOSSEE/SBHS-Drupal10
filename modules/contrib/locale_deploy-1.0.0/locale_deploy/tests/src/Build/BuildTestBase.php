<?php

declare(strict_types=1);

namespace Drupal\Tests\locale_deploy\Build;

use Composer\InstalledVersions;
use Drupal\BuildTests\Framework\BuildTestBase as CoreBuildTestBase;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;
use Symfony\Component\Finder\Finder;

/**
 * @todo Remove https://www.drupal.org/project/drupal/issues/3403382 once lands.
 */
abstract class BuildTestBase extends CoreBuildTestBase {

  /**
   * {@inheritdoc}
   */
  public function copyCodebase(?\Iterator $iterator = NULL, $working_dir = NULL) {
    $working_path = $this->getWorkingPath($working_dir);

    if ($iterator === NULL) {
      $iterator = $this->getCodebaseFinder()->getIterator();
    }

    $fs = new SymfonyFilesystem();
    $options = ['override' => TRUE, 'delete' => FALSE];
    $fs->mirror($this->getComposerRoot(), $working_path, $iterator, $options);
  }

  /**
   * {@inheritdoc}
   */
  public function getCodebaseFinder() {
    $drupal_root = $this->getWorkingPathDrupalRoot() ?? '';
    $finder = new Finder();
    $finder->files()
      ->followLinks()
      ->ignoreUnreadableDirs()
      ->in($this->getComposerRoot())
      ->notPath("#^{$drupal_root}sites/default/files#")
      ->notPath("#^{$drupal_root}sites/simpletest#")
      ->notPath("#^{$drupal_root}core/node_modules#")
      ->notPath("#^{$drupal_root}sites/default/settings\..*php#")
      ->ignoreDotFiles(FALSE)
      ->ignoreVCS(FALSE);
    return $finder;
  }

  /**
   * {@inheritdoc}
   */
  public function getDrupalRoot() {
    $core = InstalledVersions::getInstallPath('drupal/core');
    return $core ? realpath(dirname($core)) : NULL;
  }

  /**
   * Gets the path to the Composer root directory.
   *
   * @return string
   *   The absolute path to the Composer root directory.
   */
  public function getComposerRoot(): string {
    $root = InstalledVersions::getRootPackage();
    return realpath($root['install_path']);
  }

  /**
   * Gets the path to Drupal root in the workspace directory.
   *
   * @return string
   *   The absolute path to the Drupal root directory in the workspace.
   */
  public function getWorkspaceDrupalRoot(): string {
    $dir = $this->getWorkspaceDirectory();
    $drupal_root = $this->getWorkingPathDrupalRoot();
    if ($drupal_root !== NULL) {
      $dir = $dir . DIRECTORY_SEPARATOR . $drupal_root;
    }
    return $dir;
  }

  /**
   * Gets the working path for Drupal core.
   *
   * @return string|null
   *   The relative path to Drupal's root directory or NULL if it is the same
   *   as the composer root directory.
   */
  public function getWorkingPathDrupalRoot(): ?string {
    $composer_root = $this->getComposerRoot();
    $drupal_root = $this->getDrupalRoot();
    if ($composer_root === $drupal_root) {
      return NULL;
    }
    return (new SymfonyFilesystem())->makePathRelative($drupal_root, $composer_root);
  }

}
