<?php $image_size = is_tax() ? 'chiwire-header-small' : 'chiwire-article'; ?>
<div class="post-lead-media <?php if ( $obj->get_post_type() != 'cst_article' ) { echo 'hover-state'; } ?>">
	<a href="<?php $obj->the_permalink(); ?>" <?php if ( 'cst_link' === $obj->get_post_type() ) { echo 'target="_blank"'; } ?>>
		<?php echo $obj->get_featured_image_html( $image_size ); ?>
		<i class="fa fa-<?php echo esc_attr( $obj->get_font_icon() ); ?>"></i>
	</a>
</div>