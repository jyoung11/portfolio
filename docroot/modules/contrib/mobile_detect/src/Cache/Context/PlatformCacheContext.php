<?php

namespace Drupal\mobile_detect\Cache\Context;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Cache\Context\CacheContextInterface;
use Detection\MobileDetect;

/**
 * Defines the 'Platform' cache context.
 *
 * Cache context ID: 'mobile_detect_platform'.
 */
class PlatformCacheContext implements CacheContextInterface {

  /**
   * Mobile Detect object.
   *
   * @var \Detection\MobileDetect
   */
  protected $mobileDetect;

  /**
   * Constructs an IsFrontPathCacheContext object.
   *
   * @param \Detection\MobileDetect $mobile_detect
   *   Mobile Detect object.
   */
  public function __construct(MobileDetect $mobile_detect) {
    $this->mobileDetect = $mobile_detect;
  }

  /**
   * {@inheritdoc}
   */
  public static function getLabel() {
    return 'Platform';
  }

  /**
   * {@inheritdoc}
   */
  public function getContext() {
    $detect = $this->mobileDetect;
    if ($detect->isAndroidOS()) {
      return 'android';
    }
    elseif ($detect->isIOS()) {
      return 'ios';
    }
    return 'other';
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheableMetadata() {
    return new CacheableMetadata();
  }

}
