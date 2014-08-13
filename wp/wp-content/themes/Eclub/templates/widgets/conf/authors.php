<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'church-event'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>

<p>
	<label><?php _e('Show Avatar:', 'church-event'); ?></label>
	<?php
		$id = $this->get_field_name('show_avatar');
		$checked = $show_avatar;
		include WPV_ADMIN_HELPERS . 'config_generator/toggle-basic.php';
	?>
</p>

<p>
	<label><?php _e('Show Post Count:', 'church-event'); ?></label>
	<?php
		$id = $this->get_field_name('show_post_count');
		$checked = $show_post_count;
		include WPV_ADMIN_HELPERS . 'config_generator/toggle-basic.php';
	?>
</p>

<p>
	<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('How many authors to display?', 'church-event'); ?></label>
	<select id="<?php echo $this->get_field_id('count'); ?>" class="num_shown" name="<?php echo $this->get_field_name('count'); ?>">
		<?php for($i=1; $i<=$this->max_authors; $i++): ?>
			<option <?php selected($i, $count) ?>><?php echo $i ?></option>
		<?php endfor ?>
	</select>
</p>

<p>
	<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Filter by post type', 'church-event'); ?></label>
	<select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>">
		<?php
			$types = array(
				''     => __('Do not filter', 'church-event'),
				'post' => __('Posts', 'church-event'),
			);

			if ( is_plugin_active( 'vamtam-sermons/vamtam-sermons.php' ) ) {
				$types['wpv_sermon'] = __('Sermons', 'church-event');
			}
		?>
		<?php foreach ( $types as $type => $name ): ?>
			<option <?php selected( $type, $post_type) ?> value="<?php echo esc_attr( $type ) ?>"><?php echo $name ?></option>
		<?php endforeach ?>
	</select>
</p>

<div class="authors_wrap hidden_wrap">
	<?php
		for($i=1; $i<=$this->max_authors; $i++):
			$author_id = "author_id_$i";
			$author_desc = "author_desc_$i";
	?>
		<div class="hidden_el" <?php if($i>$count):?>style="display:none"<?php endif;?>>
			<p>
				<label for="<?php echo $this->get_field_id($author_id); ?>">
					<?php _e('Author:', 'church-event')?>
				</label>
				<select name="<?php echo $this->get_field_name($author_id); ?>" id="<?php echo $this->get_field_id($author_id); ?>" class="widefat">
					<?php foreach($authors as $user_id => $display_name):?>
						<option value="<?php echo $user_id ?>" <?php if($selected_author[$i] == $user_id) echo 'selected="selected"'?>><?php echo $display_name?></option>;
					<?php endforeach ?>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( $author_desc ); ?>">
					<?php _e('Author Description (optional):', 'church-event')?>
				</label>
				<textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id($author_desc); ?>" name="<?php echo $this->get_field_name($author_desc); ?>"><?php echo $author_descriptions[$i]; ?></textarea>
			</p>

		</div>

	<?php endfor;?>
</div>