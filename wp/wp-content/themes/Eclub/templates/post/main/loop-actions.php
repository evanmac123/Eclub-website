<?php
/**
 * Post (in loop) actions
 *
 * @package wpv
 */

if( !(
		function_exists('wpv_li_love_link') ||
		current_user_can('edit_post', get_the_ID()) ||
		(wpv_get_optionb('meta_comment_count') && comments_open())
	)
  )
	return;
?>

<div class="post-row-right">
	<?php include(locate_template('templates/post/main/part-actions.php')); ?>
</div>
