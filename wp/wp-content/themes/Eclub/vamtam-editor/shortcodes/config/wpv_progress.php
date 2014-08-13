<?php
return array(
	'name' => __('Progress Indicator', 'church-event') ,
	'desc' => __('You can chose from % indicator or animateed number.' , 'church-event'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('meter-medium'),
		'size' => '26px',
		'lheight' => '39px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'wpv_progress',
	'controls' => 'size name clone edit delete',
	'options' => array(
		array(
			'name' => __('Type', 'church-event'),
			'id' => 'type',
			'type' => 'select',
			'default' => 'percentage',
			'options' => array(
				'percentage' => __('Percentage', 'church-event'),
				'number' => __('Number', 'church-event'),
			),
			'field_filter' => 'fpis',
		),

		array(
			'name' => __('Percentage', 'church-event') ,
			'id' => 'percentage',
			'default' => 0,
			'type' => 'range',
			'min' => 0,
			'max' => 100,
			'unit' => '%',
			'class' => 'fpis fpis-percentage',
		) ,

		array(
			'name' => __('Value', 'church-event') ,
			'id' => 'value',
			'default' => 0,
			'type' => 'range',
			'min' => 0,
			'max' => 1000,
			'class' => 'fpis fpis-number',
		) ,

		array(
			'name' => __('Track Color', 'church-event') ,
			'id' => 'bar_color',
			'default' => 'accent1',
			'type' => 'color',
			'class' => 'fpis fpis-percentage',
		) ,

		array(
			'name' => __('Bar Color', 'church-event') ,
			'id' => 'track_color',
			'default' => 'accent7',
			'type' => 'color',
			'class' => 'fpis fpis-percentage',
		) ,

		array(
			'name' => __('Value Color', 'church-event') ,
			'id' => 'value_color',
			'default' => 'accent2',
			'type' => 'color',
		) ,

		) ,


);
