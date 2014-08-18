<?php
/**
 * Single page template
 * Template Name: Home
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
<!--Import slider to the home page-->			



<!--Start of content under slider-->
			<div class="page-content">

	
<div class="wpv-grid grid-1-2  wpv-first-level first unextended">
	<h1>We are Entreprenuers.</h1>
	<h4 class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tristique est tortor, quis iaculis nibh commodo a. Duis condimentum libero quis molestie elementum. Cras dui quam, venenatis tristique libero sit amet, convallis aliquet turpis. Donec a facilisis arcu. Nullam fringilla libero pellentesque venenatis malesuada.
	Link to About
	</h4>
    <a href="aboutpage" target="_self" class="ls-l c2abutton"> 
   		 <p class="button ls-preloaded" style="white-space: nowrap; width: auto; height: auto; font-size: 20px; line-height: 28px; padding: 10px 20px; border-width: 0px;">
    		Learn more
    	</p>
	</a>
	<button>
</div>



<?php// echo tribe_community_events_form_title();  ?>

				<?php
					if(WpvFancyPortfolio::has('page')):
						$fancy_portfolio_resizing = get_post_meta($post->ID, 'fancy-portfolio-resizing', true);
						$data = WpvFancyPortfolio::get();
						?>
						
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
//This is all the content on the page coming VAMTAM
				<?php the_content(); ?><div> after this</div>



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