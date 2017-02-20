<?php if ( ! empty( $is_main_query ) ) : ?>

	<?php if ( is_singular() ) : ?>
		<?php
		$media_type = $obj->get_featured_media_type();
		if ( 'image' === $media_type ) :
			CST()->featured_image_markup( $obj );
		elseif ( 'gallery' === $media_type && $gallery = $obj->get_featured_gallery() ) : ?>
			<div class="post-lead-media post-content columns medium-11 medium-offset-1 end">
				<?php echo do_shortcode( '[cst-content id="' . $gallery->get_id() . '"]' ); ?>
			</div>
		<?php elseif ( 'video' === $media_type ) : ?>
			<div class="post-lead-media post-content columns medium-11 medium-offset-1 end">
				<?php echo $obj->get_featured_video_embed(); ?>
			</div>
		<?php endif; ?>
		<div class="row">
			<?php echo CST()->get_template_part( 'post/feature-meta-byline', array( 'obj' => $obj ) ); ?>
			<div class="post-content columns small-12 end" itemprop="articleBody">
				<?php $obj->the_content(); ?>

			</div>
		</div>
	<?php else : ?>
		<?php echo CST()->get_template_part( 'post/title', $vars ); ?>
		<?php
		if ( $obj->get_excerpt() ) {
			echo CST()->get_template_part( 'post/post-excerpt', array( 'obj' => $obj ) );
		}
		if ( $obj->get_featured_image_id() ) {
			echo CST()->get_template_part( 'post/wire-featured-image', array( 'obj' => $obj ) );
		} ?>
	<?php endif; ?>

<?php endif;
