<?php
/**
 * Post (in loop) actions - inner part
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

<div class="post-actions">
	<?php if(!post_password_required()): ?>
		<?php if(wpv_get_optionb('meta_comment_count') && comments_open()): ?>
			<div class="comment-count">
				<?php comments_popup_link(__('0 <span class="comment-word">Comments</span>', 'church-event'), __('1 <span class="comment-word">Comment</span>', 'church-event'), __('% <span class="comment-word">Comments</span>', 'church-event')); ?>
			</div>
		<?php endif; ?>

		<?php if(function_exists('wpv_li_love_link')): ?>
			<div class="love-count-outer">
				<?php echo wpv_li_love_link('<span class="visuallyhidden">'.__('Love it', 'church-event').'</span>',
				                            '<span class="visuallyhidden">'.__('You have loved this.', 'church-event').'</span>'); ?>
			</div>
		<?php endif ?>

		<?php edit_post_link('<span class="icon">' . wpv_get_icon('pencil') . '</span><span class="visuallyhidden">'. __('Edit', 'church-event') .'</span>') ?>
	<?php endif ?>
</div>