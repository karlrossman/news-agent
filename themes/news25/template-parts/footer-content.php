<?php
/**
 * Displays the footer content
 *
 * @package News25
 */

?>
<footer id="colophon" class="site-footer">
	<div class="container">
		<div class="footer-widgets">
			<div class="footer-column">
				<?php if ( is_active_sidebar( 'footer-column-1' ) ) : ?>
					<?php dynamic_sidebar( 'footer-column-1' ); ?>
				<?php endif; ?>
			</div>
			<div class="footer-column">
				<?php if ( is_active_sidebar( 'footer-column-2' ) ) : ?>
					<?php dynamic_sidebar( 'footer-column-2' ); ?>
				<?php endif; ?>
			</div>
			<div class="footer-column">
				<?php if ( is_active_sidebar( 'footer-column-3' ) ) : ?>
					<?php dynamic_sidebar( 'footer-column-3' ); ?>
				<?php endif; ?>
			</div>
		</div><!-- .footer-widgets -->
	</div><!-- .container -->
</footer><!-- #colophon -->
