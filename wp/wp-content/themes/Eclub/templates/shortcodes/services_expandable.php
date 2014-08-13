<?php
	$normal_style = $hover_style = '';

	$id = 'wpv-expandable-'.md5(uniqid());

	$readable = '
		.readable-color(@bgcolor:#FFF, @treshold:70, @diff:50%) when (iscolor(@bgcolor)) and ( lightness(@bgcolor) >= @treshold ) {
			color: darken(@bgcolor, @diff);
		}
		.readable-color(@bgcolor:#FFF, @treshold:70, @diff:50%) when (iscolor(@bgcolor)) and ( lightness(@bgcolor) < @treshold ) {
			color: lighten(@bgcolor, @diff);
		}
	';

	if(!empty($background) && $background !== 'transparent') {
		$l = new WpvLessc();
		$l->importDir = '.';
		$l->setFormatter("compressed");

		$background = wpv_sanitize_accent($background);

		$normal_style = $l->compile($readable . "
			#{$id} .closed {
				background: $background;

				&, p { .readable-color($background); }
			}
		");
	}

	if(!empty($hover_background) && $hover_background !== 'transparent') {
		$l = new WpvLessc();
		$l->importDir = '.';
		$l->setFormatter("compressed");

		$hover_background = wpv_sanitize_accent($hover_background);

		$hover_style = $l->compile($readable . "
			#{$id} .open {
				background: $hover_background;

				&, p { .readable-color($hover_background); }
			}
		");
	}
?>
<style scoped><?php echo $normal_style . $hover_style ?></style>
<div class="services has-more <?php echo $class?>" id="<?php echo $id ?>">
	<div class="closed services-inside">
		<div class="services-content-wrapper clearfix">
			<?php if (!empty($image)): ?>
				<div class="image-wrapper">
					<?php wpv_lazy_load($image, '', array('class'=> 'aligncenter')) ?>
				</div>
			<?php elseif(!empty($icon)): ?>
				<div class="image-wrapper"><?php
					echo wpv_shortcode_icon(array(
						'name' => $icon,
						'size' => $icon_size,
						'color' => wpv_sanitize_accent($icon_color),
					));
				?></div>
			<?php endif ?>

			<?php echo do_shortcode($before) ?>

		</div>
	</div>
	<div class="open services-inside">
		<div class="services-content-wrapper">
			<div class="row">
				<?php echo do_shortcode($content)?>
			</div>
		</div>
	</div>
</div>

