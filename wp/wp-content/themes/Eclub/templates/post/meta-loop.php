<?php
/**
 * Post metadata template
 *
 * @package  wpv
 */
?>
<div class="post-meta">
	<nav class="clearfix">
		<?php if(wpv_get_optionb('show-post-author')): ?>
			<div class="author"><span class="icon theme"><?php wpv_icon('ink-tool');?></span><?php the_author_posts_link()?></div>
		<?php endif ?>

		<?php if(!post_password_required()): ?>
			<?php if(wpv_get_optionb('meta_posted_in')): ?>
				<div><span class="icon"><?php wpv_icon('folder1'); ?></span><span class="visuallyhidden"><?php _e('Category', 'church-event') ?></span><?php the_category(', '); ?></div>
				<?php
				// Tags
				the_tags('<div class="the-tags"><span class="icon">' . wpv_get_icon('tag') . '</span><span class="visuallyhidden">'.__('Category', 'church-event').'</span>', ', ', '</div>')?>
			<?php endif ?>
		<?php endif ?>
	</nav>
</div>