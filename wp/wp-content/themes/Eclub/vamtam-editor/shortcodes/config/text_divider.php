<?php
return array(
	'name' => __('Text Divider', 'church-event') ,
	'icon' => array(
		'char' => WPV_Editor::get_icon('minus'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'text_divider',
	'controls' => 'name clone edit delete',
	'options' => array(
		array(
			'name' => __('Type', 'church-event') ,
			'id' => 'type',
			'default' => 'single',
			'options' => array(
				'single' => __('Title in the middle', 'church-event') ,
				'double' => __('Title above divider', 'church-event') ,
			) ,
			'type' => 'select',
			'class' => 'add-to-container',
			'field_filter' => 'ftds',
		) ,
		array(
			'name' => __('Text', 'church-event') ,
			'id' => 'html-content',
			'default' => __('Text Divider', 'church-event'),
			'type' => 'editor',
			'class' => 'ftds ftds-single ftds-double',
		) ,
	) ,
);
