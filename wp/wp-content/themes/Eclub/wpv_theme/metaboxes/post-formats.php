<?php
/**
 * Vamtam Post Format Options
 *
 * @package wpv
 * @subpackage church-event
 */

return array(

array(
	'name' => __('Standard', 'church-event'),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-0',
),

array(
	'name' => __('How do I use standard post format?', 'church-event'),
	'desc' => __('Just use the editor below.', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

// --

array(
	'name' => __('Aside', 'church-event'),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-aside',
),

array(
	'name' => __('How do I use aside post format?', 'church-event'),
	'desc' => __('Just use the editor below. The post title will not be shown publicly.', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

// --

array(
	'name' => __('Link', 'church-event'),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-link',
),

array(
	'name' => __('How do I use link post format?', 'church-event'),
	'desc' => __('Use the editor below for the post body, put the link in the option below.', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => __('Link', 'church-event'),
	'id' => 'wpv-post-format-link',
	'type' => 'text',
),

// --

array(
	'name' => __('Image', 'church-event'),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-image',
),

array(
	'name' => __('How do I use image post format?', 'church-event'),
	'desc' => __('Use the standard Featured Image option.', 'church-event'),
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
	'name' => __('How do I use video post format?', 'church-event'),
	'desc' => __('Put the url of the video below. You must use an oEmbed provider supported by WordPress or a file supported by the [video] shortcode which comes with WordPress.', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => __('Link', 'church-event'),
	'id' => 'wpv-post-format-video-link',
	'type' => 'text',
),

// --

array(
	'name' => __('Audio', 'church-event'),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-audio',
),

array(
	'name' => __('How do I use auido post format?', 'church-event'),
	'desc' => __('Put the url of the audio below. You must use an oEmbed provider supported by WordPress or a file supported by the [audio] shortcode which comes with WordPress.', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => __('Link', 'church-event'),
	'id' => 'wpv-post-format-audio-link',
	'type' => 'text',
),

// --

array(
	'name' => __('Quote', 'church-event'),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-quote',
),

array(
	'name' => __('How do I use quote post format?', 'church-event'),
	'desc' => __('Simply fill in author and link fields', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => __('Author', 'church-event'),
	'id' => 'wpv-post-format-quote-author',
	'type' => 'text',
),

array(
	'name' => __('Link', 'church-event'),
	'id' => 'wpv-post-format-quote-link',
	'type' => 'text',
),

// --

array(
	'name' => __('Gallery', 'church-event'),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-gallery',
),

array(
	'name' => __('How do I use gallery post format?', 'church-event'),
	'desc' => __('Use the "Add Media" in a text/image block element to create a gallery.This button is also found in the top left side of the visual and text editors.', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

// --

array(
	'name' => __('Status', 'church-event'),
	'type' => 'separator',
	'tab_class' => 'wpv-post-format-status',
),

array(
	'name' => __('How do I use this post format?', 'church-event'),
	'desc' => __('...', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

);
