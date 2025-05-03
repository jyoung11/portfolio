<?php

namespace Drupal\glightbox;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Installer\InstallerKernel;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * An implementation of PageAttachmentInterface for the glightbox library.
 */
class GLightboxAttachment implements ElementAttachmentInterface {

  use StringTranslationTrait;

  /**
   * The service to determine if glightbox should be activated.
   *
   * @var \Drupal\glightbox\ActivationCheckInterface
   */
  protected $activation;

  /**
   * The module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * The glightbox settings.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $settings;

  /**
   * Create an instance of GLightboxAttachment.
   */
  public function __construct(ActivationCheckInterface $activation, ModuleHandlerInterface $module_handler, ConfigFactoryInterface $config) {
    $this->activation = $activation;
    $this->moduleHandler = $module_handler;
    $this->settings = $config->get('glightbox.settings');
  }

  /**
   * {@inheritdoc}
   */
  public function isApplicable() {
    return !InstallerKernel::installationAttempted() && $this->activation->isActive();
  }

  /**
   * {@inheritdoc}
   */
  public function attach(array &$page) {
    if ($this->settings->get('custom.activate')) {
      $js_settings = [
        'openEffect' => $this->settings->get('custom.open_effect') ?? 'zoom',
        'closeEffect' => $this->settings->get('custom.close_effect') ?? 'zoom',
        'slideEffect' => $this->settings->get('custom.slide_effect') ?? 'slide',
        'closeOnOutsideClick' => (bool) $this->settings->get('custom.close_on_outside_click'),
        'width' => $this->settings->get('custom.width') ?? '98%',
        'height' => $this->settings->get('custom.height') ?? '98%',
        'videosWidth' => $this->settings->get('custom.videos_width') ?? '',
        'moreText' => $this->settings->get('custom.more_text') ?? '',
        'descPosition' => $this->settings->get('custom.desc_position') ?? 'bottom',
        'loop' => (bool) $this->settings->get('custom.loop'),
        'zoomable' => (bool) $this->settings->get('custom.zoomable'),
        'draggable' => (bool) $this->settings->get('custom.draggable'),
        'preload' => (bool) $this->settings->get('custom.preload'),
        'autoplayVideos' => (bool) $this->settings->get('custom.autoplay_videos'),
        'autofocusVideos' => (bool) $this->settings->get('custom.autofocus_videos'),
      ];
    }
    else {
      $js_settings = [
        'width' => '98%',
        'height' => '98%',
      ];
    }

    // Give other modules the possibility to override GLightbox settings.
    $this->moduleHandler->alter('glightbox_settings', $js_settings);

    // Add glightbox js settings.
    $page['#attached']['drupalSettings']['glightbox'] = $js_settings;

    // Add and initialise the GLightbox plugin.
    if ($this->settings->get('advanced.compression_type') == 'minified') {
      $page['#attached']['library'][] = 'glightbox/glightbox';
    }
    else {
      $page['#attached']['library'][] = 'glightbox/glightbox-dev';
    }

    $page['#attached']['library'][] = "glightbox/init";
  }

}
