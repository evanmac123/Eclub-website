<?php

/**
 * Theme options / General / General Settings
 *
 * @package wpv
 * @subpackage church-event
 */

return array(
array(
	'name' => __('General Settings', 'church-event'),
	'type' => 'start'
),

array(
	'name' => __('Custom Logo Picture', 'church-event'),
	'desc' => __('Optional way to replace "heading" and "description" text for your website with an image. Leave blank if none required.', 'church-event'),
	'id' => 'custom-header-logo',
	'type' => 'upload',
	'static' => true,
),

array(
	'name' => __('Alternative Logo', 'church-event'),
	'desc' => __('This logo is used when you are using the transparent sticky header. It must be the same size as the main logo.', 'church-event'),
	'id' => 'custom-header-logo-transparent',
	'type' => 'upload',
	'static' => true,
),

array(
	'name' => __('Splash Screen Logo', 'church-event'),
	'id' => 'splash-screen-logo',
	'type' => 'upload',
	'static' => true,
),

array(
	'name' => __('Favicon', 'church-event'),
	'desc' => __('Upload your custom "favicon" which is visible in browser favourites and tabs. (Must be .png or .ico file - preferably 16px by 16px ). Leave blank if none required.', 'church-event'),
	'id' => 'favicon_url',
	'type' => 'upload',
	'static' => true,
),

array(
	'name' => __('Google Maps API Key', 'church-event'),
	'desc' => __("Only required if you have more than 2500 map loads per day. Paste your Google Maps API Key here. If you don't have one, please sign up for a <a href='https://developers.google.com/maps/documentation/javascript/tutorial#api_key'>Google Maps API key</a>.", 'church-event'),
	'id' => 'gmap_api_key',
	'type' => 'text',
	'static' => true,
	'class' => 'hidden',

),

array(
	'name' => __('Google Analytics Key', 'church-event'),
	'desc' => __("Paste your key here. It should be something like UA-XXXXX-X. We're using the faster asynchronous loader, so you don't need to worry about speed.", 'church-event'),
	'id' => 'analytics_key',
	'type' => 'text',
	'static' => true,
),

array(
	'name' => __('"Scroll to Top" Button', 'church-event'),
	'desc' => __('It is found in the bottom right side. It is sole purpose is help the user scroll a long page quickly to the top.', 'church-event'),
	'id' => 'show_scroll_to_top',
	'type' => 'toggle',
),

array(
	'name' => __('Feedback Button', 'church-event'),
	'desc' => __('It is found on the right hand side of your website. You can chose from a "link" or a slide out form(widget area).The slide out form is configured as a standard widget. You can use the same form you are using for your "contact us" page.', 'church-event'),
	'id' => 'feedback-type',
	'type' => 'select',
	'options' => array(
		'none' => __('None', 'church-event'),
		'link' => __('Link', 'church-event'),
		'sidebar' => __('Slide out widget area', 'church-event'),
	),
),

array(
	'name' => __('Feedback Button Link', 'church-event'),
	'desc' => __('If you have chosen a "link" in the option above, place the link of the button here, usually to your contact us page.', 'church-event'),
	'id' => 'feedback-link',
	'type' => 'text',
),

array(
	'name' => __('Share Icons', 'church-event'),
	'desc' => __('Select the social media you want enabled and for which parts of the website', 'church-event'),
	'type' => 'social',
	'static' => true,
),

array(
	'name' => __('Custom JavaScript', 'church-event'),
	'desc' => __('If the hundreds of options in the Theme Options Panel are not enough and you need customisation that is outside of the scope of the Theme Option Panel please place your javascript in this field. The contents of this field are placed near the <strong>&lt;/body&gt;</strong> tag, which improves the load times of the page.', 'church-event'),
	'id' => 'custom_js',
	'type' => 'textarea',
	'rows' => 15,
	'static' => true,
),

array(
	'name' => __('Custom CSS', 'church-event'),
	'desc' => __('If the hundreds of options in the Theme Options Panel are not enough and you need customisation that is outside of the scope of the Theme Options Panel please place your CSS in this field.', 'church-event'),
	'id' => 'custom_css',
	'type' => 'textarea',
	'rows' => 15,
	'class' => 'top-desc',
),

array(
	'type' => 'end'
)
);