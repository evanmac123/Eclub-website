<?php
return 	array(
	'name' => __('Team Member', 'church-event'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('profile'),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'team_member',
	'controls' => 'size name clone edit delete',
	'options' => array(

		array(
			'name' => __('Name', 'church-event'),
			'id' => 'name',
			'default' => '',
			'type' => 'text',
			'holder' => 'h5',
		),
		array(
			'name' => __('Position', 'church-event'),
			'id' => 'position',
			'default' => 'Web Developer',
			'type' => 'text'
		),
		array(
			'name' => __('Link', 'church-event'),
			'id' => 'url',
			'default' => '/',
			'type' => 'text'
		),
		array(
			'name' => __('Email', 'church-event'),
			'id' => 'email',
			'default' => 'support@vamtam.com',
			'type' => 'text'
		),
		array(
			'name' => __('Phone', 'church-event'),
			'id' => 'phone',
			'default' => '',
			'type' => 'text'
		),
		array(
			'name' => __('Picture url', 'church-event'),
			'id' => 'picture',
			'default' => 'http://makalu.vamtam.com/wp-content/uploads/2013/03/people4.png',
			'type' => 'upload'
		),
		array(
			'name' => __('Google+', 'church-event'),
			'id' => 'googleplus',
			'default' => '/',
			'type' => 'text'
		),
		array(
			'name' => __('LinkedIn', 'church-event'),
			'id' => 'linkedin',
			'default' => '',
			'type' => 'text'
		),
		array(
			'name' => __('Facebook', 'church-event'),
			'id' => 'facebook',
			'default' => '/',
			'type' => 'text'
		),
		array(
			'name' => __('Twitter', 'church-event'),
			'id' => 'twitter',
			'default' => '/',
			'type' => 'text'
		),
		array(
			'name' => __('YouTube', 'church-event'),
			'id' => 'youtube',
			'default' => '/',
			'type' => 'text'
		),

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
