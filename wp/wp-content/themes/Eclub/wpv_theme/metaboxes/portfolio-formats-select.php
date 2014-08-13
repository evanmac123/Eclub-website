<?php
/**
 * Vamtam Portfolio Format Selector
 *
 * @package wpv
 * @subpackage church-event
 */

return array(

array(
	'name' => __('Portfolio Format', 'church-event'),
	'type' => 'separator'
),

array(
	'name' => __('Portfolio Data Type', 'church-event'),
	'desc' => __('Image - uses the featured image (default)<br />
				  Gallery - use the featured image as a title image but show additional images too<br />
				  Video/Link - uses the "portfolio data url" setting<br />
				  Document - acts like a normal post<br />
				  HTML - overrides the image with arbitrary HTML when displaying a single portfolio page. Does not work with the ajax portfolio.
				', 'church-event'),
	'id' => 'portfolio_type',
	'type' => 'radio',
	'options' => array(
		'image' => __('Image', 'church-event'),
		'gallery' => __('Gallery', 'church-event'),
		'video' => __('Video', 'church-event'),
		'link' => __('Link', 'church-event'),
		'document' => __('Document', 'church-event'),
		'html' => __('HTML', 'church-event'),
	),
	'default' => 'image',
),

);
