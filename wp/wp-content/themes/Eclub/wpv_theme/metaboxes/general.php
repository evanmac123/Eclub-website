<?php
/**
 * Vamtam Post Options
 *
 * @package wpv
 * @subpackage church-event
 */

return array(

array(
	'name' => __('Layout and Styles', 'church-event'),
	'type' => 'separator'
),

array(
	'name' => __('Page Slider', 'church-event'),
	'desc' => __('In the drop down you will see the sliders that you have created. Please note that the theme uses LayerSlider and its option panel is found in the WordPress navigation menu on the left.', 'church-event'),
	'id' => 'slider-category',
	'type' => 'select',
	'default' => '',
	'prompt' => __('Disabled', 'church-event'),
	'options' => WpvTemplates::get_all_sliders(),
	'class' => 'fbport fbport-disabled',
),

array(
	'name' => __('Show Splash Screen', 'church-event'),
	'desc' => __('This option is usuful if you have video background,
		 featured slider, galleries or other pages that will load considarable amount of time.', 'church-event'),
	'id' => 'show-splash-screen',
	'type' => 'toggle',
	'default' => false,
),

array(
	'name' => __('Header Featured Area', 'church-event'),
	'desc' => __('This option is only active if you have disabled the header slider. You can place plain text or HTML into it.', 'church-event'),
	'id' => 'page-middle-header-content',
	'type' => 'textarea',
	'default' => '',
	'class' => 'fbport fbport-disabled',
),

array(
	'name' => __('Full Width Header Featured Area', 'church-event'),
	'desc' => __('Extend the featured area to the end of the screen. This is basicly a full screen mode.', 'church-event'),
	'id' => 'page-middle-header-content-fullwidth',
	'type' => 'toggle',
	'default' => 'false',
),

array(
	'name' => __('Header Featured Area Minimum Height', 'church-event'),
	'desc' => __('Please note that this option does not affect the slider height. The slider height is controled from the LayerSlider option panel.', 'church-event'),
	'id' => 'page-middle-header-min-height',
	'type' => 'range',
	'default' => 0,
	'min' => 0,
	'max' => 1000,
	'unit' => 'px',
	'class' => 'fbport fbport-disabled',
),

array(
	'name' => __('Featured Area / Slider Background', 'church-event'),
	'desc' => __('This option is used for the featured area, header slider and the Ajax portfolio slider.<br>If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.', 'church-event'),
	'id' => 'local-title-background',
	'type' => 'background',
	'show' => 'color,image,repeat,size',
	'class' => 'fbport fbport-disabled fbport-page',
),

array(
	'name' => __('Sticky Header Behaviour', 'church-event'),
	'id' => 'sticky-header-type',
	'type' => 'select',
	'default' => 'normal',
	'options' => array(
		'normal' => __('Normal', 'church-event'),
		'over' => __('Over the page content', 'church-event'),
	),
	'class' => 'fbport fbport-disabled',
),

array(
	'name' => __('Page Title Background', 'church-event'),
	'id' => 'local-page-title-background',
	'type' => 'background',
	'show' => 'color,image,repeat,size',
	'class' => 'fbport fbport-disabled',
),

array(
	'name' => __('Show Page Title Area', 'church-event'),
	'desc' => __('Enables the area used by the page title.', 'church-event'),
	'id' => 'show-page-header',
	'type' => 'toggle',
	'default' => true,
	'class' => 'fbport fbport-disabled',
),

array(
	'name' => __('Description', 'church-event'),
	'desc' => __('The text will appear next or bellow the title of the page, only if the option above is enabled.', 'church-event'),
	'id' => 'description',
	'type' => 'textarea',
	'only' => 'page',
	'default' => '',
),

array(
	'name' => __('Show Body Top Widget Areas', 'church-event'),
	'desc' => __('The layout of these areas can be configured from "Vamtam" -> "Layout" -> "Body". In Appearance => Widgets you populate them with widgets.', 'church-event'),
	'image' => WPV_ADMIN_ASSETS_URI.'images/header-sidebars-3.png',
	'id' => 'show_header_sidebars',
	'type' => 'toggle',
	'default' => wpv_get_option('has-header-sidebars'),
	'has_default' => true,
	'class' => 'fbport fbport-disabled',
	'only' => 'page,post,portfolio,product,wpv_sermon',
),

array(
	'name' => __('Page Layout Type', 'church-event'),
	'desc' => __('The sidebars are placed just below the page title. You can choose one of the predefined layouts.', 'church-event'),
	'id' => 'layout-type',
	'type' => 'body-layout',
	'only' => 'page,post,portfolio,product,tribe_events,wpv_sermon',
	'default' => 'default',
	'has_default' => true,
	'class' => 'fbport fbport-disabled',
),
array(
	'name' => __('Custom Sidebars', 'church-event'),
	'desc' => __('This option correlates with the one above. If you have custom sidebars created, you will enable them by selecting them in the drop-down menu. Otherwise the page default sidebars will be used.', 'church-event'),
	'type' => 'select-row',
	'selects' => array(
		'left_sidebar_type' => array(
			'desc' => __('Left:', 'church-event'),
			'prompt' => __('Default', 'church-event'),
			'target' => 'sidebars',
			'default' => false,
		),
		'right_sidebar_type' => array(
			'desc' => __('Right:', 'church-event'),
			'prompt' => __('Default', 'church-event'),
			'target' => 'sidebars',
			'default' => false,
		),
	),
	'class' => 'fbport fbport-disabled',
),

array(
	'name' => __('Page Background', 'church-event'),
	'desc' => __('Please note that this option is used only in boxed layout mode.<br>
In full width layout mode the page background is covered by the header, slider, body and footer backgrounds respectively. If the color opacity of these areas is 1 or an opaque image is used, the page background won\'t be visible.<br>
If you want to use an image as a background, enabling the cover button will resize and crop the image so that it will always fit the browser window on any resolution.<br>
You can override this option on a page by page basis.', 'church-event'),
	'id' => 'background',
	'type' => 'background',
	'show' => 'color,image,repeat,size,attachment',
),

array(
	'name' => __('Use Bottom Padding on This Page', 'church-event'),
	'desc' => __('If you disable this option, the last element will stick to the footer. Useful for parallax pages.', 'church-event'),
	'id' => 'use-page-bottom-padding',
	'type' => 'toggle',
	'default' => true,
	'class' => 'fbport fbport-disabled',
),

array(
	'name' => __('Fancy Portfolio', 'church-event'),
	'type' => 'separator'
),

array(
	'name' => __('Type', 'church-event'),
	'desc' => __('If you select any of categories below, the fancy portfolio will be enabled.<br>
Full screen type portfolio will slide the portfolio items in full screen mode without showing the text of the items. It is similar to a gallery.<br>
Ajax portfolio type will open the portfolio item in the top of the  same listing page.', 'church-event'),
	'id' => 'fancy-portfolio-type',
	'type' => 'select',
	'only' => 'page',
	'options' => array(
		'disabled' => __('Disabled', 'church-event'),
		'background' => __('Full background', 'church-event'),
	),
	'field_filter' => 'fbport',
) ,

array(
	'name' => __('Categories', 'church-event'),
	'id' => 'fancy-portfolio-categories',
	'default' => array(),
	'target' => 'portfolio_category',
	'type' => 'multiselect',
	'only' => 'page',
	'layout' => 'checkbox',
) ,

array(
	'name' => __('Ajax Slide Resizing Method', 'church-event'),
	'desc' => __('None - the images in their real size.<br>
Resize and crop - It will cover the slider window regardless of the image sizes.<br>
Fit - I will fit the image into the slider window keeping the proportions.', 'church-event'),
	'id' => 'fancy-portfolio-resizing',
	'type' => 'select',
	'options' => array(
		'none' => __('None', 'church-event'),
		'crop-top' => __('Crop from the Top', 'church-event'),
		'cover-top' => __('Resize and Crop', 'church-event'),
		'fit' => __('Fit', 'church-event'),
	),
	'only' => 'page',
	'class' => 'fbport fbport-page',
),

array(
	'name' => __('Ajax Slide Height', 'church-event'),
	'id' => 'fancy-portfolio-height',
	'type' => 'range',
	'min' => 200,
	'max' => 1000,
	'default' => 600,
	'only' => 'page',
	'class' => 'fbport fbport-page',
),

array(
	'name' => __('Ajax Portfolio - More Button Text', 'church-event') ,
	'id' => 'fancy-portfolio-more',
	'default' => __('Read more', 'church-event') ,
	'only' => 'page',
	'type' => 'text',
	'class' => 'hidden',

) ,

);
