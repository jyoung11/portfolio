(function (Drupal) {
  "use strict";

  /**
   * Enable the GLightbox inline functionality.
   */
  Drupal.behaviors.glightboxInline = {
    attach: function (context, drupalSettings) {
      once('glightbox-inline-processed', '.glightbox-inline', context).forEach(function () {
        var lightboxInlineIframe = GLightbox({
          selector: '.glightbox-inline'
        });
      });
    }
  };

})(Drupal);
