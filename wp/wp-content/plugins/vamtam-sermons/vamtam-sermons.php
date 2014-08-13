<?php

/*
Plugin Name: Vamtam Sermons
Description: Semons post type (backend code only)
Version: 1.0.1
Author: Vamtam
Author URI: http://vamtam.com
*/


class Vamtam_Sermons {
	const VERSION = '1.0.1';

	public function __construct() {
		add_action( 'init', array( __CLASS__, 'init' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'load_metaboxes' ) );
		add_action( 'save_post', array( __CLASS__, 'load_metaboxes' ) );
		add_action( 'widgets_init', array( __CLASS__, 'load_widgets' ) );
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );

		if ( !class_exists( 'Vamtam_Updates' ) )
			require 'vamtam-updates/class-vamtam-updates.php';

		$plugin_slug = basename( dirname( __FILE__ ) );
		$plugin_file = basename( __FILE__ );

		new Vamtam_Updates( array(
			'slug' => $plugin_slug,
			'main_file' => $plugin_slug . '/' . $plugin_file,
		) );
	}

	/**
	 * flush rewrite rules on update/install
	 */
	public static function admin_init() {
		if ( get_option( 'vamtam-sermons-version' ) !== self::VERSION ) {
			flush_rewrite_rules();
			update_option( 'vamtam-sermons-version', self::VERSION );
		}
	}

	/**
	 * Register post type and taxonomy
	 */
	public static function init() {
		register_post_type('wpv_sermon', array(
			'labels' => array(
				'name' => _x('Sermons', 'post type general name', 'wpv' ),
				'singular_name' => _x('Sermon', 'post type singular name', 'wpv' ),
				'add_new' => _x('Add New', 'sermon', 'wpv' ),
				'add_new_item' => __('Add New Sermon', 'wpv' ),
				'edit_item' => __('Edit Sermon', 'wpv' ),
				'new_item' => __('New Sermon', 'wpv' ),
				'view_item' => __('View Sermon', 'wpv' ),
				'search_items' => __('Search Sermons', 'wpv' ),
				'not_found' =>  __('No Sermons found', 'wpv' ),
				'not_found_in_trash' => __('No Sermons found in Trash', 'wpv' ),
				'parent_item_colon' => '',
			),
			'singular_label' => __('Sermon', 'wpv' ),
			'public' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array(
				'with_front' => false,
				'slug' => 'sermon'
			),
			'query_var' => false,
			'menu_position' => 55,
			'supports' => array(
				'author',
				'comments',
				'editor',
				'page-attributes',
				'thumbnail',
				'title',
			)
		));

		register_taxonomy('wpv_sermons_category','wpv_sermon',array(
			'hierarchical' => true,
			'labels' => array(
				'name' => _x( 'Categories', 'taxonomy general name', 'wpv' ),
				'singular_name' => _x( 'Sermon Category', 'taxonomy singular name', 'wpv' ),
				'search_items' =>  __( 'Search Categories', 'wpv' ),
				'popular_items' => __( 'Popular Categories', 'wpv' ),
				'all_items' => __( 'All Categories', 'wpv' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Sermon Category', 'wpv' ),
				'update_item' => __( 'Update Sermon Category', 'wpv' ),
				'add_new_item' => __( 'Add New Sermon Category', 'wpv' ),
				'new_item_name' => __( 'New Sermon Category Name', 'wpv' ),
				'separate_items_with_commas' => __( 'Separate Sermon category with commas', 'wpv' ),
				'add_or_remove_items' => __( 'Add or remove Sermon category', 'wpv' ),
				'choose_from_most_used' => __( 'Choose from the most used Sermon category', 'wpv' )
			),
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => false,
		));
	}

	/**
	 * Add metabox, if the required Vamtam API is present
	 *
	 * @param int|null $post_id  id of the current post (if any)
	 */
	public static function load_metaboxes( $post_id = null ) {
		if ( class_exists( 'WpvMetaboxesGenerator' ) && defined( 'WPV_THEME_METABOXES' ) ) {
			$config = array(
				'id' => 'vamtam-sermon-options',
				'title' => __('VamTam Sermon Options', 'wpv'),
				'pages' => array('wpv_sermon'),
				'context' => 'normal',
				'priority' => 'high',
				'post_id' => $post_id,
			);


			$options = include WPV_THEME_METABOXES . 'sermons.php';
			new WpvMetaboxesGenerator($config, $options);
		}
	}

	/**
	 * Register widgets
	 */
	public static function load_widgets() {
		$widgets = array(
			'categories',
			'recent',
		);

		foreach ( $widgets as $name ) {
			require_once plugin_dir_path( __FILE__ ) . "widgets/$name.php";
		}
	}
}

new Vamtam_Sermons;
