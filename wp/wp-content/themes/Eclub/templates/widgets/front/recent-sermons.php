<?php if ($r->have_posts()) : ?>

	<?php echo $before_widget; ?>
	<?php if ( $title ) echo $before_title . $title . $after_title; ?>
	<ul>
	<?php while ( $r->have_posts() ) : $r->the_post(); ?>
		<li>
			<a href="<?php the_permalink(); ?>" class="sermon-title"><?php get_the_title() ? the_title() : the_ID(); ?></a>
			<?php if ( $show_date ) : ?>
				<div class="post-date"><?php echo get_the_date(); ?></div>
			<?php endif; ?>
			<?php WpvTemplates::show_sermon_media();?>
		</li>
	<?php endwhile; ?>
	</ul>
	<?php echo $after_widget; ?>

<?php
	// Reset the global $the_post as this query will have stomped on it
	wp_reset_postdata();

	endif;