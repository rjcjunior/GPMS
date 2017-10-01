<?php
/**
 * Customizer functionality for the Pricing section.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

/**
 * Hook controls for Pricing section to Customizer.
 *
 * @since Hestia 1.0
 * @modified 1.1.30
 */
function hestia_pricing_customize_register( $wp_customize ) {

	$selective_refresh = isset( $wp_customize->selective_refresh ) ? true : false;
	$wp_customize->add_section(
		'hestia_pricing', array(
			'title' => esc_html__( 'Pricing', 'hestia-pro' ),
			'panel' => 'hestia_frontpage_sections',
			'priority' => apply_filters( 'hestia_section_priority', 35, 'hestia_pricing' ),
		)
	);

	$wp_customize->add_setting(
		'hestia_pricing_hide', array(
			'sanitize_callback' => 'hestia_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'hestia_pricing_hide', array(
			'type' => 'checkbox',
			'label' => esc_html__( 'Disable section','hestia-pro' ),
			'section' => 'hestia_pricing',
			'priority' => 1,
		)
	);

	$wp_customize->add_setting(
		'hestia_pricing_title', array(
			'default' => esc_html__( 'Choose a plan for your next project', 'hestia-pro' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'hestia_pricing_title', array(
			'label' => esc_html__( 'Section Title', 'hestia-pro' ),
			'section' => 'hestia_pricing',
			'priority' => 5,
		)
	);

	$wp_customize->add_setting(
		'hestia_pricing_subtitle', array(
			'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'hestia-pro' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'hestia_pricing_subtitle', array(
			'label' => esc_html__( 'Section Subtitle', 'hestia-pro' ),
			'section' => 'hestia_pricing',
			'priority' => 10,
		)
	);

	$wp_customize->add_setting(
		'hestia_pricing_table_one_title', array(
			'default' => esc_html__( 'Basic Package', 'hestia-pro' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'hestia_pricing_table_one_title', array(
			'label' => esc_html__( 'Pricing Table One: Title', 'hestia-pro' ),
			'section' => 'hestia_pricing',
			'priority' => 15,
		)
	);

	$wp_customize->add_setting(
		'hestia_pricing_table_one_price', array(
			'default' => '<small>$</small>49',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'hestia_pricing_table_one_price', array(
			'label' => esc_html__( 'Pricing Table One: Price', 'hestia-pro' ),
			'section' => 'hestia_pricing',
			'priority' => 20,
		)
	);

	$default = sprintf( '<b>%1$s</b> %2$s',esc_html__( '1','hestia-pro' ),esc_html__( 'Domain', 'hestia-pro' ) ) .
			   sprintf( '\n<b>%1$s</b> %2$s',esc_html__( '1GB','hestia-pro' ),esc_html__( 'Storage', 'hestia-pro' ) ) .
			   sprintf( '\n<b>%1$s</b> %2$s',esc_html__( '100GB','hestia-pro' ),esc_html__( 'Bandwidth', 'hestia-pro' ) ) .
			   sprintf( '\n<b>%1$s</b> %2$s',esc_html__( '2','hestia-pro' ),esc_html__( 'Databases', 'hestia-pro' ) );
	$wp_customize->add_setting(
		'hestia_pricing_table_one_features', array(
			'default' => $default,
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'hestia_pricing_table_one_features', array(
			'label' => esc_html__( 'Pricing Table One: Features', 'hestia-pro' ),
			'description' => esc_html__( 'Seperate your features by adding \n between lines.', 'hestia-pro' ),
			'section' => 'hestia_pricing',
			'priority' => 25,
			'type' => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hestia_pricing_table_one_link', array(
			'default' => esc_url( '#' ),
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'hestia_pricing_table_one_link', array(
			'label' => esc_html__( 'Pricing Table One: Link', 'hestia-pro' ),
			'section' => 'hestia_pricing',
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'hestia_pricing_table_one_text', array(
			'default' => esc_html__( 'Free Download', 'hestia-pro' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'hestia_pricing_table_one_text', array(
			'label' => esc_html__( 'Pricing Table One: Text', 'hestia-pro' ),
			'section' => 'hestia_pricing',
			'priority' => 35,
		)
	);

	$wp_customize->add_setting(
		'hestia_pricing_table_two_title', array(
			'default' => esc_html__( 'Premium Package', 'hestia-pro' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'hestia_pricing_table_two_title', array(
			'label' => esc_html__( 'Pricing Table Two: Title', 'hestia-pro' ),
			'section' => 'hestia_pricing',
			'priority' => 40,
		)
	);

	$wp_customize->add_setting(
		'hestia_pricing_table_two_price', array(
			'default' => '<small>$</small>49',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'hestia_pricing_table_two_price', array(
			'label' => esc_html__( 'Pricing Table Two: Price', 'hestia-pro' ),
			'section' => 'hestia_pricing',
			'priority' => 45,
		)
	);

	$default = sprintf( '<b>%1$s</b> %2$s',esc_html__( '5','hestia-pro' ),esc_html__( 'Domain', 'hestia-pro' ) ) .
			   sprintf( '\n<b>%1$s</b> %2$s',esc_html__( 'Unlimited','hestia-pro' ),esc_html__( 'Storage', 'hestia-pro' ) ) .
			   sprintf( '\n<b>%1$s</b> %2$s',esc_html__( 'Unlimited','hestia-pro' ),esc_html__( 'Bandwidth', 'hestia-pro' ) ) .
			   sprintf( '\n<b>%1$s</b> %2$s',esc_html__( 'Unlimited','hestia-pro' ),esc_html__( 'Databases', 'hestia-pro' ) );
	$wp_customize->add_setting(
		'hestia_pricing_table_two_features', array(
			'default' => $default,
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'hestia_pricing_table_two_features', array(
			'label' => esc_html__( 'Pricing Table Two: Features', 'hestia-pro' ),
			'description' => esc_html__( 'Seperate your features by adding \n between lines.', 'hestia-pro' ),
			'section' => 'hestia_pricing',
			'priority' => 50,
			'type' => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hestia_pricing_table_two_link', array(
			'default' => esc_url( '#' ),
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'hestia_pricing_table_two_link', array(
			'label' => esc_html__( 'Pricing Table Two: Link', 'hestia-pro' ),
			'section' => 'hestia_pricing',
			'priority' => 55,
		)
	);

	$wp_customize->add_setting(
		'hestia_pricing_table_two_text', array(
			'default' => esc_html__( 'Order Now', 'hestia-pro' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'hestia_pricing_table_two_text', array(
			'label' => esc_html__( 'Pricing Table Two: Text', 'hestia-pro' ),
			'section' => 'hestia_pricing',
			'priority' => 60,
		)
	);

}

add_action( 'customize_register', 'hestia_pricing_customize_register' );

/**
 * Add selective refresh for pricing section controls.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @since 1.1.31
 * @access public
 */
function hestia_register_pricing_partials( $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	// Section title and subtitle
	$wp_customize->selective_refresh->add_partial(
		'hestia_pricing_title', array(
			'selector' => '#pricing h2.title',
			'settings' => 'hestia_pricing_title',
			'render_callback' => 'hestia_pricing_title_callback',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'hestia_pricing_subtitle', array(
			'selector' => '#pricing .text-gray',
			'settings' => 'hestia_pricing_subtitle',
			'render_callback' => 'hestia_pricing_subtitle_callback',
		)
	);

	// Table one controls
	$wp_customize->selective_refresh->add_partial(
		'hestia_pricing_table_one_title', array(
			'selector' => '.pricing .col-md-6.hestia-table-one h6.category',
			'settings' => 'hestia_pricing_table_one_title',
			'render_callback' => 'hestia_table_one_title_callback',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'hestia_pricing_table_one_price', array(
			'selector' => '.pricing .col-md-6.hestia-table-one .card-pricing .card-title',
			'settings' => 'hestia_pricing_table_one_price',
			'render_callback' => 'hestia_table_one_price_callback',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'hestia_pricing_table_one_features', array(
			'selector' => '.pricing .col-md-6.hestia-table-one .card-pricing ul',
			'settings' => 'hestia_pricing_table_one_features',
			'render_callback' => 'hestia_table_one_features_callback',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'hestia_pricing_table_one_text', array(
			'selector' => '.pricing .col-md-6.hestia-table-one .btn',
			'settings' => 'hestia_pricing_table_one_text',
			'render_callback' => 'hestia_table_one_button_callback',
		)
	);

	// Table two controls
	$wp_customize->selective_refresh->add_partial(
		'hestia_pricing_table_two_title', array(
			'selector' => '.pricing .col-md-6.hestia-table-two h6.category',
			'settings' => 'hestia_pricing_table_two_title',
			'render_callback' => 'hestia_table_two_title_callback',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'hestia_pricing_table_two_price', array(
			'selector' => '.pricing .col-md-6.hestia-table-two .card-pricing .card-title',
			'settings' => 'hestia_pricing_table_two_price',
			'render_callback' => 'hestia_table_two_price_callback',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'hestia_pricing_table_two_features', array(
			'selector' => '.pricing .col-md-6.hestia-table-two .card-pricing ul',
			'settings' => 'hestia_pricing_table_two_features',
			'render_callback' => 'hestia_table_two_features_callback',
		)
	);
	$wp_customize->selective_refresh->add_partial(
		'hestia_pricing_table_two_text', array(
			'selector' => '.pricing .col-md-6.hestia-table-two .btn',
			'settings' => 'hestia_pricing_table_two_text',
			'render_callback' => 'hestia_table_two_button_callback',
		)
	);
}
add_action( 'customize_register', 'hestia_register_pricing_partials' );


/**
 * Callback function for pricing section title selective refresh.
 *
 * @since 1.1.31
 * @access public
 * @return string
 */
function hestia_pricing_title_callback() {
	return get_theme_mod( 'hestia_pricing_title' );
}

/**
 * Callback function for pricing section subtitle selective refresh.
 *
 * @since 1.1.31
 * @access public
 * @return string
 */
function hestia_pricing_subtitle_callback() {
	return get_theme_mod( 'hestia_pricing_subtitle' );
}

/**
 * Callback function for pricing table one title selective refresh.
 *
 * @since 1.1.31
 * @access public
 * @return string
 */
function hestia_table_one_title_callback() {
	return get_theme_mod( 'hestia_pricing_table_one_title' );
}

/**
 * Callback function for pricing table one price selective refresh.
 *
 * @since 1.1.31
 * @access public
 * @return string
 */
function hestia_table_one_price_callback() {
	return get_theme_mod( 'hestia_pricing_table_one_price' );
}

/**
 * Render callback for pricing section table one features selective refresh
 *
 * @since 1.1.31
 * @access public
 */
function hestia_table_one_features_callback() {
	$hestia_pricing_table_one_features = get_theme_mod( 'hestia_pricing_table_one_features' );
	if ( ! is_array( $hestia_pricing_table_one_features ) ) {
		$hestia_pricing_table_one_features = explode( '\n', str_replace( '\r', '', wp_kses_post( force_balance_tags( $hestia_pricing_table_one_features ) ) ) );
	}
	foreach ( $hestia_pricing_table_one_features as $feature ) : ?>
		<li><?php echo wp_kses_post( $feature ); ?></li>
		<?php
	endforeach;
}

/**
 * Callback function for pricing table one button label selective refresh.
 *
 * @since 1.1.31
 * @access public
 * @return string
 */
function hestia_table_one_button_callback() {
	return get_theme_mod( 'hestia_pricing_table_one_text' );
}

/**
 * Callback function for pricing table two title selective refresh.
 *
 * @since 1.1.31
 * @access public
 * @return string
 */
function hestia_table_two_title_callback() {
	return get_theme_mod( 'hestia_pricing_table_two_title' );
}

/**
 * Callback function for pricing table two price selective refresh.
 *
 * @since 1.1.31
 * @access public
 * @return string
 */
function hestia_table_two_price_callback() {
	return get_theme_mod( 'hestia_pricing_table_two_price' );
}


/**
 * Render callback for pricing section table two features selective refresh
 *
 * @since 1.1.31
 * @access public
 */
function hestia_table_two_features_callback() {
	$hestia_pricing_table_two_features = get_theme_mod( 'hestia_pricing_table_two_features' );
	if ( ! is_array( $hestia_pricing_table_two_features ) ) {
		$hestia_pricing_table_two_features = explode( '\n', str_replace( '\r', '', wp_kses_post( force_balance_tags( $hestia_pricing_table_two_features ) ) ) );
	}
	foreach ( $hestia_pricing_table_two_features as $feature ) :
	?>
		<li><?php echo wp_kses_post( $feature ); ?></li>
		<?php
	endforeach;
}

/**
 * Callback function for pricing table two button label selective refresh.
 *
 * @since 1.1.31
 * @access public
 * @return string
 */
function hestia_table_two_button_callback() {
	return get_theme_mod( 'hestia_pricing_table_two_text' );
}
