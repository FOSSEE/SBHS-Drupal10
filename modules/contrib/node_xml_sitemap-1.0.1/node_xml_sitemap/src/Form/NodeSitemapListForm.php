<?php

namespace Drupal\node_xml_sitemap\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * The NodeSitemapListForm for listing all the node sitemap url.
 */
class NodeSitemapListForm extends FormBase {

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new ContentTypeListingForm.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'content_type_listing_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    global $base_url;
    // Load all content types.
    $content_types = $this->entityTypeManager->getStorage('node_type')->loadMultiple();

    $form['content_types'] = [
      '#type' => 'table',
      '#header' => [
        $this->t('Content Type'),
        $this->t('Node Site Map URLs'),
      ],
    ];

    foreach ($content_types as $type) {
      $form['content_types'][$type->id()]['label'] = [
        '#markup' => $type->label(),
      ];
      $form['content_types'][$type->id()]['urs'] = [
        '#markup' => $base_url . '/node/' . $type->id() . '/sitemap.xml',
      ];
    }
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // This form does not submit data.
  }

}
