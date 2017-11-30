<?php $image_size = ( is_tax() || is_author() ) ? 'chiwire-header-small' : 'chiwire-article'; ?>
<?php $image_size = ( \CST\CST_Section_Front::get_instance()->is_sports_or_child( get_queried_object_id() ) && is_tax( 'cst_section' ) ) ? 'chiwire-section-medium' : $image_size; ?>
<?php if ( $obj->get_sponsored_content() ) { ?>
<div class="section-sponsor-banner">
	<h4 class="sponsored-notification">SPONSORED</h4>
</div>
<?php } ?>
<div class="post-lead-media <?php if ( 'cst_article' !== $obj->get_post_type() ) { echo 'hover-state'; } ?>">
	<a href="<?php $obj->the_permalink(); ?>" <?php if ( 'cst_link' === $obj->get_post_type() ) { echo 'target="_blank"'; } ?>>
		<?php echo $obj->get_featured_image_html( $image_size ); ?>
		<i class="fa fa-<?php echo esc_attr( $obj->get_font_icon() ); ?>"></i>
	</a>
</div>
