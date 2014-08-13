<?php
return array(
	'name' => __('Featured Products', 'church-event') ,
	'icon' => array(
		'char' => WPV_Editor::get_icon('cart1'),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'wpv_featured_products',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => __('Columns', 'church-event') ,
			'id' => 'columns',
			'default' => 4,
			'min' => 2,
			'max' => 4,
			'type' => 'range',
		) ,
		array(
			'name' => __('Limit', 'church-event') ,
			'desc' => __('Maximum number of products.', 'church-event') ,
			'id' => 'per_page',
			'default' => 3,
			'min' => 1,
			'max' => 50,
			'type' => 'range',
		) ,

		array(
			'name' => __('Order By', 'church-event') ,
			'id' => 'orderby',
			'default' => 'date',
			'type' => 'radio',
			'options' => array(
				'date' => __('Date', 'church-event'),
				'menu_order' => __('Menu Order', 'church-event'),
			),
		) ,

		array(
			'name' => __('Order', 'church-event') ,
			'id' => 'order',
			'default' => 'desc',
			'type' => 'radio',
			'options' => array(
				'desc' => __('Descending', 'church-event'),
				'asc' => __('Ascending', 'church-event'),
			),
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
				'double' => __('Title with divider below', 'church-event'),
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
			),
		) ,
	) ,
);
