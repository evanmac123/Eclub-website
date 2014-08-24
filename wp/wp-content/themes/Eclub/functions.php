<?php

/**
 * Theme functions. Initializes the Vamtam Framework.
 *
 * @package  wpv
 */

$GLOBALS['wpv_theme_tested_up_to'] = '3.9.x';

require_once('vamtam/classes/framework.php');

new WpvFramework(array(
	'name' => 'church-event',
	'slug' => 'church-event'
));

// TODO remove next line when the editor is fully functional, to be packaged as a standalone module with no dependencies to the theme
define ('VAMTAM_EDITOR_IN_THEME', true); include_once THEME_DIR.'vamtam-editor/editor.php';



add_shortcode('tc-my-thumb', 'tc_my_post_thumbnail');
function tc_my_post_thumbnail($atts) {
	extract( shortcode_atts( array(
		'size' => 'medium',
		'class' => 'my-thumb-class'
	), $atts ) );
	ob_start();
	echo '<div class="'.$class.'">';
	if ( has_post_thumbnail() ) {
		the_post_thumbnail($size);
	}
	echo '</div>';
	$output = ob_get_contents();
	ob_end_clean();
	echo $output;
}


add_filter("wpcf7_mail_tag_replaced", "suppress_wpcf7_filter");
function suppress_wpcf7_filter($value, $sub = ""){
	$out	=	!empty($sub) ? $sub : $value;
	$out	=	strip_tags($out);
	$out	=	wptexturize($out);
	return $out;
}