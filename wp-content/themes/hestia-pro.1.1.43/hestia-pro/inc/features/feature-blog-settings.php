<?php
/**
 * Customizer functionality for the Blog settings panel.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

/**
 * Hook controls for Blog Settings section to Customizer.
 *
 * @since Hestia 1.0
 */
function hestia_blog_settings_customize_register( $wp_customize ) {

	// Alternative Blog Layout.
	$wp_customize->add_setting(
		'hestia_alternative_blog_layout', array(
			'default' => false,
			'sanitize_callback' => 'hestia_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'hestia_alternative_blog_layout',array(
			'label' => esc_html__( 'Enable Alternative Blog Layout?','hestia-pro' ),
			'description' => esc_html__( 'If enabled, the blog page will use the alternative layout.', 'hestia-pro' ),
			'section' => 'hestia_general',
			'priority' => 3,
			'type' => 'checkbox',
		)
	);

	// Add authors on blog page panel.
	$wp_customize->add_section(
		'hestia_blog_authors', array(
			'title' => esc_html__( 'Authors Section', 'hestia-pro' ),
			'panel' => 'hestia_blog_settings',
			'priority' => 20,
		)
	);

	if ( class_exists( 'Hestia_Select_Multiple' ) ) {

		$wp_customize->add_setting(
			'hestia_authors_on_blog', array(
				'sanitize_callback' => 'hestia_sanitize_array',
			)
		);

		$wp_customize->add_control(
			new Hestia_Select_Multiple(
				$wp_customize, 'hestia_authors_on_blog', array(
					'section' => 'hestia_blog_authors',
					'description'   => wp_kses(
						__( 'Select the team members to appear at the bottom of the blog archive pages. Hold down <b>control / cmd</b> key to select multiple members.', 'hestia-pro' ), array(
							'b' => array(),
						)
					),
					'label' => esc_html__( 'Team members to appear on blog page', 'hestia-pro' ),
					'choices' => hestia_get_team_on_blog(),
					'priority' => 1,
					'custom_class' => 'repeater-multiselect-team',
				)
			)
		);

	}

	// Background image for authors section on blog.
	$wp_customize->add_setting(
		'hestia_authors_on_blog_background', array(
			'default' => get_template_directory_uri() . '/assets/img/header.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'hestia_authors_on_blog_background', array(
				'label' => esc_html__( 'Background Image', 'hestia-pro' ),
				'section' => 'hestia_blog_authors',
				'priority' => 2,
			)
		)
	);

	// Add subscribe on blog page panel.
	$wp_customize->add_section(
		'hestia_blog_subscribe', array(
			'title' => esc_html__( 'Subscribe Section', 'hestia-pro' ),
			'panel' => 'hestia_blog_settings',
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'hestia_blog_subscribe_title', array(
			'default' => esc_html__( 'Subscribe to our Newsletter', 'hestia-pro' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'hestia_blog_subscribe_title', array(
			'label' => esc_html__( 'Section Title', 'hestia-pro' ),
			'section' => 'hestia_blog_subscribe',
			'priority' => 10,
		)
	);

	$wp_customize->add_setting(
		'hestia_blog_subscribe_subtitle', array(
			'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'hestia-pro' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'hestia_blog_subscribe_subtitle', array(
			'label' => esc_html__( 'Section Subtitle', 'hestia-pro' ),
			'section' => 'hestia_blog_subscribe',
			'priority' => 15,
		)
	);

	if ( class_exists( 'Hestia_Subscribe_Info' ) ) {
		$wp_customize->add_setting(
			'hestia_blog_subscribe_info', array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			new Hestia_Subscribe_Info(
				$wp_customize, 'hestia_blog_subscribe_info', array(
					'label'      => esc_html__( 'Instructions', 'hestia-pro' ),
					'section'    => 'hestia_blog_subscribe',
					'capability' => 'install_plugins',
					'priority'   => 20,
				)
			)
		);
	}
}

add_action( 'customize_register', 'hestia_blog_settings_customize_register' );


/**
 * Get choices for team on blog control.
 *
 * @since 1.1.40
 */
function hestia_get_team_on_blog() {
	$result_array = array();

	$default = hestia_get_team_default();
	$hestia_team_content = get_theme_mod( 'hestia_team_content', $default );
	if ( ! empty( $hestia_team_content ) ) {
		$json = json_decode( $hestia_team_content, true );
		if ( ! empty( $json ) ) {
			foreach ( $json as $team_member ) {
				if ( ! empty( $team_member['id'] ) && ! empty( $team_member['title'] ) ) {
					$result_array[ $team_member['id'] ] = $team_member['title'];
				}
			}
		}
	}
	return $result_array;
}
