<div class="post-lead-media cst_feature-media small-12 medium-4">
	<a href="<?php $obj->the_permalink(); ?>" <?php if ( 'cst_link' === $obj->get_post_type() ) { echo 'target="_blank"'; } ?>>
		<?php echo $obj->get_featured_image_html( 'chiwire-header-small' ); ?>
		<i class="fa fa-<?php echo esc_attr( $obj->get_font_icon() ); ?>"></i>
	</a>
</div>
