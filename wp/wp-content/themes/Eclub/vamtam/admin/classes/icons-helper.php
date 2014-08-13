<?php

/**
 * Icons Helper
 *
 * @package wpv
 */
/**
 * class WpvIconsHelper
 */
class WpvIconsHelper extends WpvAjax {
	/**
	 * Hook ajax actions
	 */
	public function __construct() {
		$this->actions = array(
			'get-icon-list' => 'get_icon_list',
		);

		parent::__construct();
	}

	/**
	 * JSON-encoded list of icons
	 */
	public function get_icon_list() {
		header('Content-type: application/json');

		$icons = wpv_get_icons_extended();
		$result = array();

		$result[''] = '<span>'.__('No icon').'</span>';

		foreach($icons as $key => $name) {
			$result[$key] = '<span title="'.esc_attr($name).'" class="vamtam-icon '. (strpos($key, 'theme-') === 0 ? 'theme-icon' : '') . '">&#' . wpv_get_icon_num($key) . '</span>';
		}

		echo json_encode($result);
		
		exit;
	}
}
