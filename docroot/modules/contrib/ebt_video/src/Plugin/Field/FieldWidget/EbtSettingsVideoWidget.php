<?php

namespace Drupal\ebt_video\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ebt_core\Plugin\Field\FieldWidget\EbtSettingsDefaultWidget;

/**
 * Plugin implementation of the 'ebt_settings_video' widget.
 *
 * @FieldWidget(
 *   id = "ebt_settings_video",
 *   label = @Translation("EBT Video settings"),
 *   field_types = {
 *     "ebt_settings"
 *   }
 * )
 */
class EbtSettingsVideoWidget extends EbtSettingsDefaultWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

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
