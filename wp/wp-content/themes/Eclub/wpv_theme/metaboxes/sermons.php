<?php
/**
 * Vamtam Sermon Options
 *
 * @package wpv
 * @subpackage church-event
 */

return array(

array(
	'name' => __('Document', 'church-event'),
	'type' => 'separator',
),

array(
	'name' => __('Video', 'church-event'),
	'type' => 'separator',
),

array(
	'name' => __('How do I use video sermon format?', 'church-event'),
	'desc' => __('Put the url of the video below. You must use an oEmbed provider supported by WordPress or a file supported by the [video] shortcode which comes with WordPress. Vimeo and Youtube are supported.', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => __('Link', 'church-event'),
	'id' => 'wpv-sermon-video',
	'type' => 'text',
	'default' => '',
),

// --

array(
	'name' => __('Audio', 'church-event'),
	'type' => 'separator',
),

array(
	'name' => __('How do I use audio sermon format?', 'church-event'),
	'desc' => __('Put the url of the audio below. You must use an oEmbed provider supported by WordPress or a file supported by the [audio] shortcode which comes with WordPress. Vimeo and Youtube are supported.', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => __('Link', 'church-event'),
	'id' => 'wpv-sermon-audio',
	'type' => 'text',
	'default' => '',
),

// --

array(
	'name' => __('Document', 'church-event'),
	'type' => 'separator',
),

array(
	'name' => __('Link', 'church-event'),
	'id' => 'wpv-sermon-document',
	'type' => 'text',
	'default' => '',
),

// --

array(
	'name' => __('Link', 'church-event'),
	'type' => 'separator',
),

array(
	'name' => __('How do I use link sermon format?', 'church-event'),
	'desc' => __('Use the standard Featured Image option for the sermon image. Use the editor below for your content. Put the link in the option below if you want the image in the sermon listing to lead to a particular link. If you leave the link field blank, clicking on the image in the sermon listing page will open up the sermon post.', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => __('Link', 'church-event'),
	'id' => 'wpv-sermon-link',
	'type' => 'text',
	'default' => '',
),

);
