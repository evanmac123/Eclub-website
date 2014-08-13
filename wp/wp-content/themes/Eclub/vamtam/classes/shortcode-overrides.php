<?php

/**
 * Various filters and actions configuring some of the shortcodes
 *
 * @package  wpv
 */

/**
 * class WpvShortcodeOverrides
 */
class WpvShortcodeOverrides {

	/**
	 * add filters
	 */
	public function __construct() {
		add_filter('wpv_multiwidget_tab_title', array(&$this, 'multiwidget_tab_title'), 10, 3);
		add_action('wpv_multiwidget_single_title', array(&$this, 'multiwidget_single_title'), 10, 2);
		add_filter('wpv_team_member_social_icon', array(&$this, 'team_member_social_icon'));
		add_filter('wpv_posts_widget_thumbnail_name', array(&$this, 'posts_widget_thumbnail_name'), 10, 2);
		add_filter('wpv_posts_widget_img_size', array(&$this, 'posts_widget_img_size'), 10, 2);
		add_filter('wpv_column_title', array(&$this, 'column_title'), 10, 2);

		add_filter('excerpt_length', array(&$this, 'excerpt_length'));
		add_filter('excerpt_more', array(&$this, 'excerpt_more'));

		add_filter( 'wp_title', array( __CLASS__, 'wp_title') );

		remove_filter('the_content', 'li_display_love_link', 100);

		wp_embed_register_handler( 'wpv-swf', '#https?://[^\s]+?.swf#i', array(&$this, 'embed_handler_swf') );

		add_filter('pre_option_page_for_posts', create_function('$value', 'return 0;'));

		add_filter('oembed_dataparse', array(&$this, 'oembed_dataparse'), 90, 3 );

		add_action('layerslider_ready', array(&$this, 'layerslider_ready'));

		add_filter('nav_menu_css_class', array(__CLASS__, 'nav_menu_css_class'), 10, 3);

		add_action('wpv_before_post_content', array(__CLASS__, 'single_sermon_media'));

		add_action('wpv_body', array(__CLASS__, 'wpv_splash_screen'));
	}

	public static function wp_title( $title ) {
		if( empty( $title ) && ( is_home() || is_front_page() ) ) {
			$description = get_bloginfo( 'description' );
			return get_bloginfo( 'name' ) . ( ! empty( $description ) ? ' | ' . $description : '' );
		}

		return $title;
	}

	public static function wpv_splash_screen() {
		$content = WpvTemplates::has_header_slider() ? '' : do_shortcode(wpv_post_meta(null, 'page-middle-header-content', true));
		$min_height = wpv_post_meta(null, 'page-middle-header-min-height', true);

		if ( wpv_post_meta(null, 'show-splash-screen', true) !== 'true' ) {
			return;
		}

		echo '<div class="wpv-splash-screen">
			<div class="wpv-splash-screen-logo"></div>
		</div>';
	}

	/**
	 * Single sermon media
	 */
	public static function single_sermon_media() {
		if(!is_singular('wpv_sermon')) {
			return;
		}

		ob_start();

		WpvTemplates::show_sermon_media();

		$media = ob_get_clean();

		echo '<div class="sermon-media-icons clearfix">' . $media . '</div>';
	}

	/**
	 * Remove unnecessary menu item classes
	 *
	 * @param  array  $classes current menu item classes
	 * @param  object $item    menu item
	 * @param  object $args    menu item args
	 * @return array           filtered classes
	 */
	public static function nav_menu_css_class($classes, $item, $args) {
		if(strpos($item->url, '#') !== false && ($key = array_search('current-menu-item', $classes)) !== false) {
			unset($classes[$key]);
			$classes[] = 'maybe-current-menu-item';
		}

		return $classes;
	}

	/**
	 * Modify LayerSlider configuration
	 */
	public function layerslider_ready() {
		$GLOBALS['lsAutoUpdateBox'] = false;
	}

	/**
	 * Wrap oEmbeds in .wpv-video-frame
	 *
	 * @param  string $output original oembed output
	 * @param  object $data   data from the oEmbed provider
	 * @param  string $url    original embed url
	 * @return string         $output wrapped in additional html
	 */
	public function oembed_dataparse($output, $data, $url) {
		if($data->type == 'video')
			return '<div class="wpv-video-frame">'.$output.'</div>';

		return $output;
	}

	/**
	 * Returns the HTML for the column titles, based on their type
	 *
	 * @param  string $title title text
	 * @param  string $type  title type
	 * @return string        column title html
	 */
	public function column_title($title, $type) {
		if($type === 'no-divider')
			return "<h2 class='column-title'>$title</h2>";

		return WPV_Text_Divider::shortcode(array(
			'more' => '',
			'type' => $type,
		), $title);
	}

	/**
	 * Implements .swf oEmbeds
	 *
	 * @param  array  $matches preg_match matches
	 * @param  array  $attr    embed attributes
	 * @param  string $url     embed url
	 * @param  array  $rawattr raw attributes
	 * @return string          output html
	 */
	public function embed_handler_swf( $matches, $attr, $url, $rawattr ) {
		$embed = sprintf(
				'
	<div class="wpv-video-frame">
		<object width="%2$s" height="%3$s" type="application/x-shockwave-flash" data="%1$s">
			<param name="movie" value="%1$s" />
			<param name="allowFullScreen" value="true" />
			<param name="allowscriptaccess" value="always" />
			<param name="wmode" value="transparent" />
			<embed src="%1$s" type="application/x-shockwave-flash" wmode="transparent" allowscriptaccess="always" allowfullscreen="true" width="%2$s" height="%3$s" />
		</object>
	</div>',
				esc_attr($matches[0]),
				esc_attr($attr['width']),
				esc_attr($attr['height'])
				);

		return apply_filters( 'wpv_embed_swf', $embed, $matches, $attr, $url, $rawattr );
	}

	/**
	 * Correct image size for the multiwidget images
	 *
	 * @param  int    $img_size original image size
	 * @param  array  $args     widget arguments
	 * @return int              image size
	 */
	public function posts_widget_img_size($img_size, $args) {
		if(strpos($args['id'], 'footer-sidebar') !== false)
			return 43;

		return 350;
	}

	/**
	 * Correct thumbnail name for the multiwidget images
	 *
	 * @param  string $img_size original thumbnail
	 * @param  array  $args     widget arguments
	 * @return string           thumbnail name
	 */
	public function posts_widget_thumbnail_name($img_size, $args) {
		if(strpos($args['id'], 'footer-sidebar') !== false)
			return 'posts-widget-thumb-small';

		return 'posts-widget-thumb';
	}

	/**
	 * Sets the excerpt length
	 *
	 * @param  int $length original length
	 * @return int         excerpt length
	 */
	public function excerpt_length($length) {
		global $wpv_loop_vars;

		if(isset($wpv_loop_vars) && $wpv_loop_vars['news'])
			return 15;

		return $length;
	}

	/**
	 * Sets the excerpt ending
	 *
	 * @param  string $more original ending
	 * @return string         excerpt ending
	 */
	public function excerpt_more($more) {
		return '...';
	}

	/**
	 * Add the tabbed widget icons
	 * @param  string $title  current tab title
	 * @param  string $slug   current tab slug
	 * @param  string $single if this is the only tab shown
	 * @return string         current tab title with icon
	 */
	public function multiwidget_tab_title($title, $slug, $single) {
		if($single)
			return '';

		$icons = array(
			'comment_count' => 'theme-heart',
			'date' => 'theme-pencil',
			'comments' => 'theme-comment',
			'tags' => 'theme-tag',
		);

		if(isset($icons[$slug])) {
			$title = esc_attr($title);
			return "<span title='$title'>".do_shortcode('[icon name="'.$icons[$slug].'"]').'</span>';
		}

		return $title;
	}

	/**
	 * Show the tab title if only one tab is to be displayed
	 * @param  string $only  tab slug
	 * @param  string $title tab title
	 */
	public function multiwidget_single_title($only, $title) {
		echo $title;
	}

	/**
	 * Show the corrent icon for the team member social options
	 * @param  string $icon social network slug
	 * @return string       icon slug
	 */
	public function team_member_social_icon($icon) {
		$icons = array(
			'googleplus' => 'googleplus3',
			'linkedin' => 'linkedin',
			'facebook' => 'facebook2',
			'twitter' => 'twitter2',
			'youtube' => 'youtube',
		);

		return isset($icons[$icon]) ? $icons[$icon] : $icon;
	}
}