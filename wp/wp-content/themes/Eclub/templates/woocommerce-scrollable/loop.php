<?php

/**
 * Scrollable blog
 *
 * @package wpv
 */

$column_width = 100;

$total_items = (have_posts() ? count($wp_query->posts) : 0);
$list_width = ( $total_items  / $columns * 100);

if ($columns > 1 && $list_width > 0)
	$column_width = 100/$columns * 100/$list_width;

$li_style = ' style="width:' . $column_width  . '%"';

?>
<div class="scrollable-wrapper">
	<div class="woocommerce woocommerce-scrollable scroll-x row">
		<ul class="clearfix products" style="width: <?php echo $list_width ?>%" data-columns="<?php echo $columns ?>">
			<?php
				$useColumns = $columns > 1;
				$i = 0;
				if($products->have_posts()) while($products->have_posts()): $products->the_post();
					$last_in_row = (($i+1)%$columns == 0 || $products->post_count == $products->current_post + 1);
				?>
					<li class="product" <?php echo $li_style ?>>
						<div>
							<?php get_template_part('templates/woocommerce-scrollable/item');	?>
						</div>
					</li>
				<?php
					$i++;
				endwhile;
			?>
		</ul>
	</div>
</div>