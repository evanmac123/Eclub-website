<?php
/**
 * The template for displaying all single posts.
 *
 * @package Scout-Base
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<div style="background-color: blue;">

			<div class="container">
				<div class="row">


					<div class="col-md-2"> <!--This is where the picture of the Venture would go -->
						<img src="http://placehold.it/100x100" class="thumbnail img-responsive">
					</div>

					<div class="col-md-6">

						<h1><?php the_title(); ?></h1>
						<div class="content"><?php the_content(); ?></div>

						 <?php// get_template_part( 'content', 'single' ); ?>

				</div>

			</div>
		</div>
	</div>
</main><!-- #main -->
</div><!-- #primary -->

<?php scout_base_post_nav(); ?>
<?php endwhile; // end of the loop. ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>