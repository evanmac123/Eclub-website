<?php

/**
 * Portfolio loop template
 *
 * @package wpv
 * @subpackage church-event
 */

global $wp_query;

$li_style = '';

$main_id = uniqid();

if($scrollable)
	echo '<div class="scrollable-wrapper">';
?>

<section class="portfolios row <?php if(!empty($sortable)) echo $engine ?> <?php echo $scrollable ? 'scroll-x' : 'normal' ?> title-<?php echo $title ?> <?php echo $desc ? 'has-description' : 'no-description' ?> <?php if(!empty($class)) echo $class; ?>" id="<?php echo $main_id ?>">
	<?php
		if(!empty($sortable)) include locate_template('templates/portfolio/loop/sortable-header.php');

		$ul_style = '';
		if ($scrollable) {
			$column_width = 100;

			$total_items = (have_posts() ? count($wp_query->posts) : 0);
			$list_width = ( $total_items  / $column * 100);

			$base_column_width = array(0, 0.98, 0.49, 0.32, 0.235);

			if($column > 1 && $list_width > 0)
				$column_width = 100/$column * 100/$list_width;

			$li_style = ' style="width:' . $column_width  . '%"';

			$ul_style = " style='width: {$list_width}%; width: calc({$list_width} + 30px)'";
		}
	?>
	<ul class="clearfix <?php echo $sortable ?>" data-columns="<?php echo $column ?>"<?php echo $ul_style?>>
		<?php
			while(have_posts()): the_post();
				include locate_template('templates/portfolio/loop/item.php');
			endwhile;
		?>
	</ul>
	<?php if ($nopaging == 'false')	WpvTemplates::pagination($paging_preference); ?>
</section>
<?php if($scrollable) echo '</div>' ?>
