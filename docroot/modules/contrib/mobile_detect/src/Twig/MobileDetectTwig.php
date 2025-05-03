<?php

namespace Drupal\mobile_detect\Twig;

use Detection\MobileDetect;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * MobileDetectTwig class.
 *
 * Provides Twig Extensions.
 */
class MobileDetectTwig extends AbstractExtension {

  /**
   * Mobile detect service.
   *
   * @var \Detection\MobileDetect
   */
  protected $mobileDetector;

  /**
   * Constructor.
   *
   * @param \Detection\MobileDetect $mobileDetector
   *   Mobile Detect Object.
   */
  public function __construct(MobileDetect $mobileDetector) {
    $this->mobileDetector = $mobileDetector;
  }

  /**
   * Get extension twig function.
   *
   * @return array
   *   Returns twig functions.
   */
  public function getFunctions() {
    return [
      new TwigFunction('is_mobile', [$this, 'isMobile']),
      new TwigFunction('is_tablet', [$this, 'isTablet']),
      new TwigFunction('is_device', [$this, 'isDevice']),
      new TwigFunction('is_ios', [$this, 'isIos']),
      new TwigFunction('is_android_os', [$this, 'isAndroidOs']),
    ];
  }

  /**
   * Is mobile.
   *
   * @return bool
   *   Boolean check is mobile.
   */
  public function isMobile() {
    return $this->mobileDetector->isMobile();
  }

  /**
   * Is tablet.
   *
   * @return bool
   *   Boolean check is tablet.
   */
  public function isTablet() {
    return $this->mobileDetector->isTablet();
  }

  /**
   * Is device.
   *
   * @param string $deviceName
   *   is[iPhone|BlackBerry|HTC|Nexus|Dell|Motorola|Samsung|Sony|Asus|Palm|Vertu|...].
   *
   * @return bool
   *   Boolean check device.
   */
  public function isDevice($deviceName) {
    $methodName = 'is' . strtolower((string) $deviceName);

    return $this->mobileDetector->$methodName();
  }

  /**
   * Is iOS.
   *
   * @return bool
   *   Boolean check IOS.
   */
  public function isIos() {
    return $this->mobileDetector->isIOS();
  }

  /**
   * Is Android OS.
   *
   * @return bool
   *   Boolean check AndroidOS.
   */
  public function isAndroidOs() {
    return $this->mobileDetector->isAndroidOS();
  }

  /**
   * Extension name.
   *
   * @return string
   *   Get name.
   */
  public function getName() {
    return 'mobile_detect.twig.extension';
  }

}
