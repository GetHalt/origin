<?php
/**
 * Front page template header.
 *
 * @package Origin
 */
?>
<section class="search-articles full-wrap">
	<div class="inside">
		<h1 class="search-header">
			<?php echo origin_theme_mod( 'static_front_page', 'search_header' ); ?>
		</h1>
		<p class="search-subheader">
			<?php echo origin_theme_mod( 'static_front_page', 'search_subheader' ); ?>
		</p>
		<?php get_template_part( 'searchform', 'front-page' ); ?>
	</div>
</section>
