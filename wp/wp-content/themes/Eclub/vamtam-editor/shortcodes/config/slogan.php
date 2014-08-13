<?php

/**
 * Slogan shortcode options
 *
 * @package wpv
 * @subpackage editor
 */

return array(
	'name' => __('Call Out Box', 'church-event') ,
	'desc' => __('You can place the call out box into а column - color box elemnent in order to have background color.' , 'church-event'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('font-size'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'slogan',
	'controls' => 'size name clone edit delete handle',
	'options' => array(
		array(
			'name' => __('Content', 'church-event') ,
			'id' => 'html-content',
			'default' => __('<h1>You can place your call out box text here</h1>', 'church-event'),
			'type' => 'editor',
			'holder' => 'textarea',
		) ,
		array(
			'name' => __('Button Text', 'church-event') ,
			'id' => 'button_text',
			'default' => 'Button Text',
			'type' => 'text'
		) ,
		array(
			'name' => __('Button Link', 'church-event') ,
			'id' => 'link',
			'default' => '',
			'type' => 'text'
		) ,
		array(
			'name' => __('Button Icon', 'church-event') ,
			'id' => 'button_icon',
			'default' => 'cart',
			'type' => 'icons',
		) ,
		array(
			'name' => __('Button Icon Style', 'church-event'),
			'type' => 'select-row',
			'selects' => array(
				'button_icon_color' => array(
					'desc' => __('Color:', 'church-event'),
					"default" => "accent 1",
					"prompt" => '',
					"options" => array(
						'accent1' => __('Accent 1', 'church-event'),
						'accent2' => __('Accent 2', 'church-event'),
						'accent3' => __('Accent 3', 'church-event'),
						'accent4' => __('Accent 4', 'church-event'),
						'accent5' => __('Accent 5', 'church-event'),
						'accent6' => __('Accent 6', 'church-event'),
						'accent7' => __('Accent 7', 'church-event'),
						'accent8' => __('Accent 8', 'church-event'),
					) ,
				),
				'button_icon_placement' => array(
					'desc' => __('Placement:', 'church-event'),
					"default" => 'left',
					"options" => array(
						'left' => __('Left', 'church-event'),
						'right' => __('Right', 'church-event'),
					) ,
				),
				),
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

	) ,
);
