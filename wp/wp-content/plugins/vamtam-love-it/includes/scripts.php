<?php

function wpv_li_front_end_js() {
	wp_enqueue_script('jquery-cookie', WPV_LI_BASE_URL . '/includes/js/jquery.cookie.js', array( 'jquery' ) );
	wp_enqueue_script('love-it', WPV_LI_BASE_URL . '/includes/js/love-it.js', array( 'jquery', 'jquery-cookie' ) );
	wp_localize_script( 'love-it', 'love_it_vars',
		array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce('love-it-nonce'),
			'already_loved_message' => __('You have already loved this item.', 'love_it'),
			'error_message' => __('Sorry, there was a problem processing your request.', 'love_it'),
			'logged_in' => is_user_logged_in()
		)
	);
}
add_action('wp_enqueue_scripts', 'wpv_li_front_end_js');