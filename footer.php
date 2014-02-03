<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Origin
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="inside">
			<div class="site-info">
				<?php do_action( 'origin_credits' ); ?>
				<a href="http://halt.io/" rel="generator"><?php printf( __( 'Proudly powered by %s, a customer service platform.', 'origin' ), 'Halt' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( __( 'Theme: %1$s by %2$s.', 'origin' ), 'Origin', '<a href="http://mauryaratan.me" rel="designer">Ram Ratan Maurya</a>' ); ?>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
