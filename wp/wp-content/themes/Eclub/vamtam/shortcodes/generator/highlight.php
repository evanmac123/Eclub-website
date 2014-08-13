<?php

return array(
	"name" => __("Highlight", 'church-event') ,
	"value" => "highlight",
	"options" => array(
		array(
			"name" => __("Type", 'church-event') ,
			"id" => "type",
			"default" => '',
			"options" => array(
				"light" => __("light", 'church-event') ,
				"dark" => __("dark", 'church-event') ,
			) ,
			"type" => "select",
		) ,
		array(
			"name" => __("Content", 'church-event') ,
			"id" => "content",
			"default" => "",
			"type" => "textarea"
		) ,
	)
);