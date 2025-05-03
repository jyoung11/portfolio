<?php

namespace Drupal\glightbox\Form;

use Drupal\Core\Asset\LibraryDiscoveryInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Extension\ModuleExtensionList;

/**
 * General configuration form for controlling the glightbox behaviour..
 */
class GLightboxSettingsForm extends ConfigFormBase {

  /**
   * The list of available modules.
   *
   * @var \Drupal\Core\Extension\ModuleExtensionList
   */
  protected $extensionListModule;

  /**
   * Library discovery service.
   *
   * @var \Drupal\Core\Asset\LibraryDiscoveryInterface
   */
  protected $libraryDiscovery;

  /**
   * A state that represents the custom settings being enabled.
   */
  const STATE_CUSTOM_SETTINGS = 0;

  /**
   * Drupal\Core\Extension\ModuleHandlerInterface definition.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Class constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The Configuration Factory.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $moduleHandler
   *   The module handler service.
   * @param \Drupal\Core\Extension\ModuleExtensionList $extension_list_module
   *   The list of available modules.
   * @param \Drupal\Core\Asset\LibraryDiscoveryInterface $libraryDiscovery
   *   The library discovery service.
   */
  public function __construct(ConfigFactoryInterface $config_factory,
                              ModuleHandlerInterface $moduleHandler,
                              ModuleExtensionList $extension_list_module,
                              LibraryDiscoveryInterface $libraryDiscovery) {
    parent::__construct($config_factory);
    $this->moduleHandler = $moduleHandler;
    $this->extensionListModule = $extension_list_module;
    $this->libraryDiscovery = $libraryDiscovery;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('module_handler'),
      $container->get('extension.list.module'),
      $container->get('library.discovery')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'glightbox_admin_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['glightbox.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    global $base_url;
    $module_path = $this->extensionListModule->getPath('glightbox');
    $img_folder_path = $base_url . '/' . $module_path . '/images/admin';

    $config = $this->configFactory->get('glightbox.settings');

    $form['glightbox_custom_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Options'),
      '#open' => TRUE,
    ];
    $form['glightbox_custom_settings']['glightbox_custom_settings_activate'] = [
      '#type' => 'radios',
      '#title' => $this->t('Options'),
      '#options' => [0 => $this->t('Default'), 1 => $this->t('Custom')],
      '#default_value' => $config->get('custom.activate') ?? 0,
      '#description' => $this->t('Use the default or custom options for GLightbox.'),
    ];
    $form['glightbox_custom_settings']['glightbox_open_effect'] = [
      '#type' => 'radios',
      '#title' => $this->t('Open effect'),
      '#options' => [
        'zoom' => $this->t('Zoom'),
        'fade' => $this->t('Fade'),
        'none' => $this->t('None'),
      ],
      '#default_value' => $config->get('custom.open_effect') ?? 'zoom',
      '#description' => $this->t('Name of the effect on lightbox open.'),
      '#states' => $this->getState(static::STATE_CUSTOM_SETTINGS),
    ];
    $form['glightbox_custom_settings']['glightbox_close_effect'] = [
      '#type' => 'radios',
      '#title' => $this->t('Close effect'),
      '#options' => [
        'zoom' => $this->t('Zoom'),
        'fade' => $this->t('Fade'),
        'none' => $this->t('None'),
      ],
      '#default_value' => $config->get('custom.close_effect') ?? 'zoom',
      '#description' => $this->t('Name of the effect on lightbox close.'),
      '#states' => $this->getState(static::STATE_CUSTOM_SETTINGS),
    ];
    $form['glightbox_custom_settings']['glightbox_slide_effect'] = [
      '#type' => 'radios',
      '#title' => $this->t('Slide effect'),
      '#options' => [
        'slide' => $this->t('Slide'),
        'fade' => $this->t('Fade'),
        'zoom' => $this->t('Zoom'),
        'none' => $this->t('None'),
      ],
      '#default_value' => $config->get('custom.slide_effect') ?? 'slide',
      '#description' => $this->t('Name of the effect on slide change.'),
      '#states' => $this->getState(static::STATE_CUSTOM_SETTINGS),
    ];
    $form['glightbox_custom_settings']['glightbox_width'] = [
      '#type' => 'textfield',
      '#title' => $this->t('width'),
      '#default_value' => $config->get('custom.width') ?? '98%',
      '#size' => 30,
      '#description' => $this->t('Set a width for loaded content. Example: "100%", 500, "500px".'),
      '#states' => $this->getState(static::STATE_CUSTOM_SETTINGS),
    ];
    $form['glightbox_custom_settings']['glightbox_height'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Height'),
      '#default_value' => $config->get('custom.height') ?? '98%',
      '#size' => 30,
      '#description' => $this->t('Set a height for loaded content. Example: "100%", 500, "500px".'),
      '#states' => $this->getState(static::STATE_CUSTOM_SETTINGS),
    ];
    $form['glightbox_custom_settings']['glightbox_videos_width'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Videos width'),
      '#default_value' => $config->get('custom.videos_width') ?? '',
      '#size' => 30,
      '#description' => $this->t('Default width for videos. Videos are responsive so height is not required. The width can be in px % or even vw for example, 500px, 90% or 100vw for full width videos'),
      '#states' => $this->getState(static::STATE_CUSTOM_SETTINGS),
    ];
    $form['glightbox_custom_settings']['glightbox_close_on_outside_click'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Overlay close'),
      '#default_value' => $config->get('custom.close_on_outside_click') ?? 1,
      '#description' => $this->t('Enable closing GLightbox by clicking on the background overlay.'),
      '#states' => $this->getState(static::STATE_CUSTOM_SETTINGS),
    ];
    $form['glightbox_custom_settings']['glightbox_more_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('See More text'),
      '#default_value' => $config->get('custom.glightbox_more_text') ?? '',
      '#size' => 30,
      '#description' => $this->t('More text for descriptions on mobile devices.'),
      '#states' => $this->getState(static::STATE_CUSTOM_SETTINGS),
    ];
    $form['glightbox_custom_settings']['glightbox_more_length'] = [
      '#type' => 'select',
      '#title' => $this->t('More text threshold'),
      '#options' => $this->optionsRange(0, 120, 5),
      '#default_value' => $config->get('custom.more_length') ?? 60,
      '#description' => $this->t('Number of characters to display on the description before adding the moreText link (only for mobiles), if 0 it will display the entire description.'),
      '#states' => $this->getState(static::STATE_CUSTOM_SETTINGS),
    ];
    $form['glightbox_custom_settings']['glightbox_desc_position'] = [
      '#type' => 'radios',
      '#title' => $this->t('Description position'),
      '#options' => [
        'bottom' => $this->t('Bottom'),
        'top' => $this->t('Top'),
        'left' => $this->t('Left'),
        'right' => $this->t('Right'),
      ],
      '#default_value' => $config->get('custom.desc_position') ?? 'bottom',
      '#description' => $this->t('Global position for slides description, you can define a specific position on each slide (bottom, top, left, right).'),
      '#states' => $this->getState(static::STATE_CUSTOM_SETTINGS),
    ];
    $form['glightbox_custom_settings']['glightbox_loop'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Loop'),
      '#default_value' => $config->get('custom.loop') ?? 0,
      '#description' => $this->t('Loop slides on end.'),
      '#states' => $this->getState(static::STATE_CUSTOM_SETTINGS),
    ];
    $form['glightbox_custom_settings']['glightbox_zoomable'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Zoomable'),
      '#default_value' => $config->get('custom.zoomable') ?? 1,
      '#description' => $this->t('Enable or disable zoomable images.'),
      '#states' => $this->getState(static::STATE_CUSTOM_SETTINGS),
    ];
    $form['glightbox_custom_settings']['glightbox_draggable'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Draggable') ?? 1,
      '#default_value' => $config->get('custom.draggable'),
      '#description' => $this->t('Enable or disable mouse drag to go prev and next slide (only images and inline content).'),
      '#states' => $this->getState(static::STATE_CUSTOM_SETTINGS),
    ];
    $form['glightbox_custom_settings']['glightbox_preload'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Preload'),
      '#default_value' => $config->get('custom.preload') ?? 1,
      '#description' => $this->t('Enable or disable preloading.'),
      '#states' => $this->getState(static::STATE_CUSTOM_SETTINGS),
    ];
    $form['glightbox_custom_settings']['glightbox_autoplay_videos'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Autoplay videos') ?? 1,
      '#default_value' => $config->get('custom.autoplay_videos'),
      '#description' => $this->t('Autoplay videos on open.'),
      '#states' => $this->getState(static::STATE_CUSTOM_SETTINGS),
    ];
    $form['glightbox_custom_settings']['glightbox_autofocus_videos'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Autofocus videos') ?? 0,
      '#default_value' => $config->get('custom.autofocus_videos'),
      '#description' => $this->t('If true video will be focused on play to allow keyboard sortcuts for the player, this will deactivate prev and next arrows to change slide so use it only if you know what you are doing.'),
      '#states' => $this->getState(static::STATE_CUSTOM_SETTINGS),
    ];

    $form['glightbox_advanced_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Advanced settings'),
    ];
    $form['glightbox_advanced_settings']['glightbox_unique_token'] = [
      '#type' => 'radios',
      '#title' => $this->t('Unique per-request gallery token'),
      '#options' => [1 => $this->t('On'), 0 => $this->t('Off')],
      '#default_value' => $config->get('advanced.unique_token') ?? 0,
      '#description' => $this->t('If On, GLightbox will add a unique per-request token to the gallery id to avoid images being added manually to galleries. The token was added as a security fix but some see the old behavoiur as an feature and this settings makes it possible to remove the token.'),
    ];
    $form['glightbox_advanced_settings']['glightbox_compression_type'] = [
      '#type' => 'radios',
      '#title' => $this->t('Choose GLightbox compression level'),
      '#options' => [
        'minified' => $this->t('Production (Minified)'),
        'source' => $this->t('Development (Uncompressed Code)'),
      ],
      '#default_value' => $config->get('advanced.compression_type') ?? 'minified',
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config = $this->configFactory->getEditable('glightbox.settings');

    $config
      ->set('custom.activate', $form_state->getValue('glightbox_custom_settings_activate'))
      ->set('custom.open_effect', $form_state->getValue('glightbox_open_effect'))
      ->set('custom.close_effect', $form_state->getValue('glightbox_close_effect'))
      ->set('custom.slide_effect', $form_state->getValue('glightbox_slide_effect'))
      ->set('custom.close_on_outside_click', $form_state->getValue('glightbox_close_on_outside_click'))
      ->set('custom.width', $form_state->getValue('glightbox_width'))
      ->set('custom.height', $form_state->getValue('glightbox_height'))
      ->set('custom.videos_width', $form_state->getValue('glightbox_videos_width'))
      ->set('custom.more_text', $form_state->getValue('glightbox_more_text'))
      ->set('custom.more_length', $form_state->getValue('glightbox_more_length'))
      ->set('custom.desc_position', $form_state->getValue('glightbox_desc_position'))
      ->set('custom.autoplay_videos', $form_state->getValue('glightbox_autoplay_videos'))
      ->set('custom.loop', $form_state->getValue('glightbox_loop'))
      ->set('custom.zoomable', $form_state->getValue('glightbox_zoomable'))
      ->set('custom.draggable', $form_state->getValue('glightbox_draggable'))
      ->set('custom.preload', $form_state->getValue('glightbox_preload'))
      ->set('custom.autoplay_videos', $form_state->getValue('glightbox_autoplay_videos'))
      ->set('custom.autofocus_videos', $form_state->getValue('glightbox_autofocus_videos'))
      ->set('advanced.unique_token', $form_state->getValue('glightbox_unique_token'))
      ->set('advanced.compression_type', $form_state->getValue('glightbox_compression_type'));

    $config->save();

    parent::submitForm($form, $form_state);
  }

  /**
   * Get one of the pre-defined states used in this form.
   *
   * @param string $state
   *   The state to get that matches one of the state class constants.
   *
   * @return array
   *   A corresponding form API state.
   */
  protected function getState($state) {
    $states = [
      static::STATE_CUSTOM_SETTINGS => [
        'visible' => [
          ':input[name="glightbox_custom_settings_activate"]' => ['value' => '1'],
        ],
      ],
    ];
    return $states[$state];
  }

  /**
   * Create a range for a series of options.
   *
   * @param int $start
   *   The start of the range.
   * @param int $end
   *   The end of the range.
   * @param int $step
   *   The interval between elements.
   *
   * @return array
   *   An options array for the given range.
   */
  protected function optionsRange($start, $end, $step) {
    $range = range($start, $end, $step);
    return array_combine($range, $range);
  }

}
