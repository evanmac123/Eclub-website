<?php

/**
 * Theme options / Layout / Header
 *
 * @package wpv
 * @subpackage church-event
 */

return array(
array(
	'name' => __('Header', 'church-event'),
	'type' => 'start',
),

array(
	'name' => __('Header Layout', 'church-event'),
	'desc' => __('Please note that the theme uses Layered Slider and its option panel is found in the WordPress navigation menu on the left', 'church-event'),
	'type' => 'info',
),


array(
	'name' => __('Header Layout', 'church-event'),
	'type' => 'autofill',
	'class' => 'no-box',
	'option_sets' => array(
		array(
			'name' => __('One row, left logo, menu on the right', 'church-event'),
			'image' => WPV_ADMIN_ASSETS_URI . 'images/header-layout-1.png',
			'values' => array(
				'header-layout' => 'logo-menu',
			),
		),
		array(
			'name' => __('Two rows; left-aligned logo on top, right-aligned text and search', 'church-event'),
			'image' => WPV_ADMIN_ASSETS_URI . 'images/header-layout-2.png',
			'values' => array(
				'header-layout' => 'logo-text-menu',
			),
		),
		array(
			'name' => __('Two rows; centered logo on top', 'church-event'),
			'image' => WPV_ADMIN_ASSETS_URI . 'images/header-layout-3.png',
			'values' => array(
				'header-layout' => 'standard',
			),
		),
	),
),


array(
	'name' => __('Header Height', 'church-event'),
	'desc' => __('This is the area above the slider.', 'church-event'),
	'id' => 'header-height',
	'type' => 'range',
	'min' => 30,
	'max' => 300,
	'unit' => 'px',
),
array(
	'name' => __('Sticky Header', 'church-event'),
	'desc' => __('This option is switched off automatically for mobile devices because the animation is not well sported by the majority of the mobile devices.', 'church-event'),
	'id' => 'sticky-header',
	'type' => 'toggle',
),


array(
	'name' => __('Enable Header Search', 'church-event'),
	'id' => 'enable-header-search',
	'type' => 'toggle',
),

array(
	'name' => __('Full Width Header', 'church-event'),
	'id' => 'full-width-header',
	'type' => 'toggle',
	'class' => 'fhl fhl-logo-menu',
),

array(
	'name' => __('Top Bar Layout', 'church-event'),
	'id' => 'top-bar-layout',
	'type' => 'select',
	'options' => array(
		'' => __('Disabled', 'church-event'),
		'ctext' => __('Centered Text', 'church-event'),
		'menu-social' => __('Left: Menu, Right: Social Icons', 'church-event'),
		'social-menu' => __('Left: Social Icons, Right: Menu', 'church-event'),
		'text-menu' => __('Left: Text, Right: Menu', 'church-event'),
		'menu-text' => __('Left: Menu, Right: Text', 'church-event'),
		'social-text' => __('Left: Social Icons, Right: Text', 'church-event'),
		'text-social' => __('Left: Text, Right: Social Icons', 'church-event'),
	),
	'field_filter' => 'ftbl',
),

array(
	'name' => __('Top Bar Text', 'church-event'),
	'desc' => __('You can place plain text, HTML and shortcodes.', 'church-event'),
	'id' => 'top-bar-text',
	'type' => 'textarea',
	'class' => 'ftbl ftbl-menu-text ftbl-text-menu ftbl-social-text ftbl-text-social ftbl-ctext',
),

array(
	'name' => __('Top Bar Social Text Lead', 'church-event'),
	'id' => 'top-bar-social-lead',
	'type' => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name' => __('Top Bar Facebook Link', 'church-event'),
	'id' => 'top-bar-social-fb',
	'type' => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name' => __('Top Bar Twitter Link', 'church-event'),
	'id' => 'top-bar-social-twitter',
	'type' => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name' => __('Top Bar LinkedIn Link', 'church-event'),
	'id' => 'top-bar-social-linkedin',
	'type' => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name' => __('Top Bar Google+ Link', 'church-event'),
	'id' => 'top-bar-social-gplus',
	'type' => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name' => __('Top Bar Flickr Link', 'church-event'),
	'id' => 'top-bar-social-flickr',
	'type' => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name' => __('Top Bar Pinterest Link', 'church-event'),
	'id' => 'top-bar-social-pinterest',
	'type' => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),

array(
	'name' => __('Top Bar Dribbble Link', 'church-event'),
	'id' => 'top-bar-social-dribbble',
	'type' => 'text',
	'class' => 'ftbl ftbl-menu-social ftbl-social-menu ftbl-social-text ftbl-text-social slim',
),


array(
	'name' => __('Header Layout', 'church-event'), // dummy option, do not remove
	'id' => 'header-layout',
	'type' => 'select',
	'class' => 'hidden',
	'options' => array(
		'standard' => __('Two rows; centered logo on top', 'church-event'),
		'logo-menu' => __('One row, left logo, menu on the right', 'church-event'),
		'logo-text-menu' => __('Two rows; left-aligned logo on top, right-aligned text and search', 'church-event'),
	),
	'field_filter' => 'fhl',
),

array(
	'name' => __('Header Text Area', 'church-event'),
	'desc' => __('You can place text/HTML or any shortcode in this field. The text will appear in the header on the left hand side.', 'church-event'),
	'id' => 'phone-num-top',
	'type' => 'textarea',
	'static' => true,
),

	array(
		'type' => 'end'
	),

);