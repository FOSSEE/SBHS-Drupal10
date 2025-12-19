<?php

namespace Drupal\node_xml_sitemap\Controller;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * The NodeXmlSitemapController class for generating sitemap for nodes.
 */
class NodeXmlSitemapController extends ControllerBase {

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a NodeXmlSitemapController object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, ConfigFactoryInterface $config_factory) {
    $this->entityTypeManager = $entity_type_manager;
    $this->configFactory = $config_factory;
  }

  /**
   * Renders the sitemap XML for a given content type.
   *
   * @param string $type
   *   The content type for which to generate the sitemap.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   The XML response.
   */
  public function renderNodeSitemapXml($type = '') {

    // Load the nodes of the specified content type.
    $nodes = $this->entityTypeManager->getStorage('node')->loadByProperties(['type' => $type, 'status' => 1]);

    // Array key value for change frequency.
    $changefreqOptions = [
      '60' => 'always',
      '3600' => 'hourly',
      '86400' => 'daily',
      '604800' => 'weekly',
      '2419200' => 'monthly',
      '31449600' => 'yearly',
    ];

    // Start building the XML output.
    $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset></urlset>');
    $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

    // Fetching sitemap configurations.
    $config = $this->configFactory->get("xmlsitemap.settings.node." . $type)->get();
    $changefreqValue = $config['changefreq'] ?? '60';
    foreach ($nodes as $node) {
      $url = $xml->addChild('url');
      $url->addChild('loc', $node->toUrl('canonical', ['absolute' => TRUE])->toString());
      $url->addChild('lastmod', gmdate('Y-m-d\TH:i:s\Z', $node->getChangedTime()));
      $url->addChild('priority', $config['priority'] ?? 0.5);
      $url->addChild('changefreq', $changefreqOptions[$changefreqValue]);
    }

    // Create the response object and set the headers.
    $response = new Response($xml->asXML());
    $response->headers->set('Content-Type', 'application/xml');
    return $response;
  }

}
