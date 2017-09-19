<div class="post-gallery" id="post-gallery-<?php echo (int) $obj->get_id(); ?>">
<?php $gallery_lead_image_size = is_singular( 'cst_feature' ) ? 'cst-feature-gallery-lead' : 'cst-article-featured'; ?>
	<?php if ( $src = $obj->get_featured_image_url( $gallery_lead_image_size ) ) : ?>
	<div class="post-gallery-lead-image-wrap">
		<img src="<?php echo esc_url( $src ); ?>" class="post-gallery-lead-image" />
		<a href="#" class="post-gallery-open-button"><i class="fa fa-photo"></i>&nbsp;<?php echo esc_html( 'Gallery', 'chicagosuntimes' ); ?></a>
	</div>
	<?php endif; ?>

	<div class="slides" data-gallery-title="<?php echo esc_html( $obj->the_title() ); ?>">
		<?php $gallery_items = $obj->get_gallery_image_ids();
		?>
		<?php foreach ( $gallery_items as $slide_number => $image_id ) :
			$image = get_post( $image_id );
			if ( ! $image ) {
				continue;
			}
			$attachment = new \CST\Objects\Attachment( $image );
			$orientation = $attachment->get_orientation();
			if ( 'vertical' == $orientation ) {
				$desktop_src = $attachment->get_url( 'cst-gallery-desktop-vertical' );
				$mobile_src = $attachment->get_url( 'cst-gallery-mobile-vertical' );
			} else {
				$desktop_src = $attachment->get_url( 'cst-gallery-desktop-horizontal' );
				$mobile_src = $attachment->get_url( 'cst-gallery-mobile-horizontal' );
			}

			$caption = $attachment->get_caption();
			$slide_url = $obj->get_permalink() . '#slide-' . $slide_number;
		?>
		<div class="slide" data-image-desktop-src="<?php echo esc_url( $desktop_src ); ?>" data-image-mobile-src="<?php echo esc_url( $mobile_src ); ?>" data-image-caption="<?php echo esc_attr( $caption ); ?>" data-slide-url="<?php echo esc_url( $slide_url ); ?>"></div>
		<?php endforeach; ?>
	</div>
</div>
