<?php
return array(
	"name" => __("Upcoming Events", 'church-event'),

	'icon' => array(
		'char' => WPV_Editor::get_icon('quotes-left'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	"value"    => "wpv_tribe_events",
	'controls' => 'size name clone edit delete',
	"options"  => array(

		array(
			'name'    => __('Layout', 'church-event') ,
			'id'      => 'layout',
			'default' => 'single',
			'type'    => 'select',
			'options' => array(
				'single'       => __('Single event per line', 'church-event'),
				'single-large' => __('Single event per line (large)', 'church-event'),
				'classic'      => __('Classic', 'church-event'),
				'multiple'     => __('Multiple events per line ', 'church-event'),
			),
			'field_filter' => 'fbl',
		) ,

		array(
			'name'    => __('Style', 'church-event') ,
			'id'      => 'style',
			'default' => 'light',
			'type'    => 'select',
			'options' => array(
				'light' => __('Light Text', 'church-event'),
				'dark'  => __('Dark Text', 'church-event'),
			),
		) ,

		array(
			'name'    => __('Number of Events', 'church-event') ,
			'id'      => 'count',
			'default' => '',
			'type'    => 'range',
			'min'     => 1,
			'max'     => 30,
		) ,

		array(
			'name'    => __('Ongoing Event Text', 'church-event') ,
			'id'      => 'ongoing',
			'default' => '',
			'type'    => 'text',
			'class'   => 'fbl fbl-single fbl-single-large fbl-classic',
		) ,

		array(
			'name'    => __('Lead Text', 'church-event') ,
			'id'      => 'lead_text',
			'default' => '',
			'type'    => 'text',
			'class'   => 'fbl fbl-classic',
		) ,

		array(
			'name'    => __('"View All" Text', 'church-event') ,
			'id'      => 'view_all_text',
			'default' => '',
			'type'    => 'text',
			'class'   => 'fbl fbl-classic',
		) ,

		array(
			'name'    => __('"View All" Link', 'church-event') ,
			'id'      => 'view_all_link',
			'default' => '',
			'type'    => 'text',
			'class'   => 'fbl fbl-classic',
		) ,

		array(
			'name'    => __('"Read More" Text', 'church-event') ,
			'id'      => 'read_more_text',
			'default' => '',
			'type'    => 'text',
		) ,

		array(
			'name'    => __('Categories (optional)', 'church-event') ,
			'desc'    => __('All categories will be shown if none are selected. Please note that if you do not see categories, there are none created most probably. You can use ctr + click to select multiple categories.', 'church-event') ,
			'id'      => 'cat',
			'default' => array() ,
			'target'  => 'tribe_events_category',
			'type'    => 'multiselect',
		) ,

		array(
			'name'    => __('Title (optional)', 'church-event') ,
			'desc'    => __('The title is placed just above the element.', 'church-event'),
			'id'      => 'column_title',
			'default' => '',
			'type'    => 'text'
		) ,
		array(
			'name'    => __('Title Type (optional)', 'church-event') ,
			'id'      => 'column_title_type',
			'default' => 'single',
			'type'    => 'select',
			'options' => array(
				'single'     => __('Title with divider next to it', 'church-event'),
				'double'     => __('Title with divider under it ', 'church-event'),
				'no-divider' => __('No Divider', 'church-event'),
			),
		) ,
		array(
			'name'    => __('Element Animation (optional)', 'church-event') ,
			'id'      => 'column_animation',
			'default' => 'none',
			'type'    => 'select',
			'options' => array(
				'none'       => __('No animation', 'church-event'),
				'from-left'  => __('Appear from left', 'church-event'),
				'from-right' => __('Appear from right', 'church-event'),
				'fade-in'    => __('Fade in', 'church-event'),
				'zoom-in'    => __('Zoom in', 'church-event'),
			),
		) ,
	),
);
