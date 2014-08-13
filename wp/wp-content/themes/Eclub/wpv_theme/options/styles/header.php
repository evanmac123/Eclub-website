<?php

/**
 * Theme options / Styles / Header
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
	'name' => __('Where are these options used?', 'church-event'),
	'desc' => __('The header consist of the area above the body up to the top. It is divided in two main areas - the main menu area and the slider area. You can change the style of the main menu area using the options below.<br/>
		Please note that the theme uses Layered Slider and its option panel is found in the WordPress navigation menu on the left. ', 'church-event'),
	'type' => 'info',
),

array(
	'name' => __('Backgrounds', 'church-event'),
	'type' => 'separator',
),

array(
	'name' => __('Top Nav Background', 'church-event'),
	'desc' => __('If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.<br> If the color opacity is less than 1 the page background underneath will be visible.', 'church-event'),
	'id' => 'top-nav-background',
	'type' => 'background',
	'only' => 'color,opacity,image,repeat,size',
),

array(
	'name' => __('Header Background', 'church-event'),
	'desc' => __('If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.<br>
	If the color opacity is less than 1 the page background underneath will be visible.', 'church-event'),
	'id' => 'header-background',
	'type' => 'background',
	'only' => 'color,opacity,image,repeat,size',
),

array(
	'name' => __('Sub-Header Background', 'church-event'),
	'desc' => __('If the color opacity is less than 1 the page background underneath will be visible.', 'church-event'),
	'id' => 'sub-header-background',
	'type' => 'background',
	'only' => 'color,image,repeat,size',
	'class' => wpv_get_option('header-layout') == 'logo-menu' ? 'hidden' : '',
),

array(
	'name' => __('Page Title Background', 'church-event'),
	'id' => 'page-title-background',
	'type' => 'background',
	'show' => 'color,image,repeat,size',
),

array(
	'name' => __('Typography', 'church-event'),
	'type' => 'separator',
),

array(
	'name' => __('Site Title', 'church-event'),
	'desc' => sprintf(__('You can set the website title in <a href="%s" title="set website background">from here</a>. It is alternative to using an image logo.', 'church-event'), admin_url('options-general.php')),
	'id' => 'logo',
	'type' => 'font',
	'min' => 10,
	'max' => 60,
	'lmin' => 10,
	'lmax' => 90,
	'only' => 'size,face,weight,color',
),

array(
	'name' => __('Main Menu', 'church-event'),
	'desc' => sprintf(__('Please note that you have to use the WordPress custom menu feature located in <a href="%s" title="WordPress menus">Appearance - Menus</a>', 'church-event'), admin_url('nav-menus.php')),
	'id' => 'menu-font',
	'type' => 'font',
	'only' => 'size,face,weight,color',
	'min' => 10,
	'max' => 24,
	'lmin' => 10,
	'lmax' => 300,
	'class' => 'short-border',
),

array(
	'name' => '',
	'type' => 'color-row',
	'inputs' => array(
		'main-menu-hover-background' => array(
			'name' => __('Text Hover Background:', 'church-event'),
		),
		'main-menu-sticky-color' => array(
			'name' => __('Text Color for Transparent Header:', 'church-event'),
		),
		'css_menu_hover_color' => array(
			'name' => __('Text Hover Color:', 'church-event'),
		),
	),
),

array(
	'name' => __('Main Menu Sub-Menus', 'church-event'),
	'type' => 'color-row',
	'inputs' => array(
		'css_menu_background' => array(
			'name' => __('Background:', 'church-event'),
		),
		'css_submenu_color' => array(
			'name' => __('Text Normal Color:', 'church-event'),
		),
		'css_submenu_hover_color' => array(
			'name' => __('Text Hover Color:', 'church-event'),
		),
	),
),

array(
	'name' => __('Top Header Second Menu', 'church-event'),
	'desc' => sprintf(__('Please note that you have to use the WordPress custom menu feature located in <a href="%s" title="WordPress menus">Appearance - Menus</a>', 'church-event'), admin_url('nav-menus.php')),
	'type' => 'color-row',
	'inputs' => array(
		'css_tophead_text_color' => array(
			'name' => __('Text Color:', 'church-event'),
		),
		'css_tophead_link_color' => array(
			'name' => __('Link Color:', 'church-event'),
		),
		'css_tophead_link_hover_color' => array(
			'name' => __('Link Hover Color:', 'church-event'),
		),
	),
),

	array(
		'type' => 'end'
	),
);