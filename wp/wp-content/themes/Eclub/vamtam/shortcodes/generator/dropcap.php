<?php
return array(
	'name' => __('Drop Cap', 'church-event') ,
	'value' => 'dropcap',
	'options' => array(
		array(
			'name' => __('Type', 'church-event') ,
			'id' => 'type',
			'default' => '1',
			'type' => 'select',
			'options' => array(
				'1' => __('Type 1', 'church-event'),
				'2' => __('Type 2', 'church-event'),
			),
		) ,
		array(
			'name' => __('Text', 'church-event') ,
			'id' => 'text',
			'default' => '',
			'type' => 'text',
		) ,
	) ,
);
