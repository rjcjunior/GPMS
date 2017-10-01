<?php
/**
 * Customizer functionality for the Slider section.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

// Load Customizer repeater control.
$repeater_path = HESTIA_PHP_INCLUDE . 'customizer-repeater/functions.php';
if ( file_exists( $repeater_path ) ) {
	require_once( $repeater_path );
}

/**
 * Hook controls for Slider section to Customizer.
 *
 * @since Hestia 1.0
 * @modified 1.1.30
 */
function hestia_slider_customize_register( $wp_customize ) {

	$selective_refresh = isset( $wp_customize->selective_refresh ) ? true : false;
	$wp_customize->add_section(
		'hestia_slider', array(
			'title'    => esc_html__( 'Slider', 'hestia-pro' ),
			'panel'    => 'hestia_frontpage_sections',
			'priority' => 5,
		)
	);

	if ( class_exists( 'Hestia_Repeater' ) ) {
		$slider_default = hestia_get_slider_default();

		$wp_customize->add_setting(
			'hestia_slider_content', array(
				'sanitize_callback' => 'hestia_repeater_sanitize',
				'default'           => json_encode( $slider_default ),
				'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
			)
		);

		$wp_customize->add_control(
			new Hestia_Repeater(
				$wp_customize, 'hestia_slider_content', array(
					'label'                                => esc_html__( 'Slider Content', 'hestia-pro' ),
					'section'                              => 'hestia_slider',
					'priority'                             => 1,
					'item_name'                            => esc_html__( 'Slide', 'hestia-pro' ),
					'add_field_label'                      => esc_html__( 'Add new Slide', 'hestia-pro' ),
					'customizer_repeater_image_control'    => true,
					'customizer_repeater_title_control'    => true,
					'customizer_repeater_subtitle_control' => true,
					'customizer_repeater_text_control'     => true,
					'customizer_repeater_link_control'     => true,
				)
			)
		);
	}
}

add_action( 'customize_register', 'hestia_slider_customize_register' );


add_action( 'after_setup_theme', 'hestia_get_slider_default', 11 );


/**
 * Add selective refresh for slider section controls.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @since 1.1.31
 * @access public
 */
function hestia_register_slider_partials( $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial(
		'hestia_slider_content', array(
			'selector' => '#carousel-hestia-generic',
			'settings' => 'hestia_slider_content',
			'render_callback' => 'hestia_slider_callback',
		)
	);
}
add_action( 'customize_register', 'hestia_register_slider_partials' );

/**
 * Callback function for slider content selective refresh.
 *
 * @since 1.1.31
 * @access public
 */
function hestia_slider_callback() {
	hestia_slider( true );
}
