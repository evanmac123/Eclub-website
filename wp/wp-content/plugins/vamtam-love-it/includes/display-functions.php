<?php

// outputs the love it link
function wpv_li_love_link($love_text = null, $loved_text = null) {

	global $user_ID, $post;

	ob_start();

	// retrieve the total love count for this item
	$love_count = wpv_li_get_love_count($post->ID);

	// our wrapper DIV
	echo '<div class="love-it-wrapper">';

	$love_text = is_null($love_text) ? __( 'Love It', 'love_it' ) : $love_text;
	$loved_text = is_null($loved_text) ? __( 'You have loved this', 'love_it' ) : $loved_text;

	// only show the Love It link if the user has NOT previously loved this item
	if( ! wpv_li_user_has_loved_post( $user_ID, get_the_ID() ) ) {
		echo '<a href="#" class="love-it" data-post-id="' . get_the_ID() . '" data-user-id="' .  $user_ID . '">' . $love_text . '</a> <span class="love-count">' . $love_count . '</span>';
	} else {
		// show a message to users who have already loved this item
		echo '<span class="loved"><span class="loved-text">' . $loved_text . '</span> <span class="love-count">' . $love_count . '</span></span>';
	}

	// close our wrapper DIV
	echo '</div>';

	// append our "Love It" link to the item content.
	$link = ob_get_clean();

	return $link;
}
