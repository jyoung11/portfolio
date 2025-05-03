/**
 * @file
 * GLightbox JS.
 */

(function (Drupal, drupalSettings, once) {
  'use strict';

  Drupal.behaviors.initGLightbox = {
    attach: function (context, settings) {
      const options = settings.glightbox || {};
      const lightbox = GLightbox(options);

      lightbox.on('slide_changed', ({ prev, current }) => {
        const { slideIndex, slideNode, slideConfig, player } = current;

        // Video autoplay if it's possible.
        if (player) {
          if (!player.ready) {
            // If player is not ready.
            player.on('ready', (event) => {
              // Do something when video is ready.
            });
          }

          player.on('play', (event) => {
            // console.log('Started play');
          });

          player.on('volumechange', (event) => {
            // console.log('Volume change');
          });

          player.on('ended', (event) => {
            // console.log('Video ended');
          });
        }
      });
    },
  };

  // Create glightbox namespace if it doesn't exist.
  if (!Drupal.hasOwnProperty('glightbox')) {
    Drupal.glightbox = {};
  }
})(Drupal, drupalSettings, once);
