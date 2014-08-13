<?php
/**
 * Theme options / Styles / Footer
 *
 * @package wpv
 * @subpackage church-event
 */

return array(

array(
	'name' => __('Footer', 'church-event'),
	'type' => 'start',
),

array(
	'name' => __('Where are these options used?', 'church-event'),
	'desc' => __('The footer is the area below the body down to the bottom of your site. It consist of two main areas - the footer and the sub-footer. You can change the style of these areas using the options below.<br/>
		Please not that the footer map options are located in general settings - footer map tab.', 'church-event'),
	'type' => 'info',
),

array(
	'name' => __('Backgrounds', 'church-event'),
	'type' => 'separator',
),

array(
	'name' => __('Widget Areas Background', 'church-event'),
	'desc' => __('If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution. If the color opacity  is less than 1 the page background underneath will be visible.', 'church-event'),
	'id' => 'footer-background',
	'type' => 'background',
	'only' => 'color,opacity,image,repeat,size'
),

array(
	'name' => __('Sub-footer Background', 'church-event'),
	'desc' => __('If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.', 'church-event'),
	'id' => 'subfooter-background',
	'type' => 'background',
	'only' => 'color,image,repeat,size'
),

array(
	'name' => __('Typography', 'church-event'),
	'type' => 'separator',
),

array(
	'name' => __('Widget Areas Text', 'church-event'),
	'desc' => __('This is the general font used for the footer widgets.', 'church-event'),
	'id' => 'footer-sidebars-font',
	'type' => 'font',
	'min' => 10,
	'max' => 32,
	'lmin' => 10,
	'lmax' => 64,
),

array(
	'name' => __('Widget Areas Titles', 'church-event'),
	'desc' => __('Please note that this option will override the general headings style set in the General Typography" tab.', 'church-event'),
	'id' => 'footer-sidebars-titles',
	'type' => 'font',
	'min' => 10,
	'max' => 32,
	'lmin' => 10,
	'lmax' => 64,
),

array(
	'name' => __('Sub-footer', 'church-event'),
	'desc' => __('You can place your text/HTML in the General Settings option page.', 'church-event'),
	'id' => 'sub-footer',
	'type' => 'font',
	'min' => 10,
	'max' => 32,
	'lmin' => 10,
	'lmax' => 64,
),

array(
	'name' => __('Links', 'church-event'),
	'type' => 'color-row',
	'inputs' => array(
		'css_footer_link_color' => array(
			'name' => __('Normal:', 'church-event'),
		),
		'css_footer_link_visited_color' => array(
			'name' => __('Visited:', 'church-event'),
		),
		'css_footer_link_hover_color' => array(
			'name' => __('Hover:', 'church-event'),
		),
	),
),

	array(
		'type' => 'end'
	),

);