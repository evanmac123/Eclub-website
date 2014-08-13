<?php if(isset($post_data['media'])): ?>
	<div class="thumbnail">
		<?php if(has_post_format('image') && !$show_content): ?>
			<a href="<?php the_permalink() ?>" title="<?php the_title_attribute()?>">
		<?php endif ?>
				<?php echo $post_data['media']; ?>
		<?php if(has_post_format('image') && !$show_content): ?>
			</a>
		<?php endif ?>
	</div>
<?php endif; ?>

<?php if($show_content): ?>
	<div class="post-content-wrapper">
			<div class="post-actions-wrapper">
				<?php include(locate_template('templates/post/main/part-date.php')); ?>
				<?php include(locate_template('templates/post/main/part-actions.php')); ?>
			</div>
			<div class="post-right">
				<div class="post-content-outer">
					<?php
						include(locate_template('templates/post/header.php'));

						echo $post_data['content'];
					?>
				</div>
			</div>
	</div>
<?php endif; ?>