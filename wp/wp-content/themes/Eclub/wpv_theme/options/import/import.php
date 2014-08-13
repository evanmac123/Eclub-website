<?php

/**
 * Theme options / Import / Quick Import
 *
 * @package wpv
 * @subpackage church-event
 */

$disabled = $disabled_content = '';

if ( wpv_get_option( 'used-one-click-import' ) ) {
	$disabled_content = 'disabled';
}

$layerslider = function_exists( 'is_plugin_active' ) && is_plugin_active( 'layerslider/layerslider.php' );

return array(

array(
	'name' => __( 'Quick Import', 'church-event' ),
	'type' => 'start',
	'nosave' => true,
),

array(
	'name' => __('What is included in the content import?', 'church-event'),
	'desc' => __('The sample data for the Contact Form 7 plugin is part of the "content import". If you indend to use this plugin now or at a later time, please make sure that you have installed and enabled it <strong>before</strong> importing the demo content.', 'church-event'),
	'type' => 'info',
	'visible' => true,
),

array(
	'name' => __( 'Content Import', 'church-event' ),
	'desc' => __( 'You are advised to use this importer only on new WordPress sites, as in doing so you will end up with quite a lot of example posts, pages, slides and portfolio items.', 'church-event' ),
	'title' => __( 'Import Dummy Content', 'church-event' ),
	'link' => $disabled_content !== 'disabled' ? wp_nonce_url( admin_url( 'admin.php?import=wpv&step=2&file='.WPV_THEME_SAMPLE_CONTENT ), 'wpv-import' ) : 'javascript:void( 0 )',
	'type' => 'button',
	'button_class' => "$disabled_content",
),

array(
	'name' => __( 'Widget Import', 'church-event' ),
	'desc' => __( 'Using this importer will overwrite your current sidebar settings', 'church-event' ),
	'title' => __( 'Import Widgets', 'church-event' ),
	'link' => wp_nonce_url( admin_url( 'admin.php?import=wpv_widgets&file='.WPV_THEME_SAMPLE_WIDGETS ), 'wpv-import' ),
	'type' => 'button',
),

array(
	'name' => __('Layer Slider', 'church-event'),
	'desc' => __('The theme uses Layered Slider and its option panel is found in the WordPress main navigation menu on the left.<br/>You will import the sliders seen in the demo website using this importer.', 'church-event'),
	'title' => __('Import Layer Slider Samples', 'church-event'),
	'link' => $layerslider ? wp_nonce_url('?page=layerslider&action=import_sample', 'import-sample-sliders') : 'javascript:void(0)',
	'type' => 'button',
	'button_class' => $layerslider ? '' : 'disabled',
),

	array(
		'type' => 'end',
	),

);