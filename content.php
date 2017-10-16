<?php $obj = \CST\Objects\Post::get_by_post_id( get_the_ID() ); ?>
<?php
$sponsored = false;
$attrs = '';
if ( $obj && is_singular( 'cst_article' ) ) {
	if ( is_callable( array( $obj, 'get_sponsored_content' ) ) ) {
		$sponsored = $obj->get_sponsored_content();
	}
}
?>
<?php if ( ! is_sticky() ) : ?>
	<?php if ( is_singular( array( 'cst_article', 'cst_gallery', 'cst_video' ) ) ) : ?>
		<div class="row post-row">
		<?php endif; ?>

		<?php
	if ( is_singular() ) {
		$classes = array( 'single-view', 'columns', 'small-12', 'column-adjust', 'end', 'cst-sharing-relative' );
		$attrs = CST()->frontend->article_dimensions( $obj );
	} else {
		$classes = array( 'columns index-view' );
	}
if ( $sponsored ) {
	$classes[] = 'sponsored-content';
}
		?>
		<article id="post-<?php the_id(); ?>" <?php post_class( $classes ); ?> <?php echo wp_kses_post( $attrs ); ?>>
			<?php if ( $sponsored ) { ?>
				<div class="sponsored-treatment">
			<?php } ?>
			<?php if ( is_singular( array( 'cst_article', 'cst_gallery', 'cst_video' ) ) ) : ?>

				<?php if ( 'cst_embed' !== $obj->get_post_type() || 'twitter' !== $obj->get_embed_type() ) : ?>
					<div class="post-meta post-meta-social show-for-medium-up">
						<?php echo wp_kses_post( CST()->get_template_part( 'post/social-share', array( 'obj' => $obj ) ) ); ?>
					</div>
				<?php endif; ?>

			<?php endif; ?>

			<?php
			echo CST()->get_template_part( 'content-' . str_replace( 'cst_', '', get_post_type() ), array( 'obj' => $obj, 'is_main_query' => true ) );
if ( $sponsored ) { ?>
	</div>
	<?php }
if ( is_singular( array( 'cst_article', 'cst_gallery', 'cst_video' ) ) ) {
	echo wp_kses( CST()->get_template_part( 'post/post-recommendations-chartbeat', array( 'obj' => $obj ) ), CST()->recommendation_kses ); ?>
	<?php CST()->frontend->inject_flipp( $paged ); ?>
	<div id="taboola-below-article-thumbnails-<?php echo esc_attr( $obj->get_id() ); ?>" class="taboola-container-<?php echo esc_attr( $obj->get_id() ); ?> medium-12 columns ">
	</div>
<?php } ?>
		</article>

		<?php CST()->frontend->content_ad_injection( $paged ); ?>

		<?php if ( is_singular( array( 'cst_article', 'cst_gallery', 'cst_video' ) ) ) : ?>
		</div>
	<?php endif; ?>
<?php endif;
