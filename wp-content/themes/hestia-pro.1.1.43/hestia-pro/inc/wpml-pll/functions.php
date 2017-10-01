<?php
/**
 * WPML and Polylang compatibility functions.
 *
 * @package hestia
 * @since 1.1.34
 */

/**
 * Filter to translate strings
 */
function hestia_translate_single_string( $original_value, $domain ) {
	if ( is_customize_preview() ) {
		$wpml_translation = $original_value;
	} else {
		$wpml_translation = apply_filters( 'wpml_translate_single_string', $original_value, $domain, $original_value );
		if ( $wpml_translation === $original_value && function_exists( 'pll__' ) ) {
			return pll__( $original_value );
		}
	}
	return $wpml_translation;
}
add_filter( 'hestia_translate_single_string', 'hestia_translate_single_string', 10, 2 );

/**
 * Helper to register pll string.
 *
 * @param String    $theme_mod Theme mod name.
 * @param bool/json $default Default value.
 * @param String    $name Name for polylang backend.
 */
function hestia_pll_string_register_helper( $theme_mod, $default = false, $name ) {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}

	$repeater_content = get_theme_mod( $theme_mod, $default );
	$repeater_content = json_decode( $repeater_content );
	if ( ! empty( $repeater_content ) ) {
		foreach ( $repeater_content as $repeater_item ) {
			foreach ( $repeater_item as $field_name => $field_value ) {
				if ( $field_name === 'social_repeater' ) {
					$social_repeater_value = json_decode( $field_value );
					if ( ! empty( $social_repeater_value ) ) {
						foreach ( $social_repeater_value as $social ) {
							foreach ( $social as $key => $value ) {
								if ( $key === 'link' ) {
									pll_register_string( 'Social link', $value, $name );
								}
								if ( $key === 'icon' ) {
									pll_register_string( 'Social icon', $value, $name );
								}
							}
						}
					}
				} else {
					if ( $field_name !== 'id' ) {
						$f_n = ucfirst( $field_name );
						pll_register_string( $f_n, $field_value, $name );
					}
				}
			}
		}
	}
}

/**
 * Features section. Register strings for translations.
 *
 * @modified 1.1.30
 * @access public
 */
function hestia_features_register_strings() {
	$default = apply_filters(
		'hestia_features_default_content', json_encode(
			array(
				array(
					'icon_value' => 'fa-wechat',
					'title'      => esc_html__( 'Responsive', 'hestia-pro' ),
					'text'       => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'hestia-pro' ),
					'link'       => '#',
					'color'      => '#e91e63',
				),
				array(
					'icon_value' => 'fa-check',
					'title'      => esc_html__( 'Quality', 'hestia-pro' ),
					'text'       => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'hestia-pro' ),
					'link'       => '#',
					'color'      => '#00bcd4',
				),
				array(
					'icon_value' => 'fa-support',
					'title'      => esc_html__( 'Support', 'hestia-pro' ),
					'text'       => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'hestia-pro' ),
					'link'       => '#',
					'color'      => '#4caf50',
				),
			)
		)
	);
	hestia_pll_string_register_helper( 'hestia_features_content', $default, 'Features section' );
}

/**
 * Testimonials section. Register strings for translations.
 *
 * @modified 1.1.34
 * @access public.
 */
function hestia_testimonials_register_strings() {
	$default = apply_filters(
		'hestia_testimonials_default_content', json_encode(
			array(
				array(
					'image_url' => get_template_directory_uri() . '/assets/img/5.jpg',
					'title'     => esc_html__( 'Inverness McKenzie', 'hestia-pro' ),
					'subtitle'  => esc_html__( 'Business Owner', 'hestia-pro' ),
					'text'      => esc_html__( '"We have no regrets! After using your product my business skyrocketed! I made back the purchase price in just 48 hours! I couldn\'t have asked for more than this."', 'hestia-pro' ),
					'id'        => 'customizer_repeater_56d7ea7f40d56',
				),
				array(
					'image_url' => get_template_directory_uri() . '/assets/img/6.jpg',
					'title'     => esc_html__( 'Hanson Deck', 'hestia-pro' ),
					'subtitle'  => esc_html__( 'Independent Artist', 'hestia-pro' ),
					'text'      => esc_html__( '"Your company is truly upstanding and is behind its product 100 percent. Hestia is worth much more than I paid. I like Hestia more each day because it makes easier."', 'hestia-pro' ),
					'id'        => 'customizer_repeater_56d7ea7f40d66',
				),
				array(
					'image_url' => get_template_directory_uri() . '/assets/img/7.jpg',
					'title'     => esc_html__( 'Natalya Undergrowth', 'hestia-pro' ),
					'subtitle'  => esc_html__( 'Freelancer', 'hestia-pro' ),
					'text'      => esc_html__( '"Thank you for making it painless, pleasant and most of all hassle free! I am so pleased with this product. Dude, your stuff is great! I will refer everyone I know."', 'hestia-pro' ),
					'id'        => 'customizer_repeater_56d7ea7f40d76',
				),
			)
		)
	);
	hestia_pll_string_register_helper( 'hestia_testimonials_content', $default, 'Testimonials section' );
}

/**
 * Team section. Register strings for translations.
 *
 * @modified 1.1.34
 * @access public.
 */
function hestia_team_register_strings() {
	$default = apply_filters(
		'hestia_team_default_content', json_encode(
			array(
				array(
					'image_url'       => get_template_directory_uri() . '/assets/img/1.jpg',
					'title'           => esc_html__( 'Desmond Purpleson', 'hestia-pro' ),
					'subtitle'        => esc_html__( 'CEO', 'hestia-pro' ),
					'text'            => esc_html__( 'Locavore pinterest chambray affogato art party, forage coloring book typewriter. Bitters cold selfies, retro celiac sartorial mustache.', 'hestia-pro' ),
					'id'              => 'customizer_repeater_56d7ea7f40c56',
					'social_repeater' => json_encode(
						array(
							array(
								'id'   => 'customizer-repeater-social-repeater-57fb908674e06',
								'link' => 'facebook.com',
								'icon' => 'fa-facebook',
							),
							array(
								'id'   => 'customizer-repeater-social-repeater-57fb9148530ft',
								'link' => 'plus.google.com',
								'icon' => 'fa-google-plus',
							),
							array(
								'id'   => 'customizer-repeater-social-repeater-57fb9148530fc',
								'link' => 'twitter.com',
								'icon' => 'fa-twitter',
							),
							array(
								'id'   => 'customizer-repeater-social-repeater-57fb9150e1e89',
								'link' => 'linkedin.com',
								'icon' => 'fa-linkedin',
							),
						)
					),
				),
				array(
					'image_url'       => get_template_directory_uri() . '/assets/img/2.jpg',
					'title'           => esc_html__( 'Parsley Pepperspray', 'hestia-pro' ),
					'subtitle'        => esc_html__( 'Marketing Specialist', 'hestia-pro' ),
					'text'            => esc_html__( 'Craft beer salvia celiac mlkshk. Pinterest celiac tumblr, portland salvia skateboard cliche thundercats. Tattooed chia austin hell.', 'hestia-pro' ),
					'id'              => 'customizer_repeater_56d7ea7f40c66',
					'social_repeater' => json_encode(
						array(
							array(
								'id'   => 'customizer-repeater-social-repeater-57fb9155a1072',
								'link' => 'facebook.com',
								'icon' => 'fa-facebook',
							),
							array(
								'id'   => 'customizer-repeater-social-repeater-57fb9160ab683',
								'link' => 'twitter.com',
								'icon' => 'fa-twitter',
							),
							array(
								'id'   => 'customizer-repeater-social-repeater-57fb9160ab484',
								'link' => 'pinterest.com',
								'icon' => 'fa-pinterest',
							),
							array(
								'id'   => 'customizer-repeater-social-repeater-57fb916ddffc9',
								'link' => 'linkedin.com',
								'icon' => 'fa-linkedin',
							),
						)
					),
				),
				array(
					'image_url'       => get_template_directory_uri() . '/assets/img/3.jpg',
					'title'           => esc_html__( 'Desmond Eagle', 'hestia-pro' ),
					'subtitle'        => esc_html__( 'Graphic Designer', 'hestia-pro' ),
					'text'            => esc_html__( 'Pok pok direct trade godard street art, poutine fam typewriter food truck narwhal kombucha wolf cardigan butcher whatever pickled you.', 'hestia-pro' ),
					'id'              => 'customizer_repeater_56d7ea7f40c76',
					'social_repeater' => json_encode(
						array(
							array(
								'id'   => 'customizer-repeater-social-repeater-57fb917e4c69e',
								'link' => 'facebook.com',
								'icon' => 'fa-facebook',
							),
							array(
								'id'   => 'customizer-repeater-social-repeater-57fb91830825c',
								'link' => 'twitter.com',
								'icon' => 'fa-twitter',
							),
							array(
								'id'   => 'customizer-repeater-social-repeater-57fb918d65f2e',
								'link' => 'linkedin.com',
								'icon' => 'fa-linkedin',
							),
							array(
								'id'   => 'customizer-repeater-social-repeater-57fb918d65f2x',
								'link' => 'dribbble.com',
								'icon' => 'fa-dribbble',
							),
						)
					),
				),
				array(
					'image_url'       => get_template_directory_uri() . '/assets/img/4.jpg',
					'title'           => esc_html__( 'Ruby Von Rails', 'hestia-pro' ),
					'subtitle'        => esc_html__( 'Lead Developer', 'hestia-pro' ),
					'text'            => esc_html__( 'Small batch vexillologist 90\'s blue bottle stumptown bespoke. Pok pok tilde fixie chartreuse, VHS gluten-free selfies wolf hot.', 'hestia-pro' ),
					'id'              => 'customizer_repeater_56d7ea7f40c86',
					'social_repeater' => json_encode(
						array(
							array(
								'id'   => 'customizer-repeater-social-repeater-57fb925cedcg5',
								'link' => 'github.com',
								'icon' => 'fa-github-square',
							),
							array(
								'id'   => 'customizer-repeater-social-repeater-57fb925cedcb2',
								'link' => 'facebook.com',
								'icon' => 'fa-facebook',
							),
							array(
								'id'   => 'customizer-repeater-social-repeater-57fb92615f030',
								'link' => 'twitter.com',
								'icon' => 'fa-twitter',
							),
							array(
								'id'   => 'customizer-repeater-social-repeater-57fb9266c223a',
								'link' => 'linkedin.com',
								'icon' => 'fa-linkedin',
							),
						)
					),
				),
			)
		)
	);
	hestia_pll_string_register_helper( 'hestia_team_content', $default, 'Team section' );
}

/**
 * Register polylang strings
 *
 * @since 1.1.31
 * @modified 1.1.34
 * @access public
 */
function hestia_slider_register_strings() {
	$default = hestia_get_slider_default();
	hestia_pll_string_register_helper( 'hestia_slider_content', json_encode( $default ), 'Slider section' );
}
add_action( 'after_setup_theme', 'hestia_slider_register_strings', 11 );
