<?php

/**
 * Expandable services shortcode options
 *
 * @package wpv
 * @subpackage editor
 */

return array(
	'name' => __('Expandable Box ', 'church-event') ,
	'desc' => __('You have open and closed states of the box and you can set diffrenet content and background of each state.' , 'church-event'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('expand1'),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'services_expandable',
	'controls' => 'size name clone edit delete',
	'callbacks' => array(
		'init' => 'init-expandable-services',
		'generated-shortcode' => 'generate-expandable-services',
	),
	'options' => array(
		array(
			'name' => __('Backgrounds', 'church-event') ,
			'type' => 'color-row',
			'inputs' => array(
				'background' => array(
					'name' => __('Closed state:', 'church-event'),
					'default' => 'accent1',
				),
				'hover_background' => array(
					'name' => __('Expanded state:', 'church-event'),
					'default' => 'accent2',
				),
			),
		) ,

		array(
			'name' => __('Closed state image', 'church-event') ,
			'id' => 'image',
			'default' => '',
			'type' => 'upload'
		) ,

		array(
			'name' => __(' Closed state icon', 'church-event') ,
			'desc' => __('The icon will not be visable if you have an image in the option above.', 'church-event'),
			'id' => 'icon',
			'default' => '',
			'type' => 'icons',
		) ,
		array(
			"name" => __("Icon Color", 'church-event') ,
			"id" => "icon_color",
			"default" => 'accent6',
			"type" => "color",
		) ,
		array(
			'name' => __('Icon Size', 'church-event'),
			'id' => 'icon_size',
			'type' => 'range',
			'default' => 62,
			'min' => 8,
			'max' => 100,
		),
		array(
			'name' => __('Closed state text', 'church-event') ,
			'id' => 'closed',
			'default' => __('This is Photoshop’s version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet.
Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.
Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit.', 'church-event'),
			'type' => 'textarea',
			'class' => 'noattr',
		) ,

        array(
			'name' => __('Expanded state', 'church-event') ,
			'id' => 'html-content',
			'default' => __('This is Photoshop’s version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet.
Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.
Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit.', 'church-event').'[split]'.
			             __('This is Photoshop’s version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet.
Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.
Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit.', 'church-event'),
			'type' => 'editor',
			'holder' => 'textarea',
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
