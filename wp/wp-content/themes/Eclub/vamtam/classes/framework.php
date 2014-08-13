<?php

/**
 * Vamtam Theme Framework base class
 *
 * @author Nikolay Yordanov <me@nyordanov.com>
 * @package wpv
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * This is the first loaded framework file
 *
 * WpvFramework does the following (in this order):
 *  - sets constants for the frequently used paths
 *  - loads translations
 *  - loads the plugins bundled with the theme
 *  - loads some functions and helpers used in various places
 *  - sets the custom post types
 *  - loads the shortcode library for the framework
 *  - if this is wp-admin, load admin files
 *
 * This class also loads the custom widgets and sets what the theme supports (+ custom menus)
 */

class WpvFramework {

	/**
	 * Cache the result of some operations in memory
	 *
	 * @var array
	 */
	private static $cache = array();

	/**
	 * Initialize the Vamtam framework
	 * @param array $options framework options
	 */
	public function __construct($options) {
		// Autoload classes on demand
		if ( function_exists( "__autoload" ) )
			spl_autoload_register( "__autoload" );
		spl_autoload_register( array( $this, 'autoload' ) );

		$this->set_constants($options);
		$this->load_languages();
		$this->load_functions();
		$this->load_plugins();
		$this->load_types();
		$this->load_shortcodes();
		$this->load_admin();

		add_action('after_setup_theme', array(&$this, 'theme_supports'));
		add_action('widgets_init', array(&$this, 'load_widgets'));
		add_action('wp_before_admin_bar_render', array(&$this, 'setup_adminbar'));
		add_filter('wpv_purchase_code', create_function('', 'return wpv_get_option("envato-license-key");'));
	}

	/**
	 * Autoload classes when needed
	 *
	 * @param  string $class class name
	 */
	public function autoload($class) {
		$class = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', str_replace('_', '', $class)));

		if(strpos($class, 'wpv-') === 0) {
			$path = dirname(__FILE__).'/';
			$file = str_replace('wpv-', '', $class) . '.php';

			if ( is_readable( $path . $file ) ) {
				include_once( $path . $file );
				return;
			}

			if(is_admin()) {
				$admin_path = WPV_ADMIN . 'classes/';

				if ( is_readable( $admin_path . $file ) ) {
					include_once( $admin_path . $file );
					return;
				}
			}
		}

	}

	/**
	 * Get the theme version
	 *
	 * @return string theme version as defined in style.css
	 */
	public static function get_version() {
		if(isset(self::$cache['version']))
			return self::$cache['version'];

		$the_theme = wp_get_theme();
		if($the_theme->parent()) {
			$the_theme = $the_theme->parent();
		}

		self::$cache['version'] = $the_theme->get('Version');

		return self::$cache['version'];
	}

	/**
	 * Defines constants used by the theme
	 *
	 * @param array $options framework options
	 */
	private function set_constants($options) {
		define('THEME_NAME', $options['name']);
		define('THEME_SLUG', $options['slug']);

        // theme dir and uri
		define('THEME_DIR', get_template_directory() . '/');
		define('THEME_URI', get_template_directory_uri() .'/');

        // framework dir and uri
		define('WPV_DIR', THEME_DIR . 'vamtam/');
		define('WPV_URI', THEME_URI . 'vamtam/');

        // theme-specific assets dir and uri
		define('WPV_THEME_DIR', THEME_DIR . 'wpv_theme/');
		define('WPV_THEME_URI', THEME_URI . 'wpv_theme/');

        // common assets dir and uri
        define('WPV_ASSETS_DIR', WPV_DIR . 'assets/');
        define('WPV_ASSETS_URI', WPV_URI . 'assets/');

        // common file paths
		define('WPV_HELPERS', WPV_DIR . 'helpers/');
		define('WPV_IMAGES', WPV_ASSETS_URI . 'images/');
		define('WPV_IMPORTERS', WPV_DIR . 'importers/');
		define('WPV_PLUGINS', WPV_DIR . 'plugins/');
		define('WPV_PLUGINS_URI', WPV_URI . 'plugins/');
		define('WPV_SHORTCODES', WPV_DIR . 'shortcodes/');
		define('WPV_SHORTCODES_GENERATOR', WPV_SHORTCODES . 'generator/');
		define('WPV_SWF', WPV_ASSETS_URI . 'swf/');
		define('WPV_TYPES', WPV_DIR . 'types/');
		define('WPV_WIDGETS', WPV_DIR . 'widgets/');
		define('WPV_WIDGETS_ASSETS', WPV_WIDGETS . 'assets/');
		define('WPV_WIDGETS_TPL', WPV_WIDGETS . 'tpl/');
		define('WPV_FONTS_URI', WPV_ASSETS_URI . 'fonts/');
		define('WPV_INCLUDES', WPV_ASSETS_URI . 'includes/');
		define('WPV_JS', WPV_ASSETS_URI . 'js/');

        // theme-specific file paths
		define('WPV_THEME_ASSETS_DIR', WPV_THEME_DIR . 'assets/');
		define('WPV_THEME_ASSETS_URI', WPV_THEME_URI . 'assets/');
		define('WPV_THEME_OPTIONS', WPV_THEME_DIR . 'options/');
		define('WPV_THEME_HELPERS', WPV_THEME_DIR . 'helpers/');
		define('WPV_THEME_METABOXES', WPV_THEME_DIR . 'metaboxes/');
		define('WPV_THEME_IMAGES', WPV_THEME_ASSETS_URI . 'images/');
        define('WPV_THEME_CSS', WPV_THEME_ASSETS_URI . 'css/');
		define('WPV_THEME_CSS_DIR', WPV_THEME_ASSETS_DIR . 'css/');

		// sample content
		define('WPV_SAMPLES_DIR', THEME_DIR . 'samples/');
		define('WPV_SAMPLES_URI', THEME_URI . 'samples/');
		define('WPV_SAVED_OPTIONS', WPV_SAMPLES_DIR . 'saved_skins/');
		define('WPV_SAVED_OPTIONS_URI', WPV_SAMPLES_URI . 'saved_skins/');
		define('WPV_THEME_SAMPLE_CONTENT', WPV_SAMPLES_DIR . 'content.xml');
		define('WPV_THEME_SAMPLE_WIDGETS', WPV_SAMPLES_DIR . 'sidebars');

        // cache
        define('WPV_CACHE_DIR', THEME_DIR . 'cache/');
		define('WPV_CACHE_URI', THEME_URI . 'cache/');

        // admin
		define('WPV_ADMIN', WPV_DIR . 'admin/');
		define('WPV_ADMIN_URI', WPV_URI . 'admin/');
		define('WPV_ADMIN_AJAX', WPV_ADMIN_URI . 'ajax/');
		define('WPV_ADMIN_AJAX_DIR', WPV_ADMIN . 'ajax/');
		define('WPV_ADMIN_ASSETS_URI', WPV_ADMIN_URI . 'assets/');
		define('WPV_ADMIN_HELPERS', WPV_ADMIN . 'helpers/');
		define('WPV_ADMIN_METABOXES', WPV_ADMIN . 'metaboxes/');
		define('WPV_ADMIN_OPTIONS', WPV_ADMIN . 'options/');
		define('WPV_ADMIN_TEMPLATES', WPV_ADMIN . 'templates/');
		define('WPV_ADMIN_TYPES', WPV_ADMIN . 'types/');
	}

	/**
	 * Register theme support for various features
	 */
	public function theme_supports() {
		global $wpv_post_formats, $content_width;

		define('WPV_RESPONSIVE', wpv_get_optionb('is-responsive'));

		/**
		 * the max content width the css is built for should equal the actual content width,
		 * for example, the width of the text of a page without sidebars
		 */
		if( ! isset( $content_width ) ) $content_width = wpv_get_option('site-max-width');

		$wpv_post_formats = apply_filters('wpv_post_formats', array('aside', 'link', 'image', 'video', 'audio', 'quote', 'gallery'));

		// ini_set('pcre.backtrack_limit','200000');

		add_theme_support('post-thumbnails');

		add_theme_support('automatic-feed-links');

		add_theme_support('post-formats', $wpv_post_formats);

		if(function_exists('register_nav_menus')) {
			register_nav_menus(array(
				'menu-header' => __('Menu Header', 'church-event'),
				'menu-top' => __('Menu Top', 'church-event'),
			));
		}

		add_theme_support('wpv-reduced-ajax-single-response');
		add_theme_support('wpv-ajax-siblings');
		add_theme_support('wpv-page-title-style');
		add_theme_support('wpv-centered-text-divider');

		add_image_size('posts-widget-thumb', 60, 60, true);
		add_image_size('posts-widget-thumb-small', 43, 43, true);
		add_image_size('wpv-sermons-thumbnail', 106, 106, true);

		$size_names = array('single-portfolio', 'single-post', 'post-loop', 'portfolio-loop', 'post-small');
		$size_info = array();

		foreach($size_names as $name) {
			$size_info[$name] = (object)array(
				'wth' => abs(floatval(wpv_get_option("$name-images-wth"))),
				'crop' => true,
			);
		}

		$post_loop_width = 480;
		$height = $size_info['post-loop']->wth ? $post_loop_width/$size_info['post-loop']->wth : false;
		add_image_size( 'post-loop', $post_loop_width, $height, $size_info['post-loop']->crop );

		$width = $content_width - 2*60;

		$single_sizes = array('single-portfolio', 'single-post');
		$columnated_sizes = array('portfolio-loop', 'post-small');

		foreach($single_sizes as $name) {
			$height = $size_info[$name]->wth ? $width/$size_info[$name]->wth : false;
			add_image_size( $name, $width, $height, $size_info[$name]->crop );
		}

		for($num_columns = 1; $num_columns <= 4; $num_columns++) {
			$small_width = ($width + 30)/$num_columns - 30;
			add_image_size( 'portfolio-masonry-'.$num_columns, $small_width, 0 );

			foreach($columnated_sizes as $name) {
				$col_width = ($width + 30)/$num_columns - 30;
				$height = $size_info[$name]->wth ? $col_width/$size_info[$name]->wth : false;
				add_image_size( $name.'-'.$num_columns, $col_width, $height, $size_info[$name]->crop );
			}
		}
	}

	/**
	 * Load interface translations
	 */
	private function load_languages() {
		load_theme_textdomain('church-event', THEME_DIR . 'languages');
	}

	/**
	 * Loads the main php files used by the framework
	 */
	private function load_functions() {
		global $wpv_defaults, $wpv_fonts;
		$wpv_defaults = include WPV_SAMPLES_DIR . 'default-options.php';
		$wpv_fonts = include WPV_HELPERS . 'fonts.php';

		require_once WPV_HELPERS . 'init.php';

		require_once WPV_HELPERS . 'woocommerce-integration.php';
		require_once WPV_HELPERS . 'tribe-events-integration.php';

		require_once WPV_HELPERS . 'icons.php';

		new WpvFormatFilter;

		add_action('wpv_header_box', array('WpvFancyPortfolio', 'init_background'));
		add_action('wpv_after_top_header', array('WpvFancyPortfolio', 'init_ajax'));

		require_once WPV_HELPERS . 'base.php';
		require_once WPV_HELPERS . 'template.php';
		require_once WPV_HELPERS . 'css.php';
		require_once WPV_HELPERS . 'dimox-breadcrumbs.php';

		new WpvShortcodeOverrides;
		new WpvEnqueues;
	}

	/**
	 * Loads external plugins
	 */
	private function load_plugins() {
		require WPV_IMPORTERS . 'importer/importer.php';
		require WPV_IMPORTERS . 'widget-importer/importer.php';
	}

	/**
	 * Registers post types
	 */
	private function load_types() {
		// portfolios
		register_post_type('portfolio', array(
			'labels' => array(
				'name' => _x('Portfolios', 'post type general name', 'church-event' ),
				'singular_name' => _x('Portfolio', 'post type singular name', 'church-event' ),
				'add_new' => _x('Add New', 'portfolio', 'church-event' ),
				'add_new_item' => __('Add New Portfolio', 'church-event' ),
				'edit_item' => __('Edit Portfolio', 'church-event' ),
				'new_item' => __('New Portfolio', 'church-event' ),
				'view_item' => __('View Portfolio', 'church-event' ),
				'search_items' => __('Search Portfolios', 'church-event' ),
				'not_found' =>  __('No portfolios found', 'church-event' ),
				'not_found_in_trash' => __('No portfolios found in Trash', 'church-event' ),
				'parent_item_colon' => '',
			),
			'singular_label' => __('portfolio', 'church-event' ),
			'public' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array(
				'with_front' => false,
				'slug' => wpv_get_option('portfolio-slug')
			),
			'query_var' => false,
			'menu_position' => '55.4',
			'supports' => array(
				'comments',
				'editor',
				'excerpt',
				'page-attributes',
				'thumbnail',
				'title',
			)
		));

		register_taxonomy('portfolio_category','portfolio',array(
			'hierarchical' => true,
			'labels' => array(
				'name' => _x( 'Portfolio Categories', 'taxonomy general name', 'church-event' ),
				'singular_name' => _x( 'Portfolio Category', 'taxonomy singular name', 'church-event' ),
				'search_items' =>  __( 'Search Portfolio Categories', 'church-event' ),
				'popular_items' => __( 'Popular Portfolio Categories', 'church-event' ),
				'all_items' => __( 'All Portfolio Categories', 'church-event' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Portfolio Category', 'church-event' ),
				'update_item' => __( 'Update Portfolio Category', 'church-event' ),
				'add_new_item' => __( 'Add New Portfolio Category', 'church-event' ),
				'new_item_name' => __( 'New Portfolio Category Name', 'church-event' ),
				'separate_items_with_commas' => __( 'Separate Portfolio category with commas', 'church-event' ),
				'add_or_remove_items' => __( 'Add or remove portfolio category', 'church-event' ),
				'choose_from_most_used' => __( 'Choose from the most used portfolio category', 'church-event' )
			),
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => false,
		));

		register_post_type('testimonials', array(
			'labels' => array(
				'name' => _x('Testimonials', 'post type general name', 'church-event' ),
				'singular_name' => _x('Testimonial', 'post type singular name', 'church-event' ),
				'add_new' => _x('Add New', 'testimonials', 'church-event' ),
				'add_new_item' => __('Add New Testimonial', 'church-event' ),
				'edit_item' => __('Edit Testimonial', 'church-event' ),
				'new_item' => __('New Testimonial', 'church-event' ),
				'view_item' => __('View Testimonial', 'church-event' ),
				'search_items' => __('Search Testimonials', 'church-event' ),
				'not_found' =>  __('No testimonials found', 'church-event' ),
				'not_found_in_trash' => __('No testimonials found in Trash', 'church-event' ),
				'parent_item_colon' => '',
			),
			'singular_label' => __('testimonial', 'church-event' ),
			'public' => true,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => '55.3',
			'supports' => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'comments',
				'page-attributes'
			)
		));

		register_taxonomy('testimonials_category','testimonials',array(
			'hierarchical' => true,
			'labels' => array(
				'name' => _x( 'Testimonials Category', 'taxonomy general name', 'church-event' ),
				'singular_name' => _x( 'Testimonial Category', 'taxonomy singular name', 'church-event' ),
				'search_items' =>  __( 'Search Categories', 'church-event' ),
				'popular_items' => __( 'Popular Categories', 'church-event' ),
				'all_items' => __( 'All Categories', 'church-event' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Testimonials Category', 'church-event' ),
				'update_item' => __( 'Update Testimonials Category', 'church-event' ),
				'add_new_item' => __( 'Add New Testimonials Category', 'church-event' ),
				'new_item_name' => __( 'New Testimonials Category Name', 'church-event' ),
				'separate_items_with_commas' => __( 'Separate Testimonials category with commas', 'church-event' ),
				'add_or_remove_items' => __( 'Add or remove testimonials category', 'church-event' ),
				'choose_from_most_used' => __( 'Choose from the most used testimonials category', 'church-event' )
			),
			'show_ui' => true,
			'query_var' => false,
			'rewrite' => false,
		));

		if(wpv_get_option('portfolio-slug') !== wpv_get_option('previous-portfolio-slug')) {
			flush_rewrite_rules();
			wpv_update_option('previous-portfolio-slug', wpv_get_option('portfolio-slug'));
		}
	}

	/**
	 * Load shortcodes
	 */
	private function load_shortcodes() {
		include WPV_SHORTCODES . 'gallery.php';

		$shortcodes = include WPV_THEME_METABOXES . 'shortcode.php';

		foreach($shortcodes as $name) {
			$longname = WPV_SHORTCODES . $name . '.php';

			if(file_exists($longname))
				require_once $longname;
		}
	}

	/**
	 * Load widgets
	 */
	public function load_widgets() {
		$wpv_sidebars = WpvSidebars::getInstance();

		$wpv_sidebars->register_sidebars();

		add_filter('widget_text', 'do_shortcode');
		add_filter('widget_title', 'do_shortcode');

		$widgets = array(
			'advertisement',
			'authors',
			'contactinfo',
			'flickr',
			'gmap',
			'icon-link',
			'post-formats',
			'posts',
			'subpages',
		);

		$enabled = get_theme_support('wpv-enabled-widgets');
		if(is_array($enabled))
			$widgets = $enabled;

		foreach($widgets as $name) {
			require_once WPV_WIDGETS . "/$name.php";
		}
	}

	/**
	 * Loads the theme administration code
	 */
	private function load_admin() {
		if(!is_admin()) return;

		require_once 'plugin-activation.php';
		require_once WPV_SAMPLES_DIR . 'dependencies.php';

		new WpvAdmin;
	}

	/**
	 * Adds the Vamtam menu to the admin bar
	 */
	public function setup_adminbar() {
		if(!current_user_can('edit_theme_options')) return;

		global $wp_admin_bar;

		$wp_admin_bar->add_menu( array(
			'parent' => false,
			'id' => 'wpv-settings',
			'title' => __('Vamtam', 'church-event'),
			'href' => admin_url( 'admin.php?page=wpv_general'),
			'meta' => false
		));

		$adv_name = __('Theme options', 'church-event');

		$pages = array(
			'general' => __('General Settings', 'church-event'),
			'layout' => __('Layout', 'church-event'),
			'styles' => __('Styles', 'church-event'),
			'import' => __('Quick Import', 'church-event'),
			'help' => __('Help', 'church-event'),
		);

		foreach($pages as $id => $name) {
			$wp_admin_bar->add_menu( array(
				'parent' => 'wpv-settings',
				'id' => "wpv-$id",
				'title' => $name,
				'href' => admin_url("admin.php?page=wpv_$id"),
				'meta' => false
			));
		}
	}
}
