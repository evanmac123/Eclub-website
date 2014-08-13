<?php
return array(
	'name' => __('Tabs', 'church-event') ,
	'desc' => __('Change to vertical or horizontal tabs from the element option panel.  Add an icon by clicking on the "pencil" icon next to the pane title. Adding tabs, changing the name of the tab and adding content into the tabs is done when the tab element is toggled.' , 'church-event'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('storage1'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'tabs',
	'controls' => 'size name clone edit delete always-expanded',
	'callbacks' => array(
		'init' => 'init-tabs',
		'generated-shortcode' => 'generate-tabs',
	),
	'options' => array(

		array(
			'name' => __('Layout', 'church-event') ,
			"id" => "layout",
			"default" => 'horizontal',
			"type" => "radio",
			'options' => array(
				'horizontal' => __('Horizontal', 'church-event'),
				'vertical' => __('Vertical', 'church-event'),
			),
			'field_filter' => 'fts',
		) ,
		array(
			'name' => __('Navigation Color', 'church-event') ,
			'id' => 'nav_color',
			'type' => 'color',
			'default' => 'accent2',
			'class' => 'fts fts-vertical',
		) ,
		array(
			'name' => __('Navigation Background', 'church-event') ,
			'id' => 'left_color',
			'type' => 'color',
			'default' => 'accent8',
			'class' => 'fts fts-vertical',
		) ,
		array(
			'name' => __('Content Background', 'church-event') ,
			'id' => 'right_color',
			'type' => 'color',
			'default' => 'accent1',
			'class' => 'fts fts-vertical',
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
				'single' => __('Title with divider next to it.', 'church-event'),
				'double' => __('Title with divider below', 'church-event'),
				'no-divider' => __('No Divider', 'church-event'),
			),
			'class' => 'fts fts-horizontal',
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
