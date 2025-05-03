<?php

namespace Drupal\mobile_detect\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Mobile Detect' status block for dev purposes.
 *
 * @Block(
 *   id = "mobile_detect_status_block",
 *   admin_label = @Translation("Mobile Detect Status")
 * )
 */
class MobileDetectStatusBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Creates a MobileDetectStatusBlock Block instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ModuleHandlerInterface $module_handler) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->moduleHandler = $module_handler;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('module_handler'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $renderable = [
      '#theme' => 'mobile_detect_status_block',
      '#internal_cache' => $this->internalCacheStatus(),
    ];

    return $renderable;
  }

  /**
   * Returns true if "Internal Page Cache" module is enabled.
   */
  private function internalCacheStatus() {
    $enabled = FALSE;
    if ($this->moduleHandler->moduleExists('cache_page')) {
      $enabled = TRUE;
    }
    return $enabled;
  }

}
