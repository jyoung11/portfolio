<?php

namespace Drupal\ebt_image\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ebt_core\Plugin\Field\FieldWidget\EbtSettingsDefaultWidget;
use Drupal\image\Entity\ImageStyle;

/**
 * Plugin implementation of the 'ebt_settings_image' widget.
 *
 * @FieldWidget(
 *   id = "ebt_settings_image",
 *   label = @Translation("EBT Image settings"),
 *   field_types = {
 *     "ebt_settings"
 *   }
 * )
 */
class EbtSettingsImageWidget extends EbtSettingsDefaultWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $styles = ImageStyle::loadMultiple();
    $image_styles['none'] = $this->t('Original image');
    foreach ($styles as $key => $style) {
      $image_styles[$key] = $style->label();
    }

    $element['ebt_settings']['image_style'] = [
      '#title' => $this->t('Image Style'),
      '#type' => 'select',
      '#options' => $image_styles,
      '#default_value' => $items[$delta]->ebt_settings['image_style'] ?? 'none',
      '#description' => $this->t('Select image style for image.'),
      '#weight' => 4,
    ];

    $element['ebt_settings']['image_lightbox'] = [
      '#title' => $this->t('Enable Image Lightbox'),
      '#type' => 'checkbox',
      '#default_value' => $items[$delta]->ebt_settings['image_lightbox'] ?? FALSE,
      '#description' => $this->t('Display lightbox on image click.'),
      '#weight' => 5,
    ];

    $element['ebt_settings']['lightbox_image_style'] = [
      '#title' => $this->t('Lightbox Image Style'),
      '#type' => 'select',
      '#options' => $image_styles,
      '#default_value' => $items[$delta]->ebt_settings['lightbox_image_style'] ?? 'none',
      '#description' => $this->t('Select image style for lightbox image.'),
      '#weight' => 6,
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as &$value) {
      $value += ['ebt_settings' => []];
    }

    return $values;
  }

}
