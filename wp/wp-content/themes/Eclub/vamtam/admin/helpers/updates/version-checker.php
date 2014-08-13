<?php

/*
 * Vamtam CRM Integration, used to check for updates and aiding support queries
 */

class Version_Checker {
	public $remote;
	public $interval;
	public $notice;

	public function __construct() {
		$this->remote   = 'http://api.vamtam.com/version';
		$this->interval = 2*3600;

		$username = trim( wpv_get_option( 'envato-username' ) );
		$api_key  = trim( wpv_get_option( 'envato-api-key' ) );

		if ( ! empty( $username ) && ! empty( $api_key ) ) {
			require_once 'class-pixelentity-theme-update.php';
			PixelentityThemeUpdate::init($username, $api_key, 'Vamtam');
		}

		if ( ! isset( $_GET['import'] ) && ( ! isset( $_GET['step'] ) || ( int ) $_GET['step'] != 2 ) ) {
			add_action( 'admin_notices', array( &$this, 'has_new_version' ) );
		}

		add_action( 'wp_ajax_wpv-check-license', array( __CLASS__, 'check_license' ) );
	}

	public static function check_license() {
		check_ajax_referer( 'wpv-check-license', 'nonce' );

		$api_check = wp_remote_get( "http://marketplace.envato.com/api/v3/{$_POST['username']}/{$_POST['api-key']}/vitals.json" );

		if ( ! is_wp_error( $api_check ) ) {
			if ( $api_check['response']['code'] >= 200 && $api_check['response']['code'] < 300  ) {
				echo '<span style="color: green">'; // xss ok
				_e( 'Valid Username and API Key', 'church-event' );
				echo '</span>'; // xss ok

				echo '<br>'; // xss ok

				$purchase_check = wp_remote_get( "http://marketplace.envato.com/api/v3/{$_POST['username']}/{$_POST['api-key']}/download-purchase:{$_POST['license-key']}.json" );

				$purchase_result = json_decode( $purchase_check['body'] );

				if ( ! is_wp_error( $purchase_check ) && $purchase_check['response']['code'] >= 200 && $purchase_check['response']['code'] < 300 && isset( $purchase_result->{'download-purchase'}->download_url ) ) {
					echo '<span style="color: green">'; // xss ok
					_e( 'Valid Purchase Code', 'church-event' );
					echo '</span>'; // xss ok
				} else {
					echo '<span style="color: red">'; // xss ok
					_e( 'Invalid Purchase Code', 'church-event' );
					echo '</span>'; // xss ok
				}
			} else {
				echo '<span style="color: red">'; // xss ok
				_e( 'Incorrect Username and/or API Key', 'church-event' );
				echo '</span>'; // xss ok
			}
		} else {
			echo '<span style="color: red">'; // xss ok
			_e( 'Cannot validate Username/API Key. Please try later; if the problem persists your server might not have the curl PHP extension enabled.', 'church-event' );
			echo '</span>'; // xss ok
		}

		die;
	}

	private function check_version() {
		$local_version = WpvFramework::get_version();
		$key           = THEME_SLUG.'_'.$local_version;

		$last_license_key    = wpv_get_option( 'envato-license-key-old' );
		$current_license_key = wpv_get_option( 'envato-license-key' );

		$system_status_opt_out_old = wpv_get_option( 'system-status-opt-out-old' );
		$system_status_opt_out     = wpv_get_option( 'system-status-opt-out' );

		if ( $last_license_key !== $current_license_key || $system_status_opt_out_old !== $system_status_opt_out || false === ( $response = get_transient( $key ) ) ) {
			global $wp_version;

			$data = array(
				'body' => array(
					'theme_version'  => $local_version,
					'php_version'    => phpversion(),
					'server'         => $_SERVER['SERVER_SOFTWARE'],
					'theme_name'     => THEME_NAME,
					'license_key'    => $current_license_key,
					'active_plugins' => self::active_plugins(),
					'system_status'  => self::system_status(),
				),
				'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url().'; ',
			);

			if ( $last_license_key !== $current_license_key ) {
				wpv_update_option( 'envato-license-key-old', $current_license_key );
			}

			if ( $system_status_opt_out_old !== $system_status_opt_out ) {
				wpv_update_option( 'system-status-opt-out-old', $system_status_opt_out_old );
			}

			$response = wp_remote_post( $this->remote, $data );

			set_transient( $key, $response, $this->interval ); // cache
		}

		return $response;
	}

	public function has_new_version() {
		$response = $this->check_version();
	}

	public static function active_plugins() {
		$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() )
			$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );

		return $active_plugins;
	}

	public static function system_status() {
		if ( wpv_get_option( 'system-status-opt-out' ) ) {
			return array( 'disabled' => true );
		}

		$result = array(
			'disabled'         => false,
			'wp_debug'         => WP_DEBUG,
			'wp_debug_display' => WP_DEBUG_DISPLAY,
			'wp_debug_log'     => WP_DEBUG_LOG,
			'active_plugins'   => array(),
			'writable'         => array(),
			'ziparchive'       => class_exists( 'ZipArchive' ),
		);

		if ( function_exists( 'ini_get' ) ) {
			$result['post_max_size']      = ini_get( 'post_max_size' );
			$result['max_input_vars']     = ini_get( 'max_input_vars' );
			$result['max_execution_time'] = ini_get( 'max_execution_time' );
			$result['memory_limit'] = ini_get( 'memory_limit' );
		}

		$active_plugins = self::active_plugins();

		foreach ( $active_plugins as $plugin ) {
			$plugin_data = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );

			$result['active_plugins'][$plugin] = array(
				'name'    => $plugin_data['Name'],
				'version' => $plugin_data['Version'],
				'author'  => $plugin_data['AuthorName'],
			);
		}

		$result['writable'][WPV_CACHE_DIR] = is_writable( WPV_CACHE_DIR );

		$dir = opendir( WPV_CACHE_DIR );
		while ( $file = readdir( $dir ) ) {
			if ( $file !== '.' && $file !== '..' && preg_match( '/\.css|less$/', $file ) ) {
				$filepath                      = WPV_CACHE_DIR . $file;
				$result['writable'][$filepath] = is_writable( $filepath );
			}
		}

		$response = wp_remote_post( THEME_URI . 'utils/lessc-spawn.php' );

		if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
			$result['wp_remote_post'] = 'OK';
		} elseif ( is_wp_error( $response ) ) {
			$result['wp_remote_post'] = 'NOT OK - ' . $response->get_error_message();
		} else {
			$result['wp_remote_post'] = 'NOT OK - unknown error';
		}

		return $result;
	}

}

new Version_Checker();
