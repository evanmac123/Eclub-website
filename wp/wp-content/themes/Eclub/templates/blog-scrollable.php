<?php

/**
 * Scrollable blog
 *
 * @package wpv
 */

global $wpv_loop_vars, $wp_query;
$old_wpv_loop_vars = $wpv_loop_vars;
$wpv_loop_vars = array(
	'image' => $image,
	'show_content' => $show_content,
	'width' => $width,
	'news' => true,
	'column' => $column,
	'scrollable' => true,
	'layout' => 'scroll-x',
);

$column_width = 100;

$total_items = (have_posts() ? count($wp_query->posts) : 0);
$list_width = ( $total_items  / $column * 100);

if ($column > 1 && $list_width > 0)
	$column_width = 100/$column * 100/$list_width;

$li_style = ' style="width:' . $column_width  . '%"';


?>
<div class="scrollable-wrapper">
	<div class="loop-wrapper clearfix news scroll-x row">
		<ul class="clearfix" style="width: <?php echo $list_width ?>%" data-columns="<?php echo $column ?>">
			<?php
				$useColumns = $column > 1;
				$i = 0;
				global $wp_query;
				if(have_posts()) while(have_posts()): the_post();
					$last_in_row = (($i+1)%$column == 0 ||  $wp_query->post_count == $wp_query->current_post + 1);

					$post_class = array();
					$post_class[] = 'page-content post-head';
					$post_class[] = 'list-item';
				?>
					<li <?php post_class(implode(' ', $post_class)) ?> <?php echo $li_style ?>>
						<div>
							<?php get_template_part('templates/post');	?>
						</div>
					</li>
				<?php
					$i++;
				endwhile;
			?>
		</ul>
	</div>
</div>

<?php $wpv_loop_vars = $old_wpv_loop_vars; ?>
