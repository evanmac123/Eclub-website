<?php

class WPV_Sermons {
	public function __construct() {
		add_shortcode('wpv_sermons', array(__CLASS__, 'shortcode'));
	}

	public static function shortcode($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'count' => 1,
			'cat' => '',
			'pagination' => false,
		), $atts));

		$pagination = wpv_sanitize_bool( $pagination );

		$query = array(
			'post_type' => 'wpv_sermon',
			'posts_per_page' => (int)$count,
		);

		if ( $pagination ) {
			$query['paged'] = get_query_var( 'paged' ) > 1 ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );
		}

		if(!empty($cat) && !empty($cat[0])) {
			$query['tax_query'] = array(
				array(
					'taxonomy' => 'wpv_sermons_category',
					'field' => 'slug',
					'terms' => explode(',', $cat),
				)
			);
		}

		$query = new WP_Query( $query );

		ob_start();

		include locate_template("templates/sermons/loop.php");

		return ob_get_clean();
	}
}

new WPV_Sermons;
