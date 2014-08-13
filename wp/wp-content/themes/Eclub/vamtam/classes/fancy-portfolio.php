<?php

/**
 * Helpers used to retrieve the data for the fancy portfolio layouts
 *
 * @package wpv
 */
/**
 * class WpvFancyPortfolio
 */
class WpvFancyPortfolio {
	/**
	 * Current portfolio type
	 * @var string
	 */
	protected static $type;

	/**
	 * Current portfolio categories
	 * @var array
	 */
	protected static $cats;

	/**
	 * Get the current portfolio categories
	 *
	 * @return array list of category slugs
	 */
	public static function get_categories() {
		global $post;

		if(!isset(self::$cats))
			self::$cats = is_page() ? unserialize(get_post_meta($post->ID, 'fancy-portfolio-categories', true)) : array();

		return self::$cats;
	}

	/**
	 * Get the current portfolio type
	 *
	 * @return string "background" or "page"
	 */
	public static function get_type() {
		global $post;

		if(!isset(self::$type))
			self::$type = is_page() ? get_post_meta($post->ID, 'fancy-portfolio-type', true) : 'disabled';

		return self::$type;
	}

	/**
	 * Checks whether the current page has a fancy portfolio of type $type
	 * @param  string  $type portfolio type
	 * @return boolean       whether the current page has a fancy portfolio of type $type
	 */
	public static function has($type) {
		return self::get_type() == $type;
	}

	/**
	 * returns the portfolio items for the fancy portfolio sliders
	 *
	 * @return array
	 */
	public static function get() {
		global $post;

		$cats = self::get_categories();
		$type = self::get_type();

		$query = array(
			'post_type' => 'portfolio',
			'orderby'=>'menu_order',
			'order'=>'ASC',
			'posts_per_page' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'portfolio_category',
					'field' => 'slug',
					'terms' => $cats,
				)
			),
		);

		$items = get_posts($query);

		return self::$type($items);
	}

	/**
	 * deals with the "full background" layout
	 *
	 * @param  array $items
	 * @return array
	 */
	private static function background($items) {
		$data = array();

		foreach($items as $p) {
			$img = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'full');
			if(isset($img[3]))
				unset($img[3]);

			$gallery = array();

			if(get_post_meta($p->ID, 'portfolio_type', true) == 'gallery') {
				$image_ids = self::get_gallery_images($p);

				foreach($image_ids as $image_id) {
					$sub_img = wp_get_attachment_image_src($image_id,'full');
					if(isset($sub_img[3]))
						unset($sub_img[3]);
					$gallery[] = $sub_img;
				}

				json_encode($gallery);
			}

			$excerpt = post_password_required($p) ?
						__( 'There is no excerpt because this is a protected post.', 'church-event' ) :
						apply_filters( 'get_the_excerpt', $p->post_excerpt );

			$item = array(
				'href' => get_permalink($p->ID),
				'img' => $img,
				'title' => get_the_title($p->ID),
				'description' => $excerpt
			);

			if (!empty($gallery))
				$item['img'] = $gallery;

			$data[] = $item;
		}

		return $data;
	}

	/**
	 * deals with the "ajax portfolio" layout
	 * @param  array $items
	 * @return array
	 */
	private static function page($items) {
		$data = array();

		foreach($items as $p) {
			$portfolio_type = get_post_meta($p->ID, 'portfolio_type', true);

			$item = array(
				'id' => $p->ID,
			);

			$img = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'full');

			if($portfolio_type != 'video') {
				$first_child = array(
					'pageUrl' => get_permalink($p->ID),
					'title' => get_the_title($p->ID),
					'type' => 'image',
					'url' => $img[0],
				);
			}

			if($portfolio_type == 'gallery') {
				$children = array();

				$image_ids = self::get_gallery_images($p);

				foreach($image_ids as $image_id) {
					$sub_img = wp_get_attachment_image_src($image_id,'full');
					$child = array(
						'pageUrl' => get_permalink($p->ID),
						'title' => get_the_title($p->ID),
						'url' => $sub_img[0],
						'type' => 'image',
					);

					if($sub_img[0] != $img[0]);
						$children[] = $child;
				}

				$item['children'] = $children;
				$item['type'] = $portfolio_type;

			} elseif($portfolio_type == 'video') {
				global $wp_embed;

				$item = array_merge($item, array(
					'html' => $wp_embed->run_shortcode('[embed]'.get_post_meta($p->ID, 'portfolio_data_url', true).'[/embed]'),
					'pageUrl' => get_permalink($p->ID),
					'title' => get_the_title($p->ID),
					'type' => 'html',
				));
			} else {
				$item = array_merge($item, $first_child);
				$item['type'] = apply_filters('wpv_fancy_portfolio_item_type', $portfolio_type);
			}

			$data[] = $item;
		}

		return $data;
	}

	/**
	 * returns a list of gallery ids
	 *
	 * @param $post WP_Post  regular WP post object
	 * @return array
	 */
	private static function get_gallery_images($post) {
		list($gallery, ) = WpvPostFormats::get_first_gallery($post->post_content, null, 'full');

		$pattern = get_shortcode_regex();
		preg_match( "/$pattern/s", $gallery, $matches );

		$attr = shortcode_atts(array(
			'ids' => '',
		), shortcode_parse_atts( $matches[3] ));

		return empty($attr['ids']) ? array() : explode(',', $attr['ids']);
	}

	/**
	 * Initializes the background portfolio
	 */
	public static function init_background() {
		global $post;

		if(self::has('background')) {
			wp_enqueue_script('vamtam-fastslider');
			add_action('wp_footer', array(__CLASS__, 'background_controls'));
			define('WPV_NO_PAGE_CONTENT', true);
			get_footer();
			exit;
		}
	}

	/**
	 * Initializes the ajax portfolio
	 */
	public static function init_ajax() {
		if(WpvFancyPortfolio::has('page'))
			get_template_part('templates/ajax-portfolio-viewer');
	}

	/**
	 * Outputs the background portfolio controls
	 */
	public static function background_controls() {
		get_template_part('templates/background-portfolio');
	}
}
