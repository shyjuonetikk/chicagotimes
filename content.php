<?php $obj = \CST\Objects\Post::get_by_post_id( get_the_ID() ); ?>
<?php
$sponsored = false;
if ( $obj && is_singular( 'cst_article' ) ) {
	if ( is_callable( array( $obj, 'get_sponsored_content' ) ) ) {
		$sponsored = $obj->get_sponsored_content();
	}
}
?>
<?php if ( ! is_sticky() ) : ?>
	<?php if ( is_singular( array( 'cst_article', 'cst_gallery' ) ) ) : ?>
		<div class="row post-row">
		<?php endif; ?>

		<?php
		if ( is_singular() ) {
			$classes = array( 'single-view', 'columns', 'small-12', 'column-adjust', 'end', 'cst-sharing-relative' );
		} else {
			$classes = array( 'index-view' );
		}
		if ( $sponsored ) {
			$classes[] = 'sponsored-content';
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
			<?php if ( $sponsored ) { ?>
				<div class="sponsored-treatment">
			<?php } ?>
			<?php if ( is_singular( array( 'cst_article', 'cst_gallery' ) ) ) : ?>

				<?php if ( 'cst_embed' !== $obj->get_post_type() || 'twitter' !== $obj->get_embed_type() ) : ?>
					<div class="post-meta post-meta-social show-for-medium-up">
						<?php echo CST()->get_template_part( 'post/social-share', array( 'obj' => $obj ) ); ?>
					</div>
				<?php endif; ?>

			<?php endif; ?>

			<?php
			if ( is_singular( array( 'cst_article', 'cst_gallery' ) ) || is_tax() ) {
				echo CST()->get_template_part( 'post/meta-top', array( 'obj' => $obj, 'is_main_query' => true ) );
			}
			echo CST()->get_template_part( 'content-' . str_replace( 'cst_', '', get_post_type() ), array( 'obj' => $obj, 'is_main_query' => true ) );
			if ( $sponsored ) { ?>
				</div>
			<?php }
			if ( is_tax() || is_singular( array( 'cst_article', 'cst_gallery' ) ) ) {
				echo CST()->get_template_part( 'post/meta-bottom', array( 'obj' => $obj, 'is_main_query' => true ) );
			}
			if ( is_singular( array( 'cst_article', 'cst_gallery' ) ) ) {
				echo CST()->get_template_part( 'post/post-recommendations-chartbeat', array( 'obj' => $obj ) );
				CST()->frontend->inject_headlines_network_markup( $obj );
			} ?>
		</article>

		<?php if ( is_singular( 'cst_article' ) ) { ?>
		<section class="taboola-container medium-11 medium-offset-1 columns">
		<?php get_template_part( 'parts/taboola/taboola-container' ); ?>
		</section>
		<?php } ?>

		<?php CST()->frontend->content_ad_injection( $paged ); ?>

		<?php if ( is_singular( array( 'cst_article', 'cst_gallery' ) ) ) : ?>
		</div>
	<?php endif; ?>
<?php endif; ?>
