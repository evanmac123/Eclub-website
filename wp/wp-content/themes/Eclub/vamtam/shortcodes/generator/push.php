<?php
return array(
	'name' => __('Vertical Blank Space', 'church-event') ,
	'value' => 'push',
	'options' => array(
		array(
			"name" => __("Height", 'church-event') ,
			"id" => "h",
			"default" => 30,
			'min' => -200,
			'max' => 200,
			"type" => "range",
		) ,
	) ,
);
