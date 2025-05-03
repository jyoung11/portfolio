<?php

namespace Drupal\ebt_hero\Plugin\Field\FieldWidget;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ebt_basic_button\Plugin\Field\FieldWidget\EbtSettingsBasicButtonWidget;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'ebt_settings_hero' widget.
 *
 * @FieldWidget(
 *   id = "ebt_settings_hero",
 *   label = @Translation("EBT Hero settings"),
 *   field_types = {
 *     "ebt_settings"
 *   }
 * )
 */
class EbtSettingsHeroWidget extends EbtSettingsBasicButtonWidget {

  /**
   * The EBT Core configuration.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $config;

  /**
   * Constructs a new GenerateCSS object.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param array $settings
   *   The widget settings.
   * @param array $third_party_settings
   *   Any third party settings settings.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   Config factory.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, array $third_party_settings, ConfigFactoryInterface $config_factory) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $third_party_settings);
    $this->config = $config_factory->get('ebt_core.settings');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($plugin_id, $plugin_definition, $configuration['field_definition'], $configuration['settings'], $configuration['third_party_settings'], $container->get('config.factory'));
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $element['ebt_settings']['pass_options_to_javascript'] = [
      '#type' => 'hidden',
      '#value' => FALSE,
    ];

    $element['ebt_settings']['button_styles'] = [
      '#type' => 'html_tag',
      '#tag' => 'h3',
      '#value' => $this->t('Button styles:'),
      '#weight' => -1,
    ];

    $element['ebt_settings']['styles'] = [
      '#title' => $this->t('Styles'),
      '#type' => 'radios',
      '#options' => [
        'two_columns' => $this->t('2 Columns'),
        'one_column' => $this->t('One column'),
      ],
      '#default_value' => $items[$delta]->ebt_settings['styles'] ?? 'two_columns',
      '#description' => $this->t('Select predefined styles for Hero block.'),
      '#weight' => -20,
    ];

    $element['ebt_settings']['overlay'] = [
      '#title' => $this->t('Add overlay'),
      '#type' => 'checkbox',
      '#default_value' => $items[$delta]->ebt_settings['overlay'] ?? 0,
      '#description' => $this->t('Add overlay between background image and text.'),
      '#weight' => -20,
    ];

    $element['ebt_settings']['overlay_color'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Overlay Color'),
      '#default_value' => $items[$delta]->ebt_settings['overlay_color'] ?? '#000000',
      '#attributes' => [
        'placeholder' => $this->t('Select RGB Color, for example #000000'),
      ],
      '#weight' => -20,
    ];

    $element['ebt_settings']['overlay_alpha'] = [
      '#type' => 'number',
      '#min' => 0,
      '#max' => 1,
      '#step' => 0.01,
      '#title' => $this->t('Overlay opacity'),
      '#default_value' => $items[$delta]->ebt_settings['overlay_alpha'] ?? '0.6',
      '#description' => $this->t('Opacity for overlay.'),
      '#weight' => -20,
    ];

    $element['ebt_settings']['image_position'] = [
      '#title' => $this->t('Image position'),
      '#type' => 'radios',
      '#options' => [
        'left' => $this->t('Left'),
        'right' => $this->t('Right'),
      ],
      '#default_value' => $items[$delta]->ebt_settings['image_position'] ?? 'left',
      '#description' => $this->t('Image position in 2 columns layout.'),
      '#weight' => -20,
    ];

    $element['ebt_settings']['image_order_mobile'] = [
      '#title' => $this->t('Image position on mobile'),
      '#type' => 'radios',
      '#options' => [
        'image_first' => $this->t('Image first'),
        'image_last' => $this->t('Image last'),
        'hide_image' => $this->t('Hide image'),
      ],
      '#default_value' => $items[$delta]->ebt_settings['image_order_mobile'] ?? 'image_first',
      '#description' => $this->t('Image position in mobile version after transition from 2 to 1 columns.'),
      '#weight' => -19,
    ];

    $mobile_breakpoint_default = $this->config->get('ebt_core_mobile_breakpoint');
    if (empty($mobile_breakpoint_default)) {
      $mobile_breakpoint_default = 480;
    }
    $element['ebt_settings']['mobile_breakpoint'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Mobile breakpoint'),
      '#default_value' => !empty($items[$delta]->ebt_settings['mobile_breakpoint']) ? $items[$delta]->ebt_settings['mobile_breakpoint'] : $mobile_breakpoint_default,
      '#attributes' => [
        'placeholder' => $this->t('Enter breakpoint'),
      ],
      '#description' => $this->t('Mobile breakpoint in pixels to switch 2 columns in one column'),
      '#weight' => -18,
    ];

    $element['ebt_settings']['design_options']['#weight'] = -32;

    $element['ebt_settings']['link_options2'] = $element['ebt_settings']['link_options'];
    $element['ebt_settings']['link_options2']['#weight'] = 3;
    $element['ebt_settings']['link_options2']['#title'] = $this->t('Second Link options');

    $element['ebt_settings']['link_options2']['open_in_new_tab']['#default_value'] = $items[$delta]->ebt_settings['link_options2']['open_in_new_tab'] ?? NULL;
    $element['ebt_settings']['link_options2']['add_nofollow']['#default_value'] = $items[$delta]->ebt_settings['link_options2']['add_nofollow'] ?? NULL;
    $element['ebt_settings']['link_options2']['title_color']['#default_value'] = $items[$delta]->ebt_settings['link_options2']['title_color'] ?? NULL;
    $element['ebt_settings']['link_options2']['background_color']['#default_value'] = $items[$delta]->ebt_settings['link_options2']['background_color'] ?? NULL;
    $element['ebt_settings']['link_options2']['custom_hover_colors']['#default_value'] = $items[$delta]->ebt_settings['link_options2']['custom_hover_colors'] ?? NULL;
    $element['ebt_settings']['link_options2']['hover_title_color']['#default_value'] = $items[$delta]->ebt_settings['link_options2']['hover_title_color'] ?? NULL;
    $element['ebt_settings']['link_options2']['hover_background_color']['#default_value'] = $items[$delta]->ebt_settings['link_options2']['hover_background_color'] ?? NULL;
    $element['ebt_settings']['link_options2']['alignment']['#default_value'] = $items[$delta]->ebt_settings['link_options2']['alignment'] ?? NULL;
    $element['ebt_settings']['link_options2']['shape']['#default_value'] = $items[$delta]->ebt_settings['link_options2']['shape'] ?? NULL;
    $element['ebt_settings']['link_options2']['size']['#default_value'] = $items[$delta]->ebt_settings['link_options2']['size'] ?? NULL;
    $element['ebt_settings']['link_options2']['stretched']['#default_value'] = $items[$delta]->ebt_settings['link_options2']['stretched'] ?? NULL;
    $element['ebt_settings']['link_options2']['custom_class_name']['#default_value'] = $items[$delta]->ebt_settings['link_options2']['custom_class_name'] ?? NULL;

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as &$value) {
      $value += ['ebt_settings' => []];
    }
    foreach ($values[0]['ebt_settings']['link_options'] as $key => $option) {
      $values[0]['ebt_settings'][$key] = $option;
    }
    return $values;
  }

}
