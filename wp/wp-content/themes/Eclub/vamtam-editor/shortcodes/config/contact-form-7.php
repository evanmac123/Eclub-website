<?php
return array(
	'name' => __('Contact Form 7', 'church-event') ,
	'desc' => __('Please note that the theme uses the Contact Form 7 plugin for building forms and its option panel is found in the WordPress navigation menu on the left. ' , 'church-event'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('pencil1'),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'contact-form-7',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => __('Choose By ID', 'church-event') ,
			'id' => 'id',
			'default' => '',
			'prompt' => '',
			'options' => WPV_Editor::get_wpcf7_posts('ID'),
			'type' => 'select',
		) ,

		array(
			'name' => __('Choose By Title', 'church-event') ,
			'id' => 'title',
			'default' => '',
			'prompt' => '',
			'options' => WPV_Editor::get_wpcf7_posts('post_title'),
			'type' => 'select',
		) ,

		array(
			'name' => __('Title (optional)', 'church-event') ,
			'desc' => __('The title is placed just above the element.', 'church-event'),
			'id' => 'column_title',
			'default' => '',
			'type' => 'text'
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
	) ,
);
