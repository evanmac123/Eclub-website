<?php
/**
 * Vamtam Portfolio Format Options
 *
 * @package wpv
 * @subpackage church-event
 */

return array(

array(
	'name' => __('Document', 'church-event'),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-document',
),

array(
	'name' => __('How do I use document portfolio format?', 'church-event'),
	'desc' => __('Use the standard Featured Image option for the portfolio image. Use the editor below for your content. The image will only be shown in the portfolio listing.You will need "Link" post format if you need the featured image to appear in the post itself.', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

// --

array(
	'name' => __('Image', 'church-event'),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-image',
),

array(
	'name' => __('How do I use image portfolio format?', 'church-event'),
	'desc' => __('Use the standard Featured Image option for the portfolio image. Use the editor below for your content. Clicking on the image in the Portfolio listing page will open up the image in a lightbox. You will need "Link" post format if you want clicking on the image to lead to the portfolio post.', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

// --

array(
	'name' => __('Gallery', 'church-event'),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-gallery',
),

array(
	'name' => __('How do I use gallery portfolio format?', 'church-event'),
	'desc' => __('Use the "Add Media" button in a text/image block element to create a gallery.This button is also found in the top left side of the visual and text editors.Please note that when the media manager opens up in the lightbox, you have to click on "Create Gallery" on the left and then select the images for your gallery.', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

// --

array(
	'name' => __('Video', 'church-event'),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-video',
),

array(
	'name' => __('How do I use video portfolio format?', 'church-event'),
	'desc' => __('Put the url of the video below. You must use an oEmbed provider supported by WordPress or a file supported by the [video] shortcode which comes with WordPress. Vimeo and Youtube are supported.', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => __('Link', 'church-event'),
	'id' => 'wpv-portfolio-format-video',
	'type' => 'text',
	'only' => 'portfolio',
	'default' => '',
),

// --

array(
	'name' => __('Link', 'church-event'),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-link',
),

array(
	'name' => __('How do I use link portfolio format?', 'church-event'),
	'desc' => __('Use the standard Featured Image option for the portfolio image. Use the editor below for your content. Put the link in the option below if you want the image in the portfolio listing to lead to a particular link. If you leave the link field blank, clicking on the image in the portfolio listing page will open up the portfolio post.', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => __('Link', 'church-event'),
	'id' => 'wpv-portfolio-format-link',
	'type' => 'text',
	'only' => 'portfolio',
	'default' => '',
),

// --

array(
	'name' => __('HTML', 'church-event'),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-html',
),

array(
	'name' => __('How do I use HTML portfolio format?', 'church-event'),
	'desc' => __('Use the standard Featured Image option for the portfolio image. Use the editor below for your content.', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => __('HTML Content Used for the "HTML" Portfolio Type', 'church-event'),
	'desc' => __('Please note that if you are using the AJAX portfolio, some shortcodes may not work as expected in this field.', 'church-event'),
	'id' => 'portfolio-top-html',
	'type' => 'textarea',
	'only' => 'portfolio',
	'default' => '',
),

// --

array(
	'name' => __('Logo', 'church-event'),
	'id' => 'portfolio-logo',
	'type' => 'upload',
	'only' => 'portfolio',
	'default' => '',
	'class' => 'wpv-all-formats',
),

array(
	'name' => __('Client', 'church-event'),
	'id' => 'portfolio-client',
	'type' => 'text',
	'only' => 'portfolio',
	'default' => '',
	'class' => 'wpv-all-formats',
),

);
