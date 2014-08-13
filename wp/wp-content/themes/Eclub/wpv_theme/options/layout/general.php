<?php

/**
 * Theme options / Layout / General
 *
 * @package wpv
 * @subpackage church-event
 */

return array(
array(
	'name' => __('General', 'church-event'),
	'type' => 'start',
),

array(
	'name' => __('Responsive Layout', 'church-event'),
	'desc' => __('Enabling this option will make the layout respond to the screen resolutions.It is useful mostly on mobile phones.', 'church-event'),
	'id' => 'is-responsive',
	'type' => 'toggle',
	'class' => 'hidden',
),

array(
	'name' => __('Layout Type', 'church-event'),
	'desc' => __('Please note that in full width layout mode, the body background option found in Styles - Body, acts as page background.', 'church-event'),
	'id' => 'site-layout-type',
	'type' => 'select',
	'options' => array(
		'boxed' => __('Boxed', 'church-event'),
		'full' => __('Full width', 'church-event'),
	),
),

array(
	'name' => __('Maximum Page Width', 'church-event'),
	'desc' => sprintf(__('If you have changed this option, please use the <a href="%s" title="Regenerate thumbnails" target="_blank">Regenerate thumbnails</a> plugin in order to update your images.', 'church-event'), 'http://wordpress.org/extend/plugins/regenerate-thumbnails/'),
	'id' => 'site-max-width',
	'type' => 'select',
	'options' => array(
		1080 => '960px',
		1260 => '1140px',
		1380 => '1260px',
	),
),

	array(
		'type' => 'end'
	),
);