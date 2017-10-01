<?php
/**
 * Customizer functionality for the Pro Manager.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

/**
 * Hook Pro manager functionality to customizer.
 */
function hestia_pro_manager_customize_register( $wp_customize ) {

	$documentation_section = $wp_customize->get_section( 'hestia-theme-info' );

	if ( ! empty( $documentation_section ) ) {
		$documentation_section->theme_info_title = esc_html__( 'Hestia Pro', 'hestia-pro' );
		$documentation_section->label_url        = esc_url( 'http://docs.themeisle.com/article/532-hestia-pro-documentation' );
	}

	$wp_customize->remove_section( 'hestia-theme-info-section' );
	$wp_customize->remove_section( 'hestia_theme_info_main_section' );

	/**
	 * Top bar.
	 */
	$selective_refresh = isset( $wp_customize->selective_refresh ) ? true : false;
	if ( class_exists( 'Hestia_Customize_Alpha_Color_Control' ) ) {

		$wp_customize->add_setting(
			'hestia_top_bar_background_color', array(
				'transport' => 'postMessage',
				'sanitize_callback' => 'hestia_sanitize_colors',
				'default' => '#363537',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customize_Alpha_Color_Control(
				$wp_customize, 'hestia_top_bar_background_color', array(
					'label' => esc_html__( 'Background color', 'hestia-pro' ),
					'section' => 'hestia_top_bar',
					'show_opacity' => true,
					'palette' => false,
					'priority' => 5,
				)
			)
		);
	}

	$wp_customize->add_setting(
		'hestia_top_bar_text_color', array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'hestia_sanitize_colors',
			'default' => '#ffffff',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'hestia_top_bar_text_color', array(
				'label'        => esc_html__( 'Text', 'hestia-pro' ) . ' ' . esc_html__( 'Color', 'hestia-pro' ),
				'section'      => 'hestia_top_bar',
				'priority' => 10,
			)
		)
	);

	$wp_customize->add_setting(
		'hestia_top_bar_link_color', array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'hestia_sanitize_colors',
			'default' => '#ffffff',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'hestia_top_bar_link_color', array(
				'label'        => esc_html__( 'Link', 'hestia-pro' ) . ' ' . esc_html__( 'Color', 'hestia-pro' ),
				'section'      => 'hestia_top_bar',
				'priority' => 15,
			)
		)
	);

	$wp_customize->add_setting(
		'hestia_top_bar_link_color_hover', array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'hestia_sanitize_colors',
			'default' => '#eeeeee',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'hestia_top_bar_link_color_hover', array(
				'label'        => esc_html__( 'Link color on hover', 'hestia-pro' ),
				'section'      => 'hestia_top_bar',
				'priority' => 20,
			)
		)
	);

	if ( class_exists( 'Hestia_Customize_Control_Radio_Image' ) ) {
		$wp_customize->add_setting(
			'hestia_top_bar_alignment', array(
				'default' => 'right',
				'sanitize_callback' => 'hestia_sanitize_alignment_options',
				'transport' => $selective_refresh ? 'postMessage' : 'refresh',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customize_Control_Radio_Image(
				$wp_customize, 'hestia_top_bar_alignment', array(
					'priority' => 25,
					'section' => 'hestia_top_bar',
					'choices' => array(
						'left' => array(
							'url' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer-radio-image/img/align-left.png',
							'label' => esc_html__( 'Left Sidebar', 'hestia-pro' ),
						),
						'right' => array(
							'url' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer-radio-image/img/align-right.png',
							'label' => esc_html__( 'Right Sidebar', 'hestia-pro' ),
						),
					),
				)
			)
		);
	}

	$top_bar_sidebar = $wp_customize->get_section( 'sidebar-widgets-sidebar-top-bar' );
	if ( ! empty( $top_bar_sidebar ) ) {
		$controls_to_move = array(
			'hestia_top_bar_background_color',
			'hestia_top_bar_text_color',
			'hestia_top_bar_link_color',
			'hestia_top_bar_link_color_hover',
			'hestia_top_bar_alignment',
		);
		foreach ( $controls_to_move as $control_id ) {
			$control = $wp_customize->get_control( $control_id );
			if ( ! empty( $control ) ) {
				$control->section = 'sidebar-widgets-sidebar-top-bar';
				$control->priority = -1;
			}
		}
	}

	/**
	 * Pro control for sidebar width.
	 */
	if ( class_exists( 'Hestia_Customizer_Range_Value_Control' ) ) {
		$wp_customize->add_setting(
			'hestia_sidebar_width', array(
				'sanitize_callback' => 'absint',
				'default' => 25,
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customizer_Range_Value_Control(
				$wp_customize, 'hestia_sidebar_width', array(
					'label' => esc_html__( 'Sidebar width (%)', 'hestia-pro' ),
					'section' => 'hestia_general',
					'type' => 'range-value',
					'input_attr' => array(
						'min' => 1,
						'max' => 100,
						'step' => 1,
					),
					'priority' => 25,
				)
			)
		);
	}

	/**
	 * Pro controls for shop section.
	 */
	if ( class_exists( 'Hestia_Select_Multiple' ) && class_exists( 'WooCommerce' ) ) {
		$woo_categories = hestia_get_woo_categories();
		$wp_customize->add_setting(
			'hestia_shop_categories', array(
				'sanitize_callback' => 'hestia_sanitize_array',
				'transport' => $selective_refresh ? 'postMessage' : 'refresh',
			)
		);

		$wp_customize->add_control(
			new Hestia_Select_Multiple(
				$wp_customize, 'hestia_shop_categories', array(
					'section' => 'hestia_shop',
					'label' => esc_html__( 'Categories:', 'hestia-pro' ),
					'choices' => $woo_categories,
					'priority' => 20,
				)
			)
		);

		$wp_customize->add_setting(
			'hestia_shop_order', array(
				'sanitize_callback' => 'sanitize_text_field',
				'transport' => $selective_refresh ? 'postMessage' : 'refresh',
				'default' => 'DESC',
			)
		);

		$wp_customize->add_control(
			'hestia_shop_order', array(
				'label' => esc_html__( 'Order', 'hestia-pro' ),
				'section' => 'hestia_shop',
				'priority' => 25,
				'type' => 'select',
				'choices' => array(
					'ASC' => esc_html__( 'Ascending', 'hestia-pro' ),
					'DESC' => esc_html__( 'Descending', 'hestia-pro' ),
				),
			)
		);
	}// End if().

	/**
	 * Full screen menu.
	 */
	$wp_customize->add_setting(
		'hestia_full_screen_menu', array(
			'sanitize_callback' => 'hestia_sanitize_checkbox',
			'default' => false,
		)
	);

	$wp_customize->add_control(
		'hestia_full_screen_menu', array(
			'type' => 'checkbox',
			'label' => esc_html__( 'Enable full screen menu','hestia-pro' ),
			'section' => 'hestia_navigation',
			'priority' => 1,
		)
	);

	$navigation_sidebar = $wp_customize->get_section( 'sidebar-widgets-header-sidebar' );
	if ( ! empty( $navigation_sidebar ) ) {
		$hestia_full_screen_menu = $wp_customize->get_control( 'hestia_full_screen_menu' );
		if ( ! empty( $hestia_full_screen_menu ) ) {
			$hestia_full_screen_menu->section = 'sidebar-widgets-header-sidebar';
			$hestia_full_screen_menu->priority = -2;
		}
	}

	/**
	 * Footer credits
	 */
	$wp_customize->add_setting(
		'hestia_general_credits', array(
			'default' =>
				sprintf(
					/* translators: %1$s is Theme name wrapped in <a> tag, %2$s is WordPress link */
					esc_html__( '%1$s | Powered by %2$s', 'hestia-pro' ),
					/* translators: %s is Theme name */
					sprintf(
						'<a href="https://themeisle.com/themes/hestia/" target="_blank" rel="nofollow">%s</a>',
						esc_html__( 'Hestia', 'hestia-pro' )
					),
					/* translators: %s is WordPress */
					sprintf( '<a href="http://wordpress.org/" rel="nofollow">%s</a>', esc_html__( 'WordPress', 'hestia-pro' ) )
				),
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'hestia_general_credits', array(
			'label' => esc_html__( 'Footer Credits', 'hestia-pro' ),
			'section' => 'hestia_footer_content',
			'priority' => 25,
			'type' => 'textarea',
		)
	);

	/**
	 * Footer alignment
	 */
	if ( class_exists( 'Hestia_Customize_Control_Radio_Image' ) ) {
		$wp_customize->add_setting(
			'hestia_copyright_alignment', array(
				'default' => 'right',
				'sanitize_callback' => 'hestia_sanitize_alignment_options',
				'transport' => $selective_refresh ? 'postMessage' : 'refresh',
			)
		);

		$wp_customize->add_control(
			new Hestia_Customize_Control_Radio_Image(
				$wp_customize, 'hestia_copyright_alignment', array(
					'priority' => 30,
					'section' => 'hestia_footer_content',
					'choices' => array(
						'left' => array(
							'url' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer-radio-image/img/align-left.png',
							'label' => esc_html__( 'Left Sidebar', 'hestia-pro' ),
						),
						'center' => array(
							'url' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer-radio-image/img/align-center.png',
							'label' => esc_html__( 'Full Width', 'hestia-pro' ),
						),
						'right' => array(
							'url' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer-radio-image/img/align-right.png',
							'label' => esc_html__( 'Right Sidebar', 'hestia-pro' ),
						),
					),
				)
			)
		);
	}// End if().

	/**
	 * Footer Widgets Number
	 */

	$wp_customize->add_setting(
		'hestia_nr_footer_widgets', array(
			'default' => '3',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'hestia_nr_footer_widgets', array(
			'label' => esc_html__( 'Number of widgets areas', 'hestia-pro' ),
			'section' => 'hestia_footer_content',
			'priority' => 20,
			'type' => 'select',
			'choices' => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
			),
		)
	);
}

add_action( 'customize_register', 'hestia_pro_manager_customize_register' );

/**
 * Add jetpack notice to customizer.
 */
function hestia_customizer_notice_pro() {
	$info_path = trailingslashit( get_template_directory() ) . 'inc/customizer-info/class/class-hestia-customizer-info-singleton-pro.php';
	if ( file_exists( $info_path ) ) {
		require_once( $info_path );
	}
}

add_action( 'after_setup_theme', 'hestia_customizer_notice_pro', 100 );


// Remove Lite Slider / Big Title
remove_action( 'hestia_header', 'hestia_slider_compatibility' );
remove_action( 'customize_register', 'hestia_big_title_customize_register' );


// Hook Pro Slider
add_action( 'hestia_header', 'hestia_slider' );

/*
 * Import customizer options from Lite version
 */
add_action( 'after_switch_theme', 'hestia_get_lite_options' );

/**
 * Import lite options.
 */
function hestia_get_lite_options() {

	/* import Hestia options */
	$hestia_mods = get_option( 'theme_mods_hestia' );

	if ( ! empty( $hestia_mods ) ) {

		foreach ( $hestia_mods as $hestia_mod_k => $hestia_mod_v ) {
			set_theme_mod( $hestia_mod_k, $hestia_mod_v );
		}
	}
}

define( 'HESTIA_PRO_FLAG', 'pro_available' );

/**
 * Function to filter the about page settings
 *
 * @return array
 */
function hestia_about_page_array_pro() {
	return array(
		// Menu name under Appearance.
		'menu_name'           => __( 'About Hestia Pro', 'hestia-pro' ),
		// Page title.
		'page_name'           => __( 'About Hestia Pro', 'hestia-pro' ),
		// Main welcome title
		/* translators: s - theme name */
		'welcome_title'       => sprintf( __( 'Welcome to %s! - Version ', 'hestia-pro' ), 'Hestia Pro' ),
		// Main welcome content
		'welcome_content'     => esc_html__( 'Hestia Pro is a modern WordPress theme for professionals. It fits creative business, small businesses (restaurants, wedding planners, sport/medical shops), startups, corporate businesses, online agencies and firms, portfolios, ecommerce (WooCommerce), and freelancers. It has a multipurpose one-page design, widgetized footer, blog/news page and a clean look, is compatible with: Flat Parallax Slider, Photo Gallery, Travel Map and Elementor Page Builder . The theme is responsive, WPML, Retina ready, SEO friendly, and uses Material Kit for design.', 'hestia-pro' ),
		/**
		 * Tabs array.
		 *
		 * The key needs to be ONLY consisted from letters and underscores. If we want to define outside the class a function to render the tab,
		 * the will be the name of the function which will be used to render the tab content.
		 */
		'tabs'                => array(
			'getting_started'     => __( 'Getting Started', 'hestia-pro' ),
			'recommended_actions' => __( 'Recommended Actions', 'hestia-pro' ),
			'recommended_plugins' => __( 'Useful Plugins', 'hestia-pro' ),
			'support'             => __( 'Support', 'hestia-pro' ),
			'changelog'           => __( 'Changelog', 'hestia-pro' ),
		),
		// Support content tab.
		'support_content'     => array(
			'first'  => array(
				'title'        => esc_html__( 'Contact Support', 'hestia-pro' ),
				'icon'         => 'dashicons dashicons-sos',
				'text'         => esc_html__( 'We want to make sure you have the best experience using Hestia Pro and that is why we gathered here all the necessary informations for you. We hope you will enjoy using Hestia Pro, as much as we enjoy creating great products.', 'hestia-pro' ),
				'button_label' => esc_html__( 'Contact Support', 'hestia-pro' ),
				'button_link'  => esc_url( 'https://themeisle.com/contact/' ),
				'is_button'    => true,
				'is_new_tab'   => true,
			),
			'second' => array(
				'title'        => esc_html__( 'Documentation', 'hestia-pro' ),
				'icon'         => 'dashicons dashicons-book-alt',
				'text'         => esc_html__( 'Need more details? Please check our full documentation for detailed information on how to use Hestia.', 'hestia-pro' ),
				'button_label' => esc_html__( 'Read full documentation', 'hestia-pro' ),
				'button_link'  => 'http://docs.themeisle.com/article/532-hestia-pro-documentation',
				'is_button'    => false,
				'is_new_tab'   => true,
			),
			'third'  => array(
				'title'        => esc_html__( 'Changelog', 'hestia-pro' ),
				'icon'         => 'dashicons dashicons-portfolio',
				'text'         => esc_html__( 'Want to get the gist on the latest theme changes? Just consult our changelog below to get a taste of the recent fixes and features implemented.', 'hestia-pro' ),
				'button_label' => esc_html__( 'Changelog', 'hestia-pro' ),
				'button_link'  => esc_url( admin_url( 'themes.php?page=hestia-pro-welcome&tab=changelog&show=yes' ) ),
				'is_button'    => false,
				'is_new_tab'   => false,
			),
			'fourth' => array(
				'title'        => esc_html__( 'Create a child theme', 'hestia-pro' ),
				'icon'         => 'dashicons dashicons-admin-customizer',
				'text'         => esc_html__( "If you want to make changes to the theme's files, those changes are likely to be overwritten when you next update the theme. In order to prevent that from happening, you need to create a child theme. For this, please follow the documentation below.", 'hestia-pro' ),
				'button_label' => esc_html__( 'View how to do this', 'hestia-pro' ),
				'button_link'  => 'http://docs.themeisle.com/article/14-how-to-create-a-child-theme',
				'is_button'    => false,
				'is_new_tab'   => true,
			),
			'fifth'  => array(
				'title'        => esc_html__( 'Speed up your site', 'hestia-pro' ),
				'icon'         => 'dashicons dashicons-controls-skipforward',
				'text'         => esc_html__( 'If you find yourself in the situation where everything on your site is running very slow, you might consider having a look at the below documentation where you will find the most common issues causing this and possible solutions for each of the issues.', 'hestia-pro' ),
				'button_label' => esc_html__( 'View how to do this', 'hestia-pro' ),
				'button_link'  => 'http://docs.themeisle.com/article/63-speed-up-your-wordpress-site',
				'is_button'    => false,
				'is_new_tab'   => true,
			),
			'sixth'  => array(
				'title'        => esc_html__( 'Build a landing page with a drag-and-drop content builder', 'hestia-pro' ),
				'icon'         => 'dashicons dashicons-images-alt2',
				'text'         => esc_html__( 'In the documentation below you will find an easy way to build a great looking landing page using a drag-and-drop content builder plugin.', 'hestia-pro' ),
				'button_label' => esc_html__( 'View how to do this', 'hestia-pro' ),
				'button_link'  => 'http://docs.themeisle.com/article/219-how-to-build-a-landing-page-with-a-drag-and-drop-content-builder',
				'is_button'    => false,
				'is_new_tab'   => true,
			),
		),
		// Getting started tab
		'getting_started'     => array(
			'first'  => array(
				'title'               => esc_html__( 'Recommended actions', 'hestia-pro' ),
				'text'                => esc_html__( 'We have compiled a list of steps for you to take so we can ensure that the experience you have using one of our products is very easy to follow.', 'hestia-pro' ),
				'button_label'        => esc_html__( 'Recommended actions', 'hestia-pro' ),
				'button_link'         => esc_url( admin_url( 'themes.php?page=hestia-pro-welcome&tab=recommended_actions' ) ),
				'is_button'           => false,
				'recommended_actions' => true,
				'is_new_tab'          => false,
			),
			'second' => array(
				'title'               => esc_html__( 'Read full documentation', 'hestia-pro' ),
				'text'                => esc_html__( 'Need more details? Please check our full documentation for detailed information on how to use Hestia Pro.', 'hestia-pro' ),
				'button_label'        => esc_html__( 'Documentation', 'hestia-pro' ),
				'button_link'         => 'http://docs.themeisle.com/article/532-hestia-pro-documentation',
				'is_button'           => false,
				'recommended_actions' => false,
				'is_new_tab'          => true,
			),
			'third'  => array(
				'title'               => esc_html__( 'Go to the Customizer', 'hestia-pro' ),
				'text'                => esc_html__( 'Using the WordPress Customizer you can easily customize every aspect of the theme.', 'hestia-pro' ),
				'button_label'        => esc_html__( 'Go to the Customizer', 'hestia-pro' ),
				'button_link'         => esc_url( admin_url( 'customize.php' ) ),
				'is_button'           => true,
				'recommended_actions' => false,
				'is_new_tab'          => true,
			),
		),
		// Plugins array.
		'recommended_plugins' => array(
			'already_activated_message' => esc_html__( 'Already activated', 'hestia-pro' ),
			'version_label'             => esc_html__( 'Version: ', 'hestia-pro' ),
			'install_label'             => esc_html__( 'Install and Activate', 'hestia-pro' ),
			'activate_label'            => esc_html__( 'Activate', 'hestia-pro' ),
			'deactivate_label'          => esc_html__( 'Deactivate', 'hestia-pro' ),
			'content'                   => array(
				array(
					'slug' => 'siteorigin-panels',
				),
				array(
					'slug' => 'wp-product-review',
				),
				array(
					'slug' => 'intergeo-maps',
				),
				array(
					'slug' => 'visualizer',
				),
				array(
					'slug' => 'adblock-notify-by-bweb',
				),
				array(
					'slug' => 'nivo-slider-lite',
				),
			),
		),
		// Required actions array.
		'recommended_actions' => array(
			'install_label'    => esc_html__( 'Install and Activate', 'hestia-pro' ),
			'activate_label'   => esc_html__( 'Activate', 'hestia-pro' ),
			'deactivate_label' => esc_html__( 'Deactivate', 'hestia-pro' ),
			'content'          => array(
				'pirate-forms' => array(
					'title'       => 'Pirate Forms',
					'description' => __( 'Makes your Contact section more engaging by creating a good-looking contact form. Interaction with your visitors has never been easier.', 'hestia-pro' ),
					'check'       => defined( 'PIRATE_FORMS_VERSION' ),
					'plugin_slug' => 'pirate-forms',
					'id'          => 'pirate-forms',
				),

			),
		),
	);
}

add_filter( 'hestia_about_page_array', 'hestia_about_page_array_pro' );

add_filter( 'hestia_customizer_notify_array', '__return_empty_string' );


/**
 * Utils functions for shop section.
 * ================================
 */
/**
 * Get WooCommerce products categories.
 *
 * @since   1.1.40
 * @access  public
 * @return array Returns an array with WooCommerce categories.
 */
function hestia_get_woo_categories() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return array();
	}
	$hestia_categories_array = array();
	$hestia_prod_categories = get_categories(
		array(
			'taxonomy' => 'product_cat',
			'hide_empty' => 1,
			'title_li' => '',
		)
	);
	if ( ! empty( $hestia_prod_categories ) ) {
		foreach ( $hestia_prod_categories as $hestia_prod_cat ) {
			if ( ! empty( $hestia_prod_cat->term_id ) && ! empty( $hestia_prod_cat->name ) ) {
				$hestia_categories_array[ $hestia_prod_cat->term_id ] = $hestia_prod_cat->name;
			}
		}
	}

	return $hestia_categories_array;
}

