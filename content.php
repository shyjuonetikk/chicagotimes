<?php $obj = \CST\Objects\Post::get_by_post_id( get_the_ID() ); ?>
<?php if ( ! is_sticky() ) : ?>
	<?php if ( is_singular() ) : ?>
		<div class="row post-row">
		<?php endif; ?>

		<?php
		if ( is_singular() ) {
			$classes = array( 'single-view', 'columns', 'large-12', 'end', 'cst-sharing-relative' );
		} else {
			$classes = array( 'index-view' );
		}

		$attrs = '';
		if ( is_singular() ) {
			$data = array(
				'post-id'   => get_the_ID(),
				'post-uri'  => parse_url( get_permalink( $obj->get_id() ), PHP_URL_PATH ),
				'wp-title'  => wp_title( '|', false, 'right' ),
				);

			for ( $i = 1;  $i <= 5;  $i++) {
				$data[ 'ga-dimension-' . $i ] = $obj->get_ga_dimension( $i );
			}

			foreach ( $data as $key => $val ) {
				$attrs .= ' data-cst-' . sanitize_key( $key ) . '="' . esc_attr( $val ) . '"';
			}
		}

		?>
		<article id="post-<?php the_id(); ?>" <?php post_class( $classes ); ?> <?php echo $attrs; ?>>

			<?php if ( is_singular() ) : ?>

				<?php if ( 'cst_embed' !== $obj->get_post_type() || 'twitter' !== $obj->get_embed_type() ) : ?>
					<div class="post-meta post-meta-social show-for-medium-up">
						<?php echo CST()->get_template_part( 'post/social-share', array( 'obj' => $obj ) ); ?>
					</div>
				<?php endif; ?>

			<?php endif; ?>

			<?php
			echo CST()->get_template_part( 'post/meta-top', array( 'obj' => $obj, 'is_main_query' => true ) );
			echo CST()->get_template_part( 'content-' . str_replace( 'cst_', '', get_post_type() ), array( 'obj' => $obj, 'is_main_query' => true ) );
			if ( is_singular() ) {
				echo CST()->get_template_part( 'post/post-recommendations-chartbeat', array( 'obj' => $obj ) );
			}
			echo CST()->get_template_part( 'post/meta-bottom', array( 'obj' => $obj, 'is_main_query' => true ) );
			?>
		</article>

		<?php if ( is_singular() ) : ?>
		<section class="taboola-container">
		<?php get_template_part( 'parts/taboola/taboola-container' ); ?>
		</section>
		<?php endif; ?>

		<section class="ad-container">
			<?php
			global $wp_query;
			if ( is_singular() ) {
				echo CST()->dfp_handler->dynamic_unit( get_the_ID(), 'div-gpt-placement-a', 'dfp-placement', 'article_lead_unit_mapping', 'atf leaderboard' );
			} else {
				$every_two = $wp_query->current_post % 2;
				if ( ( ! $every_two ) ) {
					echo CST()->dfp_handler->dynamic_unit( get_the_ID(), 'div-gpt-placement-s', 'dfp-placement', 'sf_inline_mapping', 'rr cube 2' );
				}
			}
			?>
		</section>

		<?php if ( is_singular() ) : ?>
		</div>
	<?php endif; ?>
<?php endif; ?>
