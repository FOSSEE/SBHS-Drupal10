<?php

namespace Drupal\locale_deploy;

use Drupal\locale\LocaleProjectStorageInterface;

/**
 * Decorates the Locale project storage to manipulate the order.
 *
 * @todo Remove once https://www.drupal.org/project/drupal/issues/3403337 is
 *   fixed in Drupal core.
 */
final class LocaleProject implements LocaleProjectStorageInterface {

  /**
   * @var \Drupal\locale\LocaleProjectStorageInterface
   */
  private LocaleProjectStorageInterface $inner;

  public function __construct(LocaleProjectStorageInterface $inner) {
    $this->inner = $inner;
  }

  /**
   * {@inheritdoc}
   */
  public function get($key, $default = NULL) {
    return $this->inner->get($key, $default);
  }

  /**
   * {@inheritdoc}
   */
  public function getMultiple(array $keys) {
    return $this->inner->getMultiple($keys);
  }

  /**
   * {@inheritdoc}
   */
  public function set($key, $value) {
    $this->inner->set($key, $value);
  }

  /**
   * {@inheritdoc}
   */
  public function setMultiple(array $data) {
    $this->inner->setMultiple($data);
  }

  /**
   * {@inheritdoc}
   */
  public function delete($key) {
    $this->inner->delete($key);
  }

  /**
   * {@inheritdoc}
   */
  public function deleteMultiple(array $keys) {
    $this->inner->deleteMultiple($keys);
  }

  /**
   * {@inheritdoc}
   */
  public function getAll() {
    $projects = $this->inner->getAll();
    // Move our custom project to the end until
    if (isset($projects['locale_deploy.custom'])) {
      $project = $projects['locale_deploy.custom'];
      unset($projects['locale_deploy.custom']);
      $projects['locale_deploy.custom'] = $project;
    }
    return $projects;
  }

  /**
   * {@inheritdoc}
   */
  public function deleteAll() {
    $this->inner->deleteAll();
  }

  /**
   * {@inheritdoc}
   */
  public function disableAll() {
    $this->inner->disableAll();
  }

  /**
   * {@inheritdoc}
   */
  public function resetCache() {
    $this->inner->resetCache();
  }

  /**
   * {@inheritdoc}
   */
  public function countProjects() {
    return $this->inner->countProjects();
  }

}
