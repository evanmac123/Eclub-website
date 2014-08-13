<nav id="main-menu">
	<?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
	<a href="#content" title="<?php esc_attr_e( 'Skip to content', 'church-event' ); ?>" class="visuallyhidden"><?php _e( 'Skip to content', 'church-event' ); ?></a>
	<?php
		if(has_nav_menu('menu-header'))
			wp_nav_menu(array(
				'theme_location' => 'menu-header',
				'walker' => new WpvMenuWalker(),
				'link_before' => '<span>',
				'link_after' => '</span>',
			));
	?>
</nav>