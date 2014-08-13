<?php

class WPV_Widget_Recent_Sermons extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'wpv_widget_recent_sermons', 'description' => __( "Your site&#8217;s most recent Sermons.", 'wpv') );
		parent::__construct('wpv-recent-sermons', __('Vamtam - Recent Sermons', 'wpv'), $widget_ops);

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

		function widget($args, $instance) {
			$cache = wp_cache_get('wpv_widget_recent_sermons', 'widget');

			if ( !is_array($cache) )
				$cache = array();

			if ( ! isset( $args['widget_id'] ) )
				$args['widget_id'] = $this->id;

			if ( isset( $cache[ $args['widget_id'] ] ) ) {
				echo $cache[ $args['widget_id'] ];
				return;
			}

			ob_start();
			extract($args);

			$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Sermons', 'wpv' );
			$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
			$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
			if ( ! $number )
	 			$number = 10;
			$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

			$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'post_type' => 'wpv_sermon' ) ) );

			include(locate_template('templates/widgets/front/recent-sermons.php'));

			$cache[$args['widget_id']] = ob_get_flush();
			wp_cache_set('wpv_widget_recent_sermons', $cache, 'widget');
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number'] = (int) $new_instance['number'];
			$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
			$this->flush_widget_cache();

			$alloptions = wp_cache_get( 'alloptions', 'options' );
			if ( isset($alloptions['wpv_widget_recent_sermons']) )
				delete_option('wpv_widget_recent_sermons');

			return $instance;
		}

		function flush_widget_cache() {
			wp_cache_delete('wpv_widget_recent_sermons', 'widget');
		}

		function form( $instance ) {
			$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
			$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
	?>
			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wpv' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

			<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of sermons to show:', 'wpv' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

			<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', 'wpv' ); ?></label></p>
	<?php
		}
}

register_widget('WPV_Widget_Recent_Sermons');