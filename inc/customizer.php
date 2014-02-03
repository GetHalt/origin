<?php
/**
 * Origin Theme Customizer
 *
 * @package Origin
 */

/**
 * Get Theme Mod
 *
 * Instead of options, customizations are stored/accessed via Theme Mods
 * (which are still technically settings). This wrapper provides a way to
 * check for an existing mod, or load a default in its place.
 *
 * @since Origin 1.0
 *
 * @param string $key The key of the theme mod to check. Prefixed with 'origin_'
 * @return mixed The theme modification setting
 */
function origin_theme_mod( $section, $key, $_default = false ) {
	$mods = origin_get_theme_mods();

	$default = $mods[ $section ][ $key ][ 'default' ];

	if ( $_default )
		$mod = $default;
	else
		$mod = get_theme_mod( $key, $default );

	return apply_filters( 'origin_theme_mod_' . $key, $mod );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function origin_customize_preview_js() {
	wp_enqueue_script( 'origin_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'origin_customize_preview_js' );

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

	$mods = array(
		'title_tagline' => array(
			'logo' => array(
				'title'   => __( 'Site Logo', 'origin' ),
				'type'    => 'WP_Customize_Image_Control',
				'default' => null
			)
		),
		'colors' => array(
			'accent' => array(
				'title'   => __( 'Accent Color', 'origin' ),
				'type'    => 'WP_Customize_Color_Control',
				'default' => '#2E3138'
			)
		),
		'static_front_page' => array(
			'search_header' => array(
				'title'   => __( 'Search Header Text', 'origin' ),
				'type'    => 'text',
				'default' => 'Help &amp; Support'
			),
			'search_subheader' => array(
				'title'   => __( 'Search Subheader Text', 'origin' ),
				'type'    => 'text',
				'default' => 'Need some help? Quickly search our knowledgebase articles.'
			),
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
 * Register settings.
 *
 * Take the final list of theme mods, and register all the settings, 
 * and add all of the proper controls.
 *
 * If the type is one of the default supported ones, add it normally. Otherwise
 * Use the type to create a new instance of that control type.
 *
 * @since Origin 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function origin_customize_register_settings( $wp_customize ) {
	$mods = origin_get_theme_mods();

	foreach ( $mods as $section => $settings ) {
		foreach ( $settings as $key => $setting ) {
			$wp_customize->add_setting( $key, array(
				'default' => origin_theme_mod( $section, $key, true )
			) );

			$type = $setting[ 'type' ];

			if ( in_array( $type, array( 'text', 'checkbox', 'radio', 'select', 'dropdown-pages' ) ) ) {
				$wp_customize->add_control( $key, array(
					'label'      => $setting[ 'title' ],
					'section'    => $section,
					'settings'   => $key,
					'type'       => $type,
					'choices'    => isset ( $setting[ 'choices' ] ) ? $setting[ 'choices' ] : null,
					'priority'   => isset ( $setting[ 'priority' ] ) ? $setting[ 'priority' ] : null
				) );
			} else {
				$wp_customize->add_control( new $type( $wp_customize, $key, array(
					'label'      => $setting[ 'title' ],
					'section'    => $section,
					'settings'   => $key,
					'priority'   => isset ( $setting[ 'priority' ] ) ? $setting[ 'priority' ] : null
				) ) );
			}
		}
	}

	do_action( 'origin_customize_regiser_settings', $wp_customize );

	return $wp_customize;
}
add_action( 'customize_register', 'origin_customize_register_settings' );

/**
 * Add postMessage support for all default fields, as well
 * as the site title and desceription for the Theme Customizer.
 *
 * @since Origin 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function origin_customize_register_transport( $wp_customize ) {
	$built_in = array( 'blogname' => '', 'blogdescription' => '', 'header_textcolor' => '' );
	$origin   = origin_get_theme_mods( array( 'keys_only' => true ) );
	
	$transport = array_merge( $built_in, $origin );

	foreach ( $transport as $key => $default ) {
		$wp_customize->get_setting( $key )->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'origin_customize_register_transport' );


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
