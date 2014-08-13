<?php
/**
 * Single page template
 *
 * @package wpv
 * @subpackage church-event
 */

if(!wpv_is_reduced_response()):
	get_header();
endif;

?>

<?php if ( have_posts() ) : the_post(); ?>

<?php if(!wpv_is_reduced_response()): ?>
	<div class="row page-wrapper">
<?php endif; // reduced response ?>
		<?php WpvTemplates::left_sidebar() ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(WpvTemplates::get_layout()); ?>>
			<?php
			global $wpv_has_header_sidebars;
			if( $wpv_has_header_sidebars) {
				WpvTemplates::header_sidebars();
			}
			?>
			<div class="page-content">
				<?php
					if(WpvFancyPortfolio::has('page')):
						$fancy_portfolio_resizing = get_post_meta($post->ID, 'fancy-portfolio-resizing', true);
						$data = WpvFancyPortfolio::get();
						?>
						<script>
							jQuery(function($) {
								var correct_height = <?php echo (int)get_post_meta($post->ID, 'fancy-portfolio-height', true) ?>,
									win_width = $(window).width();

								if(win_width < WPV_FRONT.content_width)
									correct_height *= win_width / WPV_FRONT.content_width;

								$.WPV.PortfolioSlider.init(<?php echo json_encode($data)?>, {
									resizing: '<?php echo $fancy_portfolio_resizing ?>',
									height: correct_height
								});
							});
						</script>
						<?php
							echo WPV_Portfolio::shortcode(array(
								'column' => 4,
								'cat' => WpvFancyPortfolio::get_categories(),
								'ids' => '',
								'max' => -1,
								'title' => 'overlay',
								'desc' => false,
								'more' => get_post_meta( $post->ID, 'fancy-portfolio-more', true ),
								'nopaging' => 'true',
								'group' => 'true',
								'layout' => 'fit-rows',
								'class' => 'ajax-portfolio-items',
								'fancy_page' => true,
							));
							wp_enqueue_script('vamtam-portfolioslider');
					endif ?>

				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'church-event' ), 'after' => '</div>' ) ); ?>
				<?php WpvTemplates::share('page') ?>
			</div>

			<?php comments_template( '', true ); ?>
		</article>

		<?php WpvTemplates::right_sidebar() ?>

<?php if(!wpv_is_reduced_response()): ?>
	</div>
<?php endif;
endif;

if(!wpv_is_reduced_response()) {
	get_footer();
} else {
	wpv_reduced_footer();
}