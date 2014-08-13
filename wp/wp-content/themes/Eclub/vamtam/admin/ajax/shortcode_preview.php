<?php
	global $wpv_is_shortcode_preview;
	$wpv_is_shortcode_preview = true;

	$GLOBALS['current_wpv_shortcode'] = stripslashes($_POST['data']);

	require_once( '../../../../../../wp-load.php' );

	define('WPV_NO_PAGE_CONTENT', true);
?><!doctype html>
<html>
<head>
	<?php wp_head() ?>
</head>
<body class="shortcode-preview">
	<div id="preview-content">
		<div>
			<?php echo apply_filters('the_content', do_shortcode($GLOBALS['current_wpv_shortcode'])) ?>
	<?php get_footer() ?>
</body>
</html>
