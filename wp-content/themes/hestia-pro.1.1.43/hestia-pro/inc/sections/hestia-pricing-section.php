<?php
/**
 * Pricing section for the homepage.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

if ( ! function_exists( 'hestia_pricing' ) ) :
	/**
	 * Pricing section content.
	 *
	 * @since Hestia 1.0
	 * @modified 1.1.34
	 */
	function hestia_pricing( $is_shortcode = true ) {
		$hide_section = get_theme_mod( 'hestia_pricing_hide', true );
		if ( ! $is_shortcode && (bool) $hide_section === true ) {
			return;
		}
		$hestia_pricing_title           = get_theme_mod( 'hestia_pricing_title', esc_html__( 'Choose a plan for your next project', 'hestia-pro' ) );
		$hestia_pricing_subtitle        = get_theme_mod( 'hestia_pricing_subtitle', esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'hestia-pro' ) );

		$hestia_pricing_table_one_title = get_theme_mod( 'hestia_pricing_table_one_title', esc_html__( 'Basic Package', 'hestia-pro' ) );
		$hestia_pricing_table_one_price = get_theme_mod( 'hestia_pricing_table_one_price', '<small>$</small>0' );

		$default                           = sprintf( '<b>%1$s</b> %2$s', esc_html__( '1', 'hestia-pro' ), esc_html__( 'Domain', 'hestia-pro' ) ) .
											 sprintf( '\n<b>%1$s</b> %2$s', esc_html__( '1GB', 'hestia-pro' ), esc_html__( 'Storage', 'hestia-pro' ) ) .
											 sprintf( '\n<b>%1$s</b> %2$s', esc_html__( '100GB', 'hestia-pro' ), esc_html__( 'Bandwidth', 'hestia-pro' ) ) .
											 sprintf( '\n<b>%1$s</b> %2$s', esc_html__( '2', 'hestia-pro' ), esc_html__( 'Databases', 'hestia-pro' ) );
		$hestia_pricing_table_one_features = get_theme_mod( 'hestia_pricing_table_one_features', $default );
		if ( ! is_array( $hestia_pricing_table_one_features ) ) {
			$hestia_pricing_table_one_features = explode( '\n', str_replace( '\r', '', wp_kses_post( force_balance_tags( $hestia_pricing_table_one_features ) ) ) );
		}

		$hestia_pricing_table_one_link  = get_theme_mod( 'hestia_pricing_table_one_link', '#' );
		$hestia_pricing_table_one_text  = get_theme_mod( 'hestia_pricing_table_one_text', esc_html__( 'Free Download', 'hestia-pro' ) );
		$hestia_pricing_table_two_title = get_theme_mod( 'hestia_pricing_table_two_title', esc_html__( 'Premium Package', 'hestia-pro' ) );
		$hestia_pricing_table_two_price = get_theme_mod( 'hestia_pricing_table_two_price', '<small>$</small>49' );

		$default                           = sprintf( '<b>%1$s</b> %2$s', esc_html__( '5', 'hestia-pro' ), esc_html__( 'Domain', 'hestia-pro' ) ) .
											 sprintf( ' \n<b>%1$s</b> %2$s', esc_html__( 'Unlimited', 'hestia-pro' ), esc_html__( 'Storage', 'hestia-pro' ) ) .
											 sprintf( ' \n<b>%1$s</b> %2$s', esc_html__( 'Unlimited', 'hestia-pro' ), esc_html__( 'Bandwidth', 'hestia-pro' ) ) .
											 sprintf( ' \n<b>%1$s</b> %2$s', esc_html__( 'Unlimited', 'hestia-pro' ), esc_html__( 'Databases', 'hestia-pro' ) );
		$hestia_pricing_table_two_features = get_theme_mod( 'hestia_pricing_table_two_features', $default );
		if ( ! is_array( $hestia_pricing_table_two_features ) ) {
			$hestia_pricing_table_two_features = explode( '\n', str_replace( '\r', '', wp_kses_post( force_balance_tags( $hestia_pricing_table_two_features ) ) ) );
		}
		$hestia_pricing_table_two_link = get_theme_mod( 'hestia_pricing_table_two_link', '#' );
		$hestia_pricing_table_two_text = get_theme_mod( 'hestia_pricing_table_two_text', esc_html__( 'Order Now', 'hestia-pro' ) );

		$class_to_add = 'container';
		if ( $is_shortcode ) {
			$class_to_add = '';
		}

		hestia_before_pricing_section_trigger();
		?>
		<section class="pricing section-gray" id="pricing" data-sorder="hestia_pricing">
			<?php hestia_before_pricing_section_content_trigger(); ?>
			<div class="<?php echo esc_attr( $class_to_add ); ?>">
				<div class="row">
					<div class="col-md-4">
						<?php if ( ! empty( $hestia_pricing_title ) || is_customize_preview() ) : ?>
							<h2 class="hestia-title"><?php echo esc_html( $hestia_pricing_title ); ?></h2>
						<?php endif; ?>
						<?php if ( ! empty( $hestia_pricing_subtitle ) || is_customize_preview() ) : ?>
							<p class="text-gray"><?php echo esc_html( $hestia_pricing_subtitle ); ?></p>
						<?php endif; ?>
					</div>
					<div class="col-md-7 col-md-offset-1">
						<div class="row">
							<div class="col-md-6 hestia-table-one">
								<div class="card card-pricing card-raised">
									<div class="content">
										<?php if ( ! empty( $hestia_pricing_table_one_title ) || is_customize_preview() ) : ?>
											<h6 class="category"><?php echo esc_html( $hestia_pricing_table_one_title ); ?></h6>
										<?php endif; ?>
										<?php if ( ! empty( $hestia_pricing_table_one_price ) || is_customize_preview() ) : ?>
											<h3 class="card-title"><?php echo wp_kses_post( $hestia_pricing_table_one_price ); ?></h3>
										<?php endif; ?>

										<?php if ( ! empty( $hestia_pricing_table_one_features ) ) : ?>
											<ul>
												<?php foreach ( $hestia_pricing_table_one_features as $feature ) : ?>
													<li><?php echo wp_kses_post( $feature ); ?></li>
												<?php endforeach; ?>
											</ul>
										<?php endif; ?>

										<?php if ( ( ! empty( $hestia_pricing_table_one_link ) && ! empty( $hestia_pricing_table_one_text ) ) || is_customize_preview() ) : ?>
											<a href="<?php echo esc_url( $hestia_pricing_table_one_link ); ?>" class="btn btn-primary"><?php echo esc_html( $hestia_pricing_table_one_text ); ?></a>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="col-md-6 hestia-table-two">
								<div class="card card-pricing card-plain">
									<div class="content">
										<?php if ( ! empty( $hestia_pricing_table_two_title ) || is_customize_preview() ) : ?>
											<h6 class="category"><?php echo esc_html( $hestia_pricing_table_two_title ); ?></h6>
										<?php endif; ?>
										<?php if ( ! empty( $hestia_pricing_table_two_price ) || is_customize_preview() ) : ?>
											<h3 class="card-title"><?php echo wp_kses_post( $hestia_pricing_table_two_price ); ?></h3>
										<?php endif; ?>
										<?php if ( ! empty( $hestia_pricing_table_two_features ) ) : ?>
											<ul>
												<?php foreach ( $hestia_pricing_table_two_features as $feature ) : ?>
													<li><?php echo wp_kses_post( $feature ); ?></li>
												<?php endforeach; ?>
											</ul>
										<?php endif; ?>
										<?php if ( ( ! empty( $hestia_pricing_table_two_link ) && ! empty( $hestia_pricing_table_two_text ) ) || is_customize_preview() ) : ?>
											<a href="<?php echo esc_url( $hestia_pricing_table_two_link ); ?>" class="btn btn-primary"><?php echo esc_html( $hestia_pricing_table_two_text ); ?></a>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php hestia_after_pricing_section_content_trigger(); ?>
		</section>
		<?php
		hestia_after_pricing_section_trigger();
	}
endif;

if ( function_exists( 'hestia_pricing' ) ) {
	$section_priority = apply_filters( 'hestia_section_priority', 35, 'hestia_pricing' );
	add_action( 'hestia_sections', 'hestia_pricing', absint( $section_priority ) );
}
