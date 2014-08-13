<?php

class WPV_Widget_Sermon_Categories extends WP_Widget_Categories {
	public function __construct() {
		$widget_ops = array( 'classname' => 'wpv_widget_sermon_categories', 'description' => __( "A list or dropdown of sermon categories.", 'wpv' ) );
		WP_Widget::__construct('wpv_sermon_categories', __('Vamtam - Sermon Categories', 'wpv'), $widget_ops);
	}

	public function widget( $args, $instance ) {
			extract( $args );

			$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Categories', 'wpv' ) : $instance['title'], $instance, $this->id_base);
			$c = ! empty( $instance['count'] ) ? '1' : '0';
			$h = ! empty( $instance['hierarchical'] ) ? '1' : '0';
			$d = ! empty( $instance['dropdown'] ) ? '1' : '0';

			echo $before_widget;
			if ( $title )
				echo $before_title . $title . $after_title;

			$cat_args = array('orderby' => 'name', 'show_count' => $c, 'hierarchical' => $h, 'taxonomy' => 'wpv_sermons_category',);

			if ( $d ) {
				$cat_args['show_option_none'] = __('Select Category', 'wpv');
				wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
	?>

	<script type='text/javascript'>
	/* <![CDATA[ */
		var dropdown = document.getElementById("cat");
		function onCatChange() {
			if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
				location.href = "<?php echo home_url(); ?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
			}
		}
		dropdown.onchange = onCatChange;
	/* ]]> */
	</script>

	<?php
			} else {
	?>
			<ul>
	<?php
			$cat_args['title_li'] = '';
			wp_list_categories(apply_filters('widget_categories_args', $cat_args));
	?>
			</ul>
	<?php
			}

			echo $after_widget;
		}
}

register_widget('WPV_Widget_Sermon_Categories');
