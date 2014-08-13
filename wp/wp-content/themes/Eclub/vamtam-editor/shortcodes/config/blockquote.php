<?php

/**
 * Blockquote shortcode options
 *
 * @package wpv
 * @subpackage editor
 */

return array(
	'name' => __('Testimonials', 'church-event') ,
	'desc' => __('Please note that this element shows already created testimonials. To create one go to Testimonials tab in the WordPress main navigation menu on the left - add new.  ' , 'church-event'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('quotes-left'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'blockquote',
	'controls' => 'size name clone edit delete',
	'options' => array(

		array(
			'name' => __('Layout', 'church-event') ,
			'id' => 'layout',
			'default' => 'slider',
			'type' => 'select',
			'options' => array(
				'slider' => __('Slider', 'church-event'),
				'static' => __('Static', 'church-event'),
			),
			'field_filter' => 'fbl',
		) ,
		array(
			'name' => __('Categories (optional)', 'church-event') ,
			'desc' => __('By default all categories are active. Please note that if you do not see catgories, most probably there are none created.  You can use ctr + click to select multiple categories.' , 'church-event'),
			'id' => 'cat',
			'default' => array() ,
			'target' => 'testimonials_category',
			'type' => 'multiselect',
		) ,
		array(
			'name' => __('IDs (optional)', 'church-event') ,
			'desc' => __(' By default all testimonials are active. You can use ctr + click to select multiple IDs.', 'church-event') ,
			'id' => 'ids',
			'default' => array() ,
			'target' => 'testimonials',
			'type' => 'multiselect',
		) ,

		array(
			'name' => __('Automatically rotate', 'church-event') ,
			'id' => 'autorotate',
			'default' => false,
			'type' => 'toggle',
			'class' => 'fbl fbl-slider',
		) ,

		array(
			'name' => __('Title (optional)', 'church-event') ,
			'desc' => __('The title is placed just above the element.', 'church-event'),
			'id' => 'column_title',
			'default' => __('', 'church-event') ,
			'type' => 'text'
		) ,


		array(
			'name' => __('Title Type (optional)', 'church-event') ,
			'id' => 'column_title_type',
			'default' => 'single',
			'type' => 'select',
			'options' => array(
				'single' => __('Title with devider next to it.', 'church-event'),
				'double' => __('Title with devider under it.', 'church-event'),
				'no-divider' => __('No Divider', 'church-event'),
			),
		) ,
		array(
			'name' => __('Element Animation (optional)', 'church-event') ,
			'id' => 'column_animation',
			'default' => 'none',
			'type' => 'select',
			'options' => array(
				'none' => __('No animation', 'church-event'),
				'from-left' => __('Appear from left', 'church-event'),
				'from-right' => __('Appear from right', 'church-event'),
				'fade-in' => __('Fade in', 'church-event'),
				'zoom-in' => __('Zoom in', 'church-event'),
			),
		) ,
	) ,
);
