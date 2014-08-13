<?php if($query->have_posts()): ?>
	<div class="wpv-sermons-loop">
		<?php while($query->have_posts()): $query->the_post(); ?>
			<?php get_template_part('templates/sermons/item') ?>
		<?php endwhile ?>
	</div>
	<?php if ( $pagination ) WpvTemplates::pagination( 'paged', $query ); ?>
	<?php wp_reset_postdata(); ?>
<?php endif ?>