<?php
/**
 * @package Origin
 */

if ( ! function_exists( 'origin_customizer_init' ) ) :
/**
 * Load the customize files and enqueue scripts.
 *
 * @return void
 */
function origin_customizer_init() {
	$path = get_template_directory() . '/inc/customizer/';

	// Always load
	require_once( $path . 'controls.php' );
	require_once( $path . 'customizer.php' );
}
endif;
add_action( 'after_setup_theme', 'origin_customizer_init' );
