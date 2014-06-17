<?php
/**
 * Origin Theme Customizer
 *
 * @package Origin
 */

/**
 * Default theme customizations.
 *
 * @return $options an array of default theme options
 */
function origin_get_theme_mods( $args = array() ) {
	$defaults = array(
		'keys_only' => false
	);

	$args = wp_parse_args( $args, $defaults );

	// Priority for first section
	$priority = new Origin_Prioritizer( 0, 10 );

	$mods = array();

	$mods['title_tagline'] = array(
		'logo' => array(
			'title'    => __( 'Site Logo', 'origin' ),
			'type'     => 'WP_Customize_Image_Control',
			'default'  => null,
			'priority' => $priority->add()
		)
	);

	$priority->reboot();

	$mods['colors'] = array(
		'accent' => array(
			'title'    => __( 'Accent Color', 'origin' ),
			'type'     => 'WP_Customize_Color_Control',
			'default'  => '#2E3138',
			'priority' => $priority->add()
		)
	);

	$mods['static_front_page'] = array(
		'search_header' => array(
			'title'    => __( 'Search Header Text', 'origin' ),
			'type'     => 'text',
			'default'  => __( 'Help &amp; Support', 'origin' ),
		),
		'search_subheader' => array(
			'title'    => __( 'Search Subheader Text', 'origin' ),
			'type'     => 'text',
			'default'  => __( 'Need some help? Quickly search our knowledgebase articles.', 'origin' ),
		)
	);

	$mods = apply_filters( 'origin_theme_mods', $mods );

	/** Return all keys within all sections (for transport, etc) */
	if ( $args[ 'keys_only' ] ) {
		$keys = array();
		$final = array();

		foreach ( $mods as $section ) {
			$keys = array_merge( $keys, array_keys( $section ) );
		}

		foreach ( $keys as $key ) {
			$final[ $key ] = '';
		}

		return $final;
	}

	return $mods;
}

/**
 * Output the basic extra CSS for primary and accent colors.
 * Split away from widget colors for brevity.
 *
 * @since Origin 1.0
 */
function origin_header_css() {
	?>
	<style id="origin-custom-css" type="text/css">
		a,
		.article-category-title {
			color: <?php echo origin_theme_mod( 'colors', 'accent' ); ?>;
		}
		.site-header,
		.full-wrap,
		.site-footer {
			background-color: <?php echo origin_theme_mod( 'colors', 'accent' ); ?>;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'origin_header_css' );
