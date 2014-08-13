<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'church-event'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('sortby'); ?>"><?php _e('Sort by:', 'church-event'); ?></label>
	<select name="<?php echo $this->get_field_name('sortby'); ?>" id="<?php echo $this->get_field_id('sortby'); ?>" class="widefat">
		<option value="menu_order"<?php selected($instance['sortby'], 'menu_order'); ?>><?php _e('Page order', 'church-event'); ?></option>
		<option value="post_title"<?php selected($instance['sortby'], 'post_title'); ?>><?php _e('Page title', 'church-event'); ?></option>
		<option value="ID"<?php selected($instance['sortby'], 'ID'); ?>><?php _e('Page ID', 'church-event'); ?></option>
	</select>
</p>

<p>
	<label for="<?php echo $this->get_field_id('exclude'); ?>"><?php _e('Exclude:', 'church-event'); ?></label>
	<input type="text" value="<?php echo $exclude; ?>" name="<?php echo $this->get_field_name('exclude'); ?>" id="<?php echo $this->get_field_id('exclude'); ?>" class="widefat" />
	
	<small><?php _e('Page IDs, separated by commas.', 'church-event'); ?></small>
</p>