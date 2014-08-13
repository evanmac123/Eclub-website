<?php

// check whether a user has loved an item
function wpv_li_user_has_loved_post($user_id, $post_id) {

	// get all item IDs the user has loved
	$loved = get_user_option('li_user_loves', $user_id);
	if(is_array($loved) && in_array($post_id, $loved)) {
		return true; // user has loved post
	}
	return false; // user has not loved post
}

// adds the loved ID to the users meta so they can't love it again
function wpv_li_store_loved_id_for_user($user_id, $post_id) {
	$loved = get_user_option('li_user_loves', $user_id);
	if(is_array($loved)) {
		$loved[] = $post_id;
	} else {
		$loved = array($post_id);
	}
	update_user_option($user_id, 'li_user_loves', $loved);
}

// increments a love count
function wpv_li_mark_post_as_loved($post_id, $user_id) {

	// retrieve the love count for $post_id
	$love_count = get_post_meta($post_id, '_li_love_count', true);
	if($love_count)
		$love_count = $love_count + 1;
	else
		$love_count = 1;

	if(update_post_meta($post_id, '_li_love_count', $love_count)) {
		// store this post as loved for $user_id
		wpv_li_store_loved_id_for_user($user_id, $post_id);
		return true;
	}
	return false;
}

// returns a love count for a post
function wpv_li_get_love_count($post_id) {
	$love_count = get_post_meta($post_id, '_li_love_count', true);
	if($love_count)
		return $love_count;
	return 0;
}

// processes the ajax request
function wpv_li_process_love() {
	if ( isset( $_POST['item_id'] ) && wp_verify_nonce($_POST['love_it_nonce'], 'love-it-nonce') ) {
		if(wpv_li_mark_post_as_loved($_POST['item_id'], $_POST['user_id'])) {
			echo 'loved';
		} else {
			echo 'failed';
		}
	}
	die();
}
add_action('wp_ajax_love_it', 'wpv_li_process_love');
add_action('wp_ajax_nopriv_love_it', 'wpv_li_process_love');
