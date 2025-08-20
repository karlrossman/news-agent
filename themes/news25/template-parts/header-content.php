<?php
/**
 * Displays the header content
 *
 * @package News25
 */

?>
<header id="masthead" class="site-header">
	<div class="container">
		<div class="site-branding">
			<?php the_custom_logo(); ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="site-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'news25' ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->
	</div><!-- .container -->
</header><!-- #masthead -->
