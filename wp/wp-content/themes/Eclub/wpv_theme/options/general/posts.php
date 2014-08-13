<?php

/**
 * Theme options / General / Posts
 *
 * @package wpv
 * @subpackage church-event
 */

return array(

array(
	'name' => __('Posts', 'church-event'),
	'type' => 'start',
),

array(
	'name' => __('Blog and Portfolio Listing Pages and Archives', 'church-event'),
	'type' => 'separator',
),

array(
	'name' => __('Pagination Type', 'church-event'),
	'desc' => __('Please note that you will need WP-PageNavi plugin installed if you chose "paged" style.', 'church-event'),
	'id' => 'pagination-type',
	'type' => 'select',
	'options' => array(
		'paged' => __('Paged', 'church-event'),
		'load-more' => __('Load more button', 'church-event'),
		'infinite-scrolling' => __('Infinite scrolling', 'church-event'),
	),
	'class' => 'slim',
),


array(
	'name' => __('Blog Posts', 'church-event'),
	'type' => 'separator',
),

array(
	'name' => __('"View All Posts" Link', 'church-event'),
	'desc' => __('In a single blog post view in the top you will find navigation with 3 buttons. The middle gets you to the blog listing view.<br>
You can place the link here.', 'church-event'),
	'id' => 'post-all-items',
	'type' => 'text',
	'static' => true,
	'class' => 'slim',
),

array(
	'name' => __('Show "Related Posts" in Single Post View', 'church-event'),
	'desc' => __('Enabling this option will show more posts from the same category when viewing a single post.', 'church-event'),
	'id' => 'show-related-posts',
	'type' => 'toggle',
	'class' => 'slim',
),

array(
	'name' => __('"Related Posts" title', 'church-event'),
	'id' => 'related-posts-title',
	'type' => 'text',
	'class' => 'slim',
),

array(
	'name' => __('Show Post Author', 'church-event'),
	'desc' => __('Blog post meta info, works for the single blog post view.', 'church-event'),
	'id' => 'show-post-author',
	'type' => 'toggle',
	'class' => 'slim'
),
array(
	'name' => __('Show Categories and Tags', 'church-event'),
	'desc' => __('Blog post meta info, works for the single blog post view.', 'church-event'),
	'id' => 'meta_posted_in',
	'type' => 'toggle',
	'class' => 'slim',
),
array(
	'name' => __('Show Post Timestamp', 'church-event'),
	'desc' => __('Blog post meta info, works for the single blog post view.', 'church-event'),
	'id' => 'meta_posted_on',
	'type' => 'toggle',
	'class' => 'slim',
),
array(
	'name' => __('Show Comment Count', 'church-event'),
	'desc' => __('Blog post meta info, works for the single blog post view.', 'church-event'),
	'id' => 'meta_comment_count',
	'type' => 'toggle',
	'class' => 'slim',
),

array(
	'name' => __('Portfolio Posts', 'church-event'),
	'type' => 'separator',
),

array(
	'name' => __('"View All Portfolios" Link', 'church-event'),
	'desc' => __('In a single portfolio post view in the top you will find navigation with 3 buttons. The middle gets you to the portfolio listing view.<br>
You can place the link here.', 'church-event'),
	'id' => 'portfolio-all-items',
	'type' => 'text',
	'static' => true,
	'class' => 'slim',
),
array(
	'name' => __('Show "Related Portfolios" in Single Portfolio View', 'church-event'),
	'desc' => __('Enabling this option will show more portfolio posts from the same category in the single portfolio post.', 'church-event'),
	'id' => 'show-related-portfolios',
	'type' => 'toggle',
	'class' => 'slim',
),

array(
	'name' => __('"Related Portfolios" title', 'church-event'),
	'id' => 'related-portfolios-title',
	'type' => 'text',
	'class' => 'slim',
),

array(
	'name' => __('URL Prefix for Single Portfolios', 'church-event'),
	'desc' => __('Use an unique string without spaces. It must not be the same as any other URL slugs (used on pages, etc.).', 'church-event'),
	'id' => 'portfolio-slug',
	'type' => 'text',
	'class' => 'slim',
),

	array(
		'type' => 'end'
	),
);