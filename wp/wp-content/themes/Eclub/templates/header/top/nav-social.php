<div class="grid-1-2" id="top-nav-social">
	<?php if(wpv_get_option("top-bar-social-lead") != ''): ?>
		<span><?php wpvge("top-bar-social-lead") ?></span>
	<?php endif ?>
	<?php
		$map = array(
			'fb' => 'theme-facebook',
			'twitter' => 'twitter',
			'linkedin' => 'linkedin',
			'gplus' => 'googleplus',
			'flickr' => 'flickr',
			'pinterest' => 'pinterest1',
			'dribbble' => 'dribbble1',
		);

		foreach ($map as $option=>$icon): ?>
			<?php if(wpv_get_option("top-bar-social-$option") != ''): ?>
				<a href="<?php echo esc_attr(wpv_get_option("top-bar-social-$option")) ?>"><?php echo wpv_shortcode_icon(array(
					'name' => $icon
				)) ?></a>
			<?php endif ?>
		<?php endforeach; ?>
</div>