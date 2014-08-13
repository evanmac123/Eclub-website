<?php
return array(
	'name' => __('Box with a Link', 'church-event') ,
	'desc' => __('You can set a link, background color and hover color to a section of the website and place your content there.' , 'church-event'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('link5'),
		'size' => '30px',
		'lheight' => '40px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'linkarea',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => __('Background Color', 'church-event') ,
			'id' => 'background_color',
			'default' => '',
			'prompt' => __('No background', 'church-event'),
			'options' => array(
				'accent1' => __('Accent 1', 'church-event'),
				'accent2' => __('Accent 2', 'church-event'),
				'accent3' => __('Accent 3', 'church-event'),
				'accent4' => __('Accent 4', 'church-event'),
				'accent5' => __('Accent 5', 'church-event'),
				'accent6' => __('Accent 6', 'church-event'),
				'accent7' => __('Accent 7', 'church-event'),
				'accent8' => __('Accent 8', 'church-event'),
			),
			'type' => 'select'
		) ,
		array(
			'name' => __('Hover Color', 'church-event') ,
			'id' => 'hover_color',
			'default' => 'accent1',
			'prompt' => __('No background', 'church-event'),
			'options' => array(
				'accent1' => __('Accent 1', 'church-event'),
				'accent2' => __('Accent 2', 'church-event'),
				'accent3' => __('Accent 3', 'church-event'),
				'accent4' => __('Accent 4', 'church-event'),
				'accent5' => __('Accent 5', 'church-event'),
				'accent6' => __('Accent 6', 'church-event'),
				'accent7' => __('Accent 7', 'church-event'),
				'accent8' => __('Accent 8', 'church-event'),
			),
			'type' => 'select'
		) ,

		array(
			'name' => __('Link', 'church-event') ,
			'id' => 'href',
			'default' => '',
			'type' => 'text',
		) ,

		array(
			"name" => __("Target", 'church-event') ,
			"id" => "target",
			"default" => '_self',
			"options" => array(
				"_blank" => __('Load in a new window', 'church-event') ,
				"_self" => __('Load in the same frame as it was clicked', 'church-event') ,
			) ,
			"type" => "select",
		) ,

		array(
			'name' => __('Contents', 'church-event') ,
			'id' => 'html-content',
			'default' => __('This is Photoshop’s version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet.
Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.
Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit.', 'church-event'),
			'type' => 'editor',
			'holder' => 'textarea',
		) ,

		array(
			'name' => __('Icon', 'church-event') ,
			'desc' => __('This option overrides the "Image" option.', 'church-event'),
			'id' => 'icon',
			'default' => '',
			'type' => 'icons',
		) ,
		array(
			"name" => __("Icon Color", 'church-event') ,
			"id" => "icon_color",
			"default" => 'accent6',
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
			"type" => "select",
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
			'name' => __('Image', 'church-event') ,
			'desc' => __('The image will appear above the content.<br/><br/>', 'church-event'),
			'id' => 'image',
			'default' => '',
			'type' => 'upload',
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
