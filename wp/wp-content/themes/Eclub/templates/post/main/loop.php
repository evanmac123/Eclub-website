<div class="post-row">
	<?php include(locate_template('templates/post/main/loop-date.php')); ?>
	<div class="post-row-center">
		<?php if (isset($post_data['media'])):?>
			<div class="post-media">
				<div class='media-inner'>
					<?php echo $post_data['media']; ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="post-content-outer">
			<?php
				include(locate_template('templates/post/header-large.php'));
				include(locate_template('templates/post/content.php'));
				include(locate_template('templates/post/meta-loop.php'));
			?>
		</div>
	</div>
	<?php include(locate_template('templates/post/main/loop-actions.php')); ?>
</div>