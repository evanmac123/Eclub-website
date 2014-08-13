<?php
/**
 * Portfolio shortcode options
 *
 * @package wpv
 * @subpackage editor
 */


return array(
	'name' => __('Portfolio', 'church-event') ,
	'desc' => __('Please note that this element shows already created portfolio posts. To create one go to the Portfolios tab in the WordPress main navigation menu on the left - Add New. ' , 'church-event'),
	'icon' => array(
		'char' => WPV_Editor::get_icon('grid2'),
		'size' => '30px',
		'lheight' => '45px',
		'family' => 'vamtam-editor-icomoon',
	),
	'value' => 'portfolio',
	'controls' => 'size name clone edit delete',
	'options' => array(

		array(
			'name' => __('Layout', 'church-event') ,
			'id' => 'layout',
			'desc' => __('Static - no filtering.<br/>
				Filtering - Enable filtering for the portfolio items depending on their category.<br/>
				Srollable - shows the portfolio items in a slider', 'church-event') ,
			'default' => '',
			'type' => 'select',
			'options' => array(
				'static' => __('Static', 'church-event'),
				'fit-rows' => __('Filtering - Fit Rows', 'church-event'),
				'masonry' => __('Filtering - Masonry', 'church-event'),
				'scrollable' => __('Scrollable', 'church-event'),
			),
			'field_filter' => 'fbs',
		) ,
		array(
			'name' => __('No Paging', 'church-event') ,
			'id' => 'nopaging',
			'desc' => __('If the option is on, it will disable pagination. You can set the type of pagination in General Settings - Posts - Pagination Type. ', 'church-event') ,
			'default' => false,
			'type' => 'toggle',
			'class' => 'fbs fbs-static fbs-fit-rows fbs-masonry',
		) ,
		array(
			'name' => __('Columns', 'church-event') ,
			'id' => 'column',
			'default' => 4,
			'type' => 'range',
			'min' => 1,
			'max' => 4,
		) ,
		array(
			'name' => __('Limit', 'church-event') ,
			'desc' => __('Number of item to show per page. If you set it to -1, it will display all portfolio items.', 'church-event') ,
			'id' => 'max',
			'default' => '4',
			'min' => -1,
			'max' => 100,
			'step' => '1',
			'type' => 'range'
		) ,

		array(
			'name' => __('Display Title', 'church-event') ,
			'id' => 'title',
			'desc' => __('If the option is on, it will display the title of the portfolio post.<br/><br/>', 'church-event') ,
			'default' => 'false',
			'type' => 'select',
			'options' => array(
				'false' => __('No Title', 'church-event'),
				// 'overlay' => __('Overlay', 'church-event'),
				'below' => __('Below Media', 'church-event'),
			),
		) ,
		array(
			'name' => __('Display Description', 'church-event') ,
			'id' => 'desc',
			'desc' => __('If the option is on, it will display short description of the portfolio item.', 'church-event') ,
			'default' => false,
			'type' => 'toggle'
		) ,
		array(
			'name' => __('Button Text', 'church-event') ,
			'id' => 'more',
			'default' => __('Read more', 'church-event') ,
			'type' => 'text',
		) ,
		array(
			'name' => __('Group', 'church-event') ,
			'id' => 'group',
			'desc' => __('If the option is on, the lightbox will display left and right arrows and  you can see all the portfolio posts from the same category.', 'church-event') ,
			'default' => true,
			'type' => 'toggle',
			'class' => 'fbs fbs-static fbs-fit-rows fbs-masonry',
		) ,
		array(
			'name' => __('Categories (optional)', 'church-event') ,
			'desc' => __('All categories will be shown if none are selected. Please note that if you do not see categories, there are none created most probably. You can use ctr + click to select multiple categories.', 'church-event') ,
			'id' => 'cat',
			'default' => array() ,
			'target' => 'portfolio_category',
			'type' => 'multiselect',
		) ,
		array(
			'name' => __('Portfolio Posts (optional)', 'church-event') ,
			'desc' => __('All portfolio posts will be shown if none are selected. If you select any posts here, this option will override the category option above. You can use ctr + click to select multiple posts.', 'church-event') ,
			'id' => 'ids',
			'default' => array() ,
			'target' => 'portfolio',
			'type' => 'multiselect',
		) ,

		array(
			'name' => __('Title (optional)', 'church-event') ,
			'desc' => __('The title is placed just above the element.<br/><br/>', 'church-event'),
			'id' => 'column_title',
			'default' => '',
			'type' => 'text'
		) ,
		array(
			'name' => __('Title Type (optional)', 'church-event') ,
			'id' => 'column_title_type',
			'default' => 'single',
			'type' => 'select',
			'options' => array(
				'single' => __('Title with divider next to it ', 'church-event'),
				'double' => __('Title with divider below', 'church-event'),
				'no-divider' => __('No Divider', 'church-event'),
			),
		) ,
	) ,
);
