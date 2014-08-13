<?php
/**
 * Vamtam Post Options
 *
 * @package wpv
 * @subpackage church-event
 */

return array(

array(
	'name' => __('General', 'church-event'),
	'type' => 'separator',
),

array(
	"name" => __("Cite", 'church-event') ,
	"id" => "testimonial-author",
	"default" => "",
	"type" => "text",
) ,

array(
	"name" => __("Link", 'church-event') ,
	"id" => "testimonial-link",
	"default" => "",
	"type" => "text",
) ,

);
