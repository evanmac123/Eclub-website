<a href="#" id="mp-menu-trigger" class="icon-b" data-icon="<?php wpv_icon('menu1') ?>"><?php _e('Open/Close Menu', 'church-event') ?></a>
<div class="logo-wrapper">
	<?php
		$logo = wpv_get_option('custom-header-logo');
		$logo_trans = wpv_get_option('custom-header-logo-transparent');

		$upload_dir = wp_upload_dir();
		$logo_editor = wp_get_image_editor(wpv_get_attachment_file($logo));
		$logo_size = is_wp_error($logo_editor) ? array('height'=>0, 'width'=>0) : $logo_editor->get_size();

		$padding = $max_height = 0;
		$logo_style = '';
		if ( ! empty( $logo_size['height'] ) ) {
			if ( wpv_get_option( 'header-layout' ) == 'logo-menu' ) {
				$padding = (wpv_get_option('header-height') - $logo_size['height']/2)/2;
				$max_height = $logo_size['height'] / 2;

				$logo_style = "padding: {$padding}px 0; max-height: {$max_height}px;";
			} else {
				$max_height = $logo_size['height'] / 2;
				$logo_style = "max-height: {$max_height}px;";
			}
		}
	?>
	<a href="<?php echo home_url() ?>/" title="<?php bloginfo( 'name' ) ?>" class="logo <?php if(empty($logo)) echo 'text-logo' ?>" style="min-width:<?php echo $logo_size['width']/2 ?>px"><?php
		if($logo):
		?>
			<img src="<?php echo $logo;?>" alt="<?php bloginfo('name')?>" class="normal-logo" height="<?php if(!empty($logo_size['height'])) echo $logo_size['height']/2 ?>" style="<?php echo esc_attr($logo_style) ?>"/>
			<?php if(!empty($logo_trans) && wpv_get_option('header-layout') == 'logo-menu'): ?>
				<img src="<?php echo $logo_trans;?>" alt="<?php bloginfo('name')?>" class="alternative-logo" height="<?php if(!empty($logo_size['height'])) echo $logo_size['height'] ?>" style="<?php echo esc_attr($logo_style) ?>"/>
			<?php endif ?>
		<?php
		else:
			bloginfo( 'name' );
		endif;
		?>
	</a>
	<?php
		$description = get_bloginfo('description');
		if(!empty($description)):
	?>
			<span class="logo-tagline"><?php echo $description ?></span>
	<?php endif ?>
</div>