CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Requirements
 * Recommended modules
 * Installation
 * Configuration
 * Troubleshooting
 * FAQ
 * Maintainers

INTRODUCTION
------------

Extra Block Types: Accordion module provides ability
to add a block with Accordion/FAQ.

REQUIREMENTS
------------

This module requires the following modules:
 * [EBT Core](https://www.drupal.org/project/ebt_core)
 * [jQuery UI Accordion](https://www.drupal.org/project/jquery_ui_accordion)
 * [Paragraphs](https://www.drupal.org/project/paragraphs)

EBT Modules use Media module with Media Image type for background images.
Check Media Image type exists before install EBT Core module.

RECOMMENDED MODULES
-------------------

EBT modules provide ability to add different blocks
in Layout Builder in few clicks.
You can install separate block types from this bunch of EBT modules:
- [EBT Accordion / FAQ](https://www.drupal.org/project/ebt_accordion)
- [EBT Basic Button](https://www.drupal.org/project/ebt_basic_button)
- [EBT Bootstrap Button](https://www.drupal.org/project/ebt_bootstrap_button)
- [EBT Call to Action](https://www.drupal.org/project/ebt_cta)
- [EBT Carousel](https://www.drupal.org/project/ebt_carousel)
- [EBT Countdown](https://www.drupal.org/project/ebt_countdown)
- [EBT Counter](https://www.drupal.org/project/ebt_counter)
- [EBT Image](https://www.drupal.org/project/ebt_image)
- [EBT Image Gallery](https://www.drupal.org/project/ebt_image_gallery)
- [EBT Micromodal](https://www.drupal.org/project/ebt_micromodal)
- [EBT Quote](https://www.drupal.org/project/ebt_quote)
- [EBT Slick Slider](https://www.drupal.org/project/ebt_slick_slider)
- [EBT Slideshow](https://www.drupal.org/project/ebt_slideshow)
- [EBT Stats](https://www.drupal.org/project/ebt_stats)
- [EBT Tabs](https://www.drupal.org/project/ebt_tabs)
- [EBT Text](https://www.drupal.org/project/ebt_text)
- [EBT Tiles](https://www.drupal.org/project/ebt_tiles)
- [EBT Timeline](https://www.drupal.org/project/ebt_timeline)
- [EBT Video](https://www.drupal.org/project/ebt_video)
- [EBT Video and Image gallery](https://www.drupal.org/project/ebt_video_and_image_gallery)
- [EBT Webform](https://www.drupal.org/project/ebt_webform)
- [EBT Webform Popup](https://www.drupal.org/project/ebt_webform_popup)

More about EBT blocks read on EBT Core module page:
[EBT Core](https://www.drupal.org/project/ebt_core)

If you are looking for Extra Paragraph Types, you can check out
these modules:
- [EPT Accordion / FAQ](https://www.drupal.org/project/ept_accordion)
- [EPT Basic Button](https://www.drupal.org/project/ept_basic_button)
- [EPT Bootstrap Button](https://www.drupal.org/project/ept_bootstrap_button)
- [EPT Call to Action](https://www.drupal.org/project/ept_cta)
- [EPT Carousel](https://www.drupal.org/project/ept_carousel)
- [EPT Countdown](https://www.drupal.org/project/ept_countdown)
- [EPT Counter](https://www.drupal.org/project/ept_counter)
- [EPT Image](https://www.drupal.org/project/ept_image)
- [EPT Image Gallery](https://www.drupal.org/project/ept_image_gallery)
- [EPT Micromodal](https://www.drupal.org/project/ept_micromodal)
- [EPT Quote](https://www.drupal.org/project/ept_quote)
- [EPT Slick Slider](https://www.drupal.org/project/ept_slick_slider)
- [EPT Slideshow](https://www.drupal.org/project/ept_slideshow)
- [EPT Stats](https://www.drupal.org/project/ept_stats)
- [EPT Tabs](https://www.drupal.org/project/ept_tabs)
- [EPT Text](https://www.drupal.org/project/ept_text)
- [EPT Tiles](https://www.drupal.org/project/ept_tiles)
- [EPT Timeline](https://www.drupal.org/project/ept_timeline)
- [EPT Video](https://www.drupal.org/project/ept_video)
- [EPT Video and Image gallery](https://www.drupal.org/project/ept_video_and_image_gallery)
- [EPT Webform](https://www.drupal.org/project/ept_webform)
- [EPT Webform Popup](https://www.drupal.org/project/ept_webform_popup)

More about EPT paragraphs read on EPT Core module page:
[EPT Core](https://www.drupal.org/project/ept_core)

If you want to enhance UI for adding Blocks from Layout builder try this module:
[Layout Builder Modal](https://www.drupal.org/project/layout_builder_modal)

If you want to enhance UI for adding Paragraphs try these modules:
[Paragraphs Edit](https://www.drupal.org/project/paragraphs_edit)
[Paragraphs Modal Edit](https://www.drupal.org/project/paragraphs_modal_edit)

INSTALLATION
------------

 * Install as you would normally install a contributed Drupal module. Visit
   https://www.drupal.org/node/1897420 for further information.

CONFIGURATION
-------------

EBT Core has configuration form with Primary/Secondary colors
and Mobile/Tablet/Desktop breakpoints in
Administration » Configuration » Content authoring
» Extra Block Types (EBT) settings

These configs will be applied to other EBT blocks by default.

TROUBLESHOOTING
---------------

 * If you see the error during EBT modules installation:
   "The EBT Carousel needs to be created "Image" media type.
   (Currently using Media type Image version Not created)"
   Then you need to create Image media type:
   Structure » Media types » Add media type
 * If you use Field Layout module,
   it will automatically apply Layout Builder for new EBT block types.
   So you will need to disable Layout Builder for displaying block type fields:

   /admin/structure/block/block-content/manage/ebt_accordion/display/default

FAQ
---

Q: Why Tab Title is formatted text field?

A: Requirements for accordion can be different,
EBT: Accordion module tends to be flexible.
Formatted text fields allows to output
additional Font Awesome icons with <i> tag,
emphasize some words with bold font or italic,
display different titles for mobile and desktop version using
css classes, such are .visible-sm, .hidden-md for Bootstrap.


Q: Can I use only one EBT block type, for example EBT Slideshow,
without other modules?

A: Yes, sure. EBT block types tend to be standalone modules.
You can install only needed block types.

MAINTAINERS
-----------

 * [Ivan Abramenko](https://www.drupal.org/u/levmyshkin)
