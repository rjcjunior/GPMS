<?php
/**
 * Portfolio section for the homepage.
 *
 * @package Hestia
 * @since Hestia 1.0
 */

if ( class_exists( 'Jetpack' ) ) {

	if ( Jetpack::is_module_active( 'custom-content-types' ) ) {

		if ( ! function_exists( 'hestia_portfolio' ) ) :
			/**
			 * Portfolio section content.
			 *
			 * @since Hestia 1.0
			 * @modified 1.1.34
			 */
			function hestia_portfolio( $is_shortcode = false ) {
				$hide_section = get_theme_mod( 'hestia_portfolio_hide', true );
				if ( ! $is_shortcode && (bool) $hide_section === true ) {
					return;
				}
				$hestia_portfolio_title = get_theme_mod( 'hestia_portfolio_title', esc_html__( 'Portfolio', 'hestia-pro' ) );
				$hestia_portfolio_subtitle = get_theme_mod( 'hestia_portfolio_subtitle', esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'hestia-pro' ) );
				if ( $is_shortcode ) {
					$hestia_portfolio_title = '';
					$hestia_portfolio_subtitle = '';
				}

				$hestia_portfolio_items = get_theme_mod( 'hestia_portfolio_items', 3 );
				$hestia_portfolio_boxes_type = get_theme_mod( 'hestia_portfolio_boxes_type', false );

				$class_to_add = 'container';
				if ( $is_shortcode ) {
					$class_to_add = '';
				}

				hestia_before_portfolio_section_trigger();
				?>
				<section class="work hestia-work" id="portfolio" data-sorder="hestia_portfolio">
					<?php hestia_before_portfolio_section_content_trigger(); ?>
					<div class="<?php echo esc_attr( $class_to_add ); ?>">
						<div class="row">
							<div class="col-md-8 col-md-offset-2 text-center">
								<?php if ( ! empty( $hestia_portfolio_title ) || is_customize_preview() ) : ?>
									<h2 class="hestia-title"><?php echo esc_html( $hestia_portfolio_title ); ?></h2>
								<?php endif; ?>
								<?php if ( ! empty( $hestia_portfolio_subtitle ) || is_customize_preview() ) : ?>
									<h5 class="description"><?php echo esc_html( $hestia_portfolio_subtitle ); ?></h5>
								<?php endif; ?>
							</div>
						</div>
						<?php hestia_portfolio_content( $hestia_portfolio_items, $hestia_portfolio_boxes_type ); ?>
					</div>
					<?php hestia_after_portfolio_section_content_trigger(); ?>
				</section>
				<?php
				hestia_after_portfolio_section_trigger();
			}

		endif;

		if ( function_exists( 'hestia_portfolio' ) ) {
			$section_priority = apply_filters( 'hestia_section_priority', 25, 'hestia_portfolio' );
			add_action( 'hestia_sections', 'hestia_portfolio', absint( $section_priority ) );
		}
	}// End if().
}// End if().


/**
 * Get content for portfolio section.
 *
 * @since 1.1.31
 * @access public
 * @param string $hestia_portfolio_items Number of items.
 * @param bool   $hestia_portfolio_boxes_type Box type.
 * @param bool   $is_callback Flag to check if it's callback or not.
 */
function hestia_portfolio_content( $hestia_portfolio_items, $hestia_portfolio_boxes_type, $is_callback = false ) {
	if ( ! post_type_exists( 'jetpack-portfolio' ) ) {
		return;
	}

	if ( ! $is_callback ) {
	?>
		<div class="hestia-portfolio-content">
		<?php
	}

	if ( ! empty( $hestia_portfolio_items ) ) :
	?>
		<?php
		$post = new WP_Query(
			array(
				'post_type' => 'jetpack-portfolio',
				'posts_per_page' => absint( $hestia_portfolio_items ),
			)
		);
		?>
	<?php else : ?>
		<?php
		$post = new WP_Query(
			array(
				'post_type' => 'jetpack-portfolio',
				'posts_per_page' => 3,
			)
		);
		?>
	<?php endif; ?>
	<?php
	if ( $post->have_posts() ) :

		$portfolio_counter = 1;

		$i = 1;
		echo '<div class="row">';

		while ( $post->have_posts() ) :
			$post->the_post();

			if ( ! empty( $hestia_portfolio_boxes_type ) && ($hestia_portfolio_boxes_type == true) ) {
				if ( ($portfolio_counter % 4 == 0) || ($portfolio_counter % 5 == 0) ) {
					$portfolio_class_to_add = 'col-md-6';
				} elseif ( $portfolio_counter > 5 ) {
					$portfolio_counter = 1;
					$portfolio_class_to_add = 'col-md-4';
				} else {
					$portfolio_class_to_add = 'col-md-4';
				}
				$portfolio_counter++;
			} else {
				$portfolio_class_to_add = 'col-md-4';
			}

			?>

			<div class="<?php echo esc_attr( $portfolio_class_to_add ); ?> portfolio-item">
				<div class="card card-background card-raised"
					 style="background-image: url('<?php the_post_thumbnail_url( 'hestia-portfolio' ); ?>')">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<div class="content">
							<?php
							$hestia_categories = get_the_terms( $post->ID, 'jetpack-portfolio-type' );
							?>
							<?php if ( ! empty( $hestia_categories ) ) : ?>
								<span class="label label-primary"><?php echo esc_html( $hestia_categories[0]->name ); ?></span>
							<?php endif; ?>
							<?php the_title( '<h4 class="card-title">', '</h4>' ); ?>
						</div>
					</a>
				</div>
			</div>

			<?php

			if ( ! empty( $hestia_portfolio_boxes_type ) && ($hestia_portfolio_boxes_type == true) ) {
				if ( $i % 3 == 0 ) {
					echo '</div><!-- /.row -->';
					echo '<div class="row">';
				} elseif ( ( $i % 5 == 0 ) ) {
					echo '</div><!-- /.row -->';
					echo '<div class="row">';
					$i = $i - 5;
				}
			} else {
				if ( $i % 3 == 0 ) {
					echo '</div><!-- /.row -->';
					echo '<div class="row">';
				}
			}
			$i++;

		endwhile;
		echo '</div>';
	endif;

	if ( ! $is_callback ) {
	?>
		</div>
		<?php
	}
}
