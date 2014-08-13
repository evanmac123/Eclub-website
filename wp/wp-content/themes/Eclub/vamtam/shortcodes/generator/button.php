<?php
return array(
	'name' => __('Buttons', 'church-event') ,
	'value' => 'button',
	'options' => array(
		array(
			'name' => __('Text', 'church-event') ,
			'id' => 'text',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Style', 'church-event') ,
			'id' => 'style',
			'default' => 'filled-small',
			'options' => array(
				'filled' => __('Filled', 'church-event'),
				'filled-small' => __('Filled, small', 'church-event'),
				'border' => __('Border', 'church-event'),
			),
			'type' => 'select'
		) ,
		array(
			'name' => __('Font size', 'church-event') ,
			'id' => 'font',
			'default' => 24,
			'type' => 'range',
			'min' => 10,
			'max' => 64,
		) ,
		array(
			'name' => __('Background', 'church-event') ,
			'id' => 'bgColor',
			'default' => 'accent1',
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
			'name' => __('Hover Background', 'church-event') ,
			'id' => 'hover_color',
			'default' => 'accent1',
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
			'name' => __('Alignment', 'church-event') ,
			'id' => 'align',
			'default' => '',
			'prompt' => '',
			'options' => array(
				'left' => __('Left', 'church-event') ,
				'right' => __('Right', 'church-event') ,
				'center' => __('Center', 'church-event') ,
			) ,
			'type' => 'select',
		) ,
		array(
			'name' => __('Link', 'church-event') ,
			'id' => 'link',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Link Target', 'church-event') ,
			'id' => 'linkTarget',
			'default' => '_self',
			'options' => array(
				'_blank' => __('Load in a new window', 'church-event') ,
				'_self' => __('Load in the same frame as it was clicked', 'church-event') ,
			) ,
			'type' => 'select',
		) ,
		array(
			'name' => __('Icon', 'church-event') ,
			'id' => 'icon',
			'default' => '',
			'type' => 'icons',
		) ,
		array(
			'name' => __('Icon Style', 'church-event'),
			'type' => 'select-row',
			'selects' => array(
				'icon_color' => array(
					'desc' => __('Color:', 'church-event'),
					"default" => "",
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
				'icon_placement' => array(
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
			'name' => __('ID', 'church-event') ,
			'desc' => __('ID attribute added to the button element.', 'church-event'),
			'id' => 'id',
			'default' => '',
			'type' => 'text',
		) ,
		array(
			'name' => __('Class', 'church-event') ,
			'desc' => __('Class attribute added to the button element.', 'church-event'),
			'id' => 'class',
			'default' => '',
			'type' => 'text',
		) ,
	) ,
);
