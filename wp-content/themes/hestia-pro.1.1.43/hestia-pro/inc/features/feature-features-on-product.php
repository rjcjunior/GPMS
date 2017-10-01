<?php
/**
 * Customizer functionality for Features on Single Product.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

/**
 * Hook controls for Features on Single Product to Customizer.
 *
 * @since Hestia 1.0
 */
function hestia_features_on_product_customize_register( $wp_customize ) {
	$wp_customize->add_setting(
		'hestia_features_show_on_single_product', array(
			'sanitize_callback' => 'hestia_sanitize_checkbox',
			'active_callback'   => 'hestia_woocommerce_check',
			'default'           => false,
		)
	);

	$wp_customize->add_control(
		'hestia_features_show_on_single_product', array(
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Show Features section on single product page?', 'hestia-pro' ),
			'section'  => 'hestia_features',
			'priority' => 100,
		)
	);
}

add_action( 'customize_register', 'hestia_features_on_product_customize_register' );

add_action( 'woocommerce_after_single_product', 'hestia_features', 10 ); /* Add services section on single product. */
