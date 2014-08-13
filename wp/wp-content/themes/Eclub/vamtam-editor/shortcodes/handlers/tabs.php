<?php

class WPV_Tabs {
	public function __construct() {
		add_shortcode( 'tabs', array( __CLASS__, 'shortcode' ) );
	}

	public static function shortcode($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'layout' => 'horizontal',
			'left_color' => 'accent8',
			'right_color' => 'accent1',
			'nav_color' => 'accent2',
		), $atts));

		if (!wpv_sub_shortcode('tab', $content, $params, $sub_contents))
			return 'error parsing slider shortcode';

		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('front-jquery.ui.tabs.rotate');

		global $wpv_tabs_shown;
		if(!isset($wpv_tabs_shown))
			$wpv_tabs_shown = 0;

		$wpv_tabs_shown++;

		$id = 'tabs-'.$wpv_tabs_shown;

		$output = '<ul class="ui-tabs-nav">';

		if(isset($GLOBALS['wpv_last_column_title']) && !empty($GLOBALS['wpv_last_column_title']) && $layout == 'vertical')
			$output .= '<li class="inactive-block-title"><h2>'.$GLOBALS['wpv_last_column_title'].'</h2></li>';

		foreach($params as $i=>$p) {
			$p = shortcode_atts(array(
				'title' => '',
				'class' => '',
				'icon' => '',
			), $p);

			$p['icon'] = empty($p['icon']) ? '' : wpv_shortcode_icon(array(
				'name' => $p['icon'],
			));

			$class = isset($p['class']) ? " class='tab-{$p['class']}'" : '';

			$output .= '<li'.$class.'><a href="#tab-' . $wpv_tabs_shown . '-' . $i . '-' . self::sanitize_id( $params[$i]['title'] ).'">' . $p['icon'] . ' <span class="title-text">' . $p['title'] . '</span></a></li>';
		}
		$output .= '</ul>';

		foreach($sub_contents as $i=>$c) {
			$class = isset($params[$i]['class']) ? ' tab-'.$params[$i]['class'] : '';
			$output .= '<div class="pane'.$class.'" id="tab-' . $wpv_tabs_shown . '-' . $i . '-' . self::sanitize_id( $params[$i]['title'] ).'">' . do_shortcode(trim($c)) . '</div>';
		}

		$style = '';
		if($layout == 'vertical') {
			$l = new WpvLessc();
			$l->importDir = '.';
			$l->setFormatter("compressed");

			$left_color = wpv_sanitize_accent($left_color);
			$right_color = wpv_sanitize_accent($right_color);
			$nav_color = wpv_sanitize_accent($nav_color);

			$inner_style = '';

			if(!empty($left_color) && !empty($right_color)) {
				$inner_style = $l->compile("
					#{$id}.vertical {
						&,
						&:before {
							background: $right_color;
						}

						.ui-tabs-nav {
							&,
							&:before,
							li {
								background: $left_color;
							}

							li {
								&, a, a .icon {
									color: $nav_color;
								}
							}

							.ui-state-active,
							.ui-state-selected,
							.ui-state-hover {
								background: $right_color;
							}

							.inactive-block-title {
								h1, h2, h3, h4, h5, h6 {
									color: $nav_color;
								}
							}
						}

						.pane {
							&:before {
								background: $left_color;
							}
						}
					}
				");
			}

			$style = '<style>'.$inner_style.'</style>';
		}

		return '<div class="wpv-tabs '.$layout.'" id="'.$id.'">' . $output . '</div>' . $style;
	}

	public static function sanitize_id( $title ) {
		if ( class_exists( 'Transliterator' ) ) {
			$transliterator = Transliterator::create( 'Any-Latin; Latin-ASCII' );

			if ( is_a( $transliterator, 'Transliterator' ) ) {
				$title = $transliterator->transliterate( $title );
			} else {
				$transliterator = Transliterator::create( 'Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC' );

				if ( is_a( $transliterator, 'Transliterator' ) ) {
					$title = $transliterator->transliterate( $title );
				}
			}
		} else if ( function_exists( 'iconv' ) ) {
			$title = iconv( 'UTF-8', 'ASCII//TRANSLIT', $title );
		}

		return sanitize_title_with_dashes( $title );
	}
}

new WPV_Tabs;
