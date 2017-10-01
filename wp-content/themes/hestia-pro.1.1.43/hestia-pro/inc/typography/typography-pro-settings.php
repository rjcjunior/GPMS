<?php
/**
 * Pro typography settings.
 *
 * @package Hestia
 * @since 1.1.38
 */

/**
 * Register typography controls for pro version.
 *
 * @param WP_Customize_Manager $wp_customize Customize manager.
 * @since 1.1.38
 */
function hestia_typography_pro_settings( $wp_customize ) {

	if ( ! class_exists( 'Hestia_Customizer_Range_Value_Control' ) ) {
		return;
	}

	$body_text_control = $wp_customize->get_control( 'hestia_body_font_size' );
	if ( ! empty( $body_text_control ) ) {
		$body_text_control->media_query = true;
	}

	$headings_text_control = $wp_customize->get_control( 'hestia_headings_font_size' );
	if ( ! empty( $headings_text_control ) ) {
		$headings_text_control->media_query = true;
	}

	$wp_customize->add_setting(
		'hestia_line_height', array(
			'sanitize_callback' => 'hestia_sanitize_range_value',
			'default' => 21,
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new Hestia_Customizer_Range_Value_Control(
			$wp_customize, 'hestia_line_height', array(
				'label'    => esc_html__( 'Line height', 'hestia-pro' ) . ' ( ' . esc_html__( 'px','hestia-pro' ) . ' )',
				'section'  => 'hestia_typography',
				'type'     => 'range-value',
				'input_attr' => array(
					'min'    => 10,
					'max'    => 50,
					'step'   => 0.1,
				),
				'priority' => 35,
				'media_query' => true,
			)
		)
	);

	$wp_customize->add_setting(
		'hestia_letter_spacing', array(
			'sanitize_callback' => 'hestia_sanitize_range_value',
			'default' => 0,
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new Hestia_Customizer_Range_Value_Control(
			$wp_customize, 'hestia_letter_spacing', array(
				'label'    => esc_html__( 'Letter spacing', 'hestia-pro' ) . ' ( ' . esc_html__( 'px','hestia-pro' ) . ' )',
				'section'  => 'hestia_typography',
				'type'     => 'range-value',
				'input_attr' => array(
					'min'    => 0,
					'max'    => 8,
					'step'   => 0.1,
				),
				'priority' => 40,
				'media_query' => true,
			)
		)
	);

	$wp_customize->add_setting(
		'hestia_paragraph_margin', array(
			'sanitize_callback' => 'hestia_sanitize_range_value',
			'default' => 10,
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new Hestia_Customizer_Range_Value_Control(
			$wp_customize, 'hestia_paragraph_margin', array(
				'label'    => esc_html__( 'Paragraph', 'hestia-pro' ) . ' ' . esc_html__( 'margin', 'hestia-pro' ) . ' ( ' . esc_html__( 'px','hestia-pro' ) . ' )',
				'section'  => 'hestia_typography',
				'type'     => 'range-value',
				'input_attr' => array(
					'min'    => 0,
					'max'    => 100,
					'step'   => 0.1,
				),
				'priority' => 45,
				'media_query' => true,
			)
		)
	);
}
add_action( 'customize_register', 'hestia_typography_pro_settings', 25 );



/**
 * Adds advanced inline style from customizer.
 *
 * @since 1.1.38
 */
function hestia_tipography_advanced_inline_style() {
	$custom_css = '';

	/**
	 * Line height inline style.
	 */
	$custom_css .= hestia_get_inline_style( 'hestia_line_height', 'hestia_get_line_height_style', $custom_css );

	/**
	 * Letter spacing inline style.
	 */
	$custom_css .= hestia_get_inline_style( 'hestia_letter_spacing', 'hestia_get_letter_spacing_style', $custom_css );

	/**
	 * Letter spacing inline style.
	 */
	$custom_css .= hestia_get_inline_style( 'hestia_paragraph_margin', 'hestia_get_paragraph_margin_style', $custom_css );

	wp_add_inline_style( 'hestia_style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'hestia_tipography_advanced_inline_style' );



/**
 * Function that returns inline style for body font style.
 *
 * @param float  $value Font size.
 * @param string $dimension Query dimension.
 *
 * @since 1.1.38
 * @return string
 */
function hestia_get_line_height_style( $value, $dimension = 'desktop' ) {
	$custom_css = '';
	if ( empty( $value ) ) {
		return '';
	}

	$custom_css .= 'body, .woocommerce .product .card-product .card-description p,
	.woocommerce ul.product_list_widget li a, .footer ul.product_list_widget li a, ul.product_list_widget li a{
	    line-height: ' . floatval( $value ) . 'px;
	}';

	$lh_blog_post = $value + 4.2;
	$custom_css .= '.blog-post, ul, ol, .carousel span.sub-title{
        line-height: ' . floatval( $lh_blog_post ) . 'px;
    }';

	$lh_comments = $value + 4.6;
	$custom_css .= '.media p{
        line-height: ' . floatval( $lh_comments ) . 'px;
    }';

	$lh_h1 = $value + 56.28;
	$custom_css .= 'h1, .carousel h1.hestia-title, .carousel h2.title{
        line-height: ' . floatval( $lh_h1 ) . 'px;
    }';

	$lh_h2 = $value + 33.6;
	$custom_css .= 'h2{
        line-height: ' . floatval( $lh_h2 ) . 'px;
    }';

	$lh_h3 = $value + 14.77;
	$custom_css .= 'h3{
        line-height: ' . floatval( $lh_h3 ) . 'px;
    }';

	$lh_h4 = $value + 7.21;
	$custom_css .= 'h4, .widget h5, .woocommerce-cart table.shop_table .product-name a{
        line-height: ' . floatval( $lh_h4 ) . 'px;
    }';

	$lh_h5 = $value + 6.125;
	$custom_css .= 'h5, .hestia-about p{
        line-height: ' . floatval( $lh_h5 ) . 'px;
    }';

	$lh_h6 = $value - 2.1;
	$custom_css .= 'h6{
        line-height: ' . floatval( $lh_h6 ) . 'px;
    }';

	$lh_list = $value + 12.6;
	$custom_css .= '.widget ul li{
        line-height: ' . floatval( $lh_list ) . 'px;
    }';

	$custom_css = hestia_add_media_query( $dimension, $custom_css );

	return $custom_css;
}

/**
 * Function that returns inline style for letter spacing.
 *
 * @param float  $value Letter spacing value.
 * @param string $dimension Query dimension.
 *
 * @since 1.1.38
 * @return string
 */
function hestia_get_letter_spacing_style( $value, $dimension = 'desktop' ) {
	$custom_css = '';
	if ( empty( $value ) ) {
		return '';
	}

	$custom_css .= 'body{
        letter-spacing: ' . floatval( $value ) . 'px
    }';

	$custom_css = hestia_add_media_query( $dimension, $custom_css );

	return $custom_css;
}

/**
 * Function that returns inline style for paragraph margin bottom.
 *
 * @param float  $value Paragraph margin value.
 * @param string $dimension Query dimension.
 *
 * @since 1.1.38
 * @return string
 */
function hestia_get_paragraph_margin_style( $value, $dimension = 'desktop' ) {
	$custom_css = '';
	if ( empty( $value ) ) {
		return '';
	}

	$custom_css .= 'p, .blog-post .section-text p, .hestia-about p, .card-description p, 
	.woocommerce .product .card-product .card-description p{
        margin-bottom: ' . floatval( $value ) . 'px
    }';

	$custom_css = hestia_add_media_query( $dimension, $custom_css );

	return $custom_css;
}

/**
 * Add media queries
 *
 * @param string $dimension Query dimension.
 * @param string $custom_css Css.
 * @return string
 */
function hestia_add_media_query( $dimension, $custom_css ) {
	switch ( $dimension ) {
		case 'tablet':
			$custom_css = '@media (max-width: 767px){' . $custom_css . '}';
			break;
		case 'mobile':
			$custom_css = '@media (max-width: 480px){' . $custom_css . '}';
			break;
	}
	return $custom_css;
}

/**
 * Adds inline style for sidebar width
 *
 * @since 1.1.31
 */
function hestia_sidebar_width_inline_style() {
	$custom_css              = '';

	$default_blog_layout = hestia_sidebar_on_single_post_get_default();
	$hestia_blog_sidebar_layout = get_theme_mod( 'hestia_blog_sidebar_layout', $default_blog_layout );
	$custom_css .= hestia_sidebar_style( $hestia_blog_sidebar_layout, 'blog' );
	$hestia_page_sidebar_layout = get_theme_mod( 'hestia_page_sidebar_layout', 'full-width' );
	$custom_css .= hestia_sidebar_style( $hestia_page_sidebar_layout, 'page' );

	wp_add_inline_style( 'hestia_style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'hestia_sidebar_width_inline_style' );

/**
 * Add inline style for sidebar width.
 *
 * @param string $layout Page layout.
 * @param string $type Control type.
 * @return string
 */
function hestia_sidebar_style( $layout, $type ) {
	$hestia_sidebar_width = get_theme_mod( 'hestia_sidebar_width',25 );
	$custom_css = '';
	if ( $layout !== 'full-width' ) {

		if ( ! empty( $hestia_sidebar_width ) ) {
			$hestia_content_width = 100 - $hestia_sidebar_width;

			if ( $hestia_sidebar_width <= 3 || $hestia_sidebar_width >= 80 ) {
				$hestia_content_width = 100;
				$hestia_sidebar_width = 100;
			}
			$content_width = $hestia_content_width - 8.33333333;
			switch ( $type ) {
				case 'blog':
					if ( is_active_sidebar( 'sidebar-1' ) ) {
						$custom_css .= '
	                    @media (min-width: 992px){
	                        .blog-sidebar-wrapper{
	                            width: ' . $hestia_sidebar_width . '%;
	                            display: inline-block;
	                        }
	                
	                        .single-post-wrap,
	                        .blog-posts-wrap, 
	                        .archive-post-wrap {
	                            width: ' . $content_width . '%;
	                        }
	                    } ';
					}
					break;
				case 'page':
					if ( is_active_sidebar( 'sidebar-woocommerce' ) ) {
						$custom_css .= '
		                    @media (min-width: 992px){
		                        .shop-sidebar.card.card-raised.col-md-3, .shop-sidebar-wrapper {
		                            width: ' . $hestia_sidebar_width . '%;
		                        }
		                        .content-sidebar-left,
		                        .content-sidebar-right,
		                        .page-content-wrap{
		                
		                            width: ' . $hestia_content_width . '%;
		                        }
		                    }';
					}
			}
		}// End if().
	}// End if().
	return $custom_css;
}
