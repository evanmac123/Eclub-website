<?php
/**
 * Archive page template
 *
 * @package wpv
 * @subpackage church-event
 */

global $wp_query;

$title = __('Blog Archives', 'church-event');

if( is_day() ) {
	$title = sprintf( __( 'Daily Archives: <span>%s</span>', 'church-event' ), get_the_date() );
} elseif( is_month() ) {
	$title = sprintf( __( 'Monthly Archives: <span>%s</span>', 'church-event' ), get_the_date('F Y') );
} elseif( is_year() ) {
	$title = sprintf( __( 'Yearly Archives: <span>%s</span>', 'church-event' ), get_the_date('Y') );
} elseif( is_category() ) {
	$title = sprintf( __( 'Category: %s', 'church-event' ), '<span>' . single_cat_title( '', false ) . '</span>' );
} elseif( is_tag() ) {
	$title = sprintf( __( 'Tag Archives: %s', 'church-event' ), '<span>' . single_tag_title( '', false ) . '</span>' );
} elseif( is_tax( 'wpv_sermons_category' ) ) {
	$title = sprintf( __( 'Sermons Category: %s', 'church-event' ), '<span>' . single_cat_title( '', false ) . '</span>' );
}

get_header(); ?>

<?php if ( have_posts() ): the_post(); ?>
	<div class="row page-wrapper">
		<?php WpvTemplates::left_sidebar() ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(WpvTemplates::get_layout()); ?>>
			<?php
			global $wpv_has_header_sidebars;
			if( $wpv_has_header_sidebars) {
				WpvTemplates::header_sidebars();
			}
			?>
			<div class="page-content">
				<?php rewind_posts() ?>
				<?php get_template_part('loop', 'archive') ?>
			</div>
		</article>

		<?php WpvTemplates::right_sidebar() ?>
	</div>
<?php endif ?>

<?php get_footer(); ?>
