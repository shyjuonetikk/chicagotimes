<?php

if ( ! $obj ) {
	return;
}

$classes = 'post-meta-bottom post-meta';
if ( 'cst_feature' === $obj->get_post_type() ) {
	$classes .= ' cst_feature-meta-bottom';
}
if ( is_singular() ) {
	$classes .= ' columns small-12 end';
}
if ( ! is_singular() ) {
	$classes .= ' show-for-medium-up';
}
?>
<div class="<?php echo esc_attr( $classes ); ?>">
	<?php if ( ! is_singular() ) : ?>
	<div class="left">
		<i class="post-type fa fa-<?php echo esc_attr( $obj->get_font_icon() ); ?>"></i>
	</div>
	<?php echo wp_kses_post( CST()->get_template_part( 'post/social-share', array( 'obj' => $obj ) ) ); ?>
	<?php endif; ?>

	<div style="clear:both;"></div>
</div>
<?php if ( is_singular() && ! is_preview() && ! in_array( $obj->get_post_type(), array( 'cst_liveblog', 'cst_embed' ) ) ) : ?>
	<div class="columns small-12 end">
		<?php echo CST()->frontend->inject_public_good_markup( $obj ); ?>
		<div id="addthis-<?php the_id(); ?>" class="addthis_toolbox addthis_default_style addthis_32x32_style"  addthis:url="<?php echo esc_url( $obj->get_share_link() ); ?>" addthis:title="<?php echo esc_attr( $obj->get_twitter_share_text() ); ?>">
			<a class="addthis_button_facebook" addthis:url="<?php echo esc_url( $obj->get_share_link() ); ?>" data-on="click" data-event-category="add-this" data-event-action="-facebook" addthis:title="<?php echo esc_attr( $obj->get_title() ); ?>"></a>
			<a class="addthis_button_twitter" addthis:url="<?php echo esc_url( $obj->get_share_link() ); ?>" data-on="click" data-event-category="add-this" data-event-action="twitter" addthis:title="<?php echo esc_attr( $obj->get_twitter_share_text() ); ?>"></a>
			<a class="addthis_button_email" addthis:url="<?php echo esc_url( $obj->get_share_link() ); ?>" data-on="click" data-event-category="add-this" data-event-action="email" addthis:title="<?php echo esc_attr( $obj->get_title() ); ?>"></a>
			<a class="addthis_button_compact"></a>
		</div>
		<hr class="end-of-post-line">
	</div>
<?php endif;

