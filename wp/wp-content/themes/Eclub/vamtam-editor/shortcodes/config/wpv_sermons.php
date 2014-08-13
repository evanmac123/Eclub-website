<?php
return array(
	"name" => __("Sermons", 'church-event'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('bullhorn'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	"value" => "wpv_sermons",
	'controls' => 'size name clone edit delete',
	"options" => array(

		array(
			'name' => __('Number of Sermons', 'church-event') ,
			'id' => 'count',
			'default' => '',
			'type' => 'range',
			'min' => 1,
			'max' => 30,
		) ,

		array(
			'name' => __('Paginated', 'church-event') ,
			'id' => 'pagination',
			'default' => false,
			'type' => 'toggle',
		) ,

		array(
			'name' => __('Categories (optional)', 'church-event') ,
			'desc' => __('All categories will be shown if none are selected. Please note that if you do not see categories, there are none created most probably. You can use ctr + click to select multiple categories.', 'church-event') ,
			'id' => 'cat',
			'default' => array() ,
			'target' => 'wpv_sermons_category',
			'type' => 'multiselect',
		) ,

		array(
			'name' => __('Title (optional)', 'church-event') ,
			'desc' => __('The title is placed just above the element.', 'church-event'),
			'id' => 'column_title',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Title Type (optional)', 'church-event') ,
			'id' => 'column_title_type',
			'default' => 'single',
			'type' => 'select',
			'options' => array(
				'single' => __('Title with divider next to it', 'church-event'),
				'double' => __('Title with divider under it ', 'church-event'),
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
	),
);
