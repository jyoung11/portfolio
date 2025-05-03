<?php

/**
 * @file
 * GLightbox theme functions.
 */

use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Entity\EntityInterface;

/**
 * Prepares variables for glightbox formatter templates.
 *
 * Default template: glightbox-formatter.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - item: An ImageItem object.
 *   - item_attributes: An optional associative array of html attributes to be
 *     placed in the img tag.
 *   - entity: An entity object.
 *   - settings: Formatter settings array.
 *
 * @codingStandardsIgnoreStart
 */
function template_preprocess_glightbox_formatter(&$variables) {
  // @codingStandardsIgnoreEnd

  $item = $variables['item'];
  $item_attributes = $variables['item_attributes'] ?? [];
  $entity = $variables['entity'];
  $settings = $variables['settings'];
  $image_uri = $item->entity->getFileUri();
  $classes_array = ['glightbox'];
  $data_gbox_img_attrs = [];

  // Build the caption.
  $entity_title = $entity->label();
  $entity_type = $entity->getEntityTypeId();

  switch ($settings['glightbox_caption']) {
    case 'auto':
      // If the title is empty use alt or the entity title in that order.
      if (!empty($item->title)) {
        $caption = $item->title;
      }
      elseif (!empty($item->alt)) {
        $caption = $item->alt;
      }
      elseif (!empty($entity_title)) {
        $caption = $entity_title;
      }
      else {
        $caption = '';
      }
      break;

    case 'title':
      $caption = $item->title;
      break;

    case 'alt':
      $caption = $item->alt;
      break;

    case 'entity_title':
      $caption = $entity_title;
      break;

    case 'custom':
      $token_service = \Drupal::token();
      $caption = $token_service->replace(
        $settings['glightbox_caption_custom'],
        [$entity_type => $entity, 'file' => $item],
        ['clear' => TRUE]
      );
      break;

    default:
      $caption = '';
  }

  // Shorten the caption for the example styles or when caption
  // shortening is active.
  $config = \Drupal::config('glightbox.settings');

  $parent_entity_id = '';
  $parent_paragraph_id = '';
  if (!empty($entity->_referringItem)) {
    $parent = $entity->_referringItem->getEntity();
    if ($parent instanceof EntityInterface) {
      $parent_entity_id = $parent->id();
    }

    if ($parent->getEntityTypeId() == 'paragraph') {
      $paragraph_parent = $parent->getParentEntity();
      if ($paragraph_parent instanceof EntityInterface) {
        $parent_paragraph_id = $paragraph_parent->id();
      }
    }
  }

  $gallery_id = \Drupal::service('glightbox.gallery_id_generator')->generateId($entity, $item, $settings, $parent_entity_id, $parent_paragraph_id);

  // Set up the $variables['image'] parameter.
  if ($settings['style_name'] == 'hide') {
    $variables['image'] = [];
    $classes_array[] = 'js-hide';
  }
  elseif (!empty($settings['style_name'])) {
    $variables['image'] = [
      '#theme' => 'image_style',
      '#style_name' => $settings['style_name'],
    ];
  }
  else {
    $variables['image'] = [
      '#theme' => 'image',
    ];
  }

  if (!empty($variables['image'])) {
    $variables['image']['#attributes'] = $item_attributes;

    // Do not output an empty 'title' attribute.
    if (!empty($item->title)) {
      $variables['image']['#title'] = $item->title;
      $data_gbox_img_attrs['title'] = '"title":"' . $item->title . '"';
    }

    foreach (['width', 'height', 'alt'] as $key) {
      $variables['image']["#$key"] = $item->$key;
      if ($key == 'alt') {
        $data_gbox_img_attrs['alt'] = '"alt":"' . $item->alt . '"';
      }
    }

    $variables['image']['#uri'] = empty($item->uri) ? $image_uri : $item->uri;
  }

  if (!empty($settings['glightbox_image_style'])) {
    $style = ImageStyle::load($settings['glightbox_image_style']);
    $variables['url'] = $style->buildUrl($image_uri);
  }
  else {
    /** @var \Drupal\Core\File\FileUrlGeneratorInterface $file_url_generator */
    $file_url_generator = \Drupal::service('file_url_generator');

    $variables['url'] = $file_url_generator->generateAbsoluteString($image_uri);
  }

  // If File Entity module is enabled, load attribute values from file entity.
  if (\Drupal::moduleHandler()->moduleExists('file_entity')) {
    // File id of the save file.
    $fid = $item->target_id;
    // Load file object.
    $file_obj = File::load($fid);
    $file_array = $file_obj->toArray();
    // Populate the image title.
    if (!empty($file_array['field_image_title_text'][0]['value']) && empty($item->title) && $settings['glightbox_caption'] == 'title') {
      $caption = $file_array['field_image_title_text'][0]['value'];
    }
    // Populate the image alt text.
    if (!empty($file_array['field_image_alt_text'][0]['value']) && empty($item->alt) && $settings['glightbox_caption'] == 'alt') {
      $caption = $file_array['field_image_alt_text'][0]['value'];
    }
  }

  $variables['attributes']['title'] = Xss::filter($caption);
  $variables['attributes']['data-gallery'] = $gallery_id;
  $variables['attributes']['class'] = $classes_array;
  if (!empty($data_gbox_img_attrs)) {
    $variables['attributes']['data-gbox-img-attrs'] = '{' . implode(',', $data_gbox_img_attrs) . '}';
  }
}
