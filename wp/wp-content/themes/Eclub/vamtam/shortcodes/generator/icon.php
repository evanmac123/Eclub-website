<?php

return array(
	"name" => __("Icon", 'church-event') ,
	"value" => "icon",
	"options" => array(
		array(
			'name' => __('Name', 'church-event') ,
			'id' => 'name',
			'default' => '',
			'type' => 'icons',
		) ,
		array(
			"name" => __("Color (optional)", 'church-event') ,
			"id" => "color",
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
			"type" => "select",
		) ,
		array(
			'name' => __('Size', 'church-event'),
			'id' => 'size',
			'type' => 'range',
			'default' => 16,
			'min' => 8,
			'max' => 100,
		),
		array(
			"name" => __("Style", 'church-event') ,
			"id" => "style",
			"default" => '',
			"prompt" => __('Default', 'church-event'),
			"options" => array(
				'inverted-colors' => __('Invert colors', 'church-event'),
				'box' => __('Box', 'church-event'),
			) ,
			"type" => "select",
		) ,
	)
);