<?php echo CST()->get_template_part( 'post/title', $vars ); ?>
<?php if ( ! empty( $is_main_query ) ) : ?>

	<?php if ( is_singular() ) : ?>
		<?php
		$media_type = $obj->get_featured_media_type();
		if ( 'image' === $media_type ) :
			CST()->featured_image_markup( $obj );
		elseif ( 'gallery' === $media_type && $gallery = $obj->get_featured_gallery() ) : ?>
			<div class="post-lead-media post-content columns small-12 end">
				<?php echo do_shortcode( '[cst-content id="' . $gallery->get_id() . '"]' ); ?>
			</div>
		<?php elseif ( 'video' === $media_type ) : ?>
			<div class="post-lead-media post-content columns small-12 end">
				<?php echo $obj->get_featured_video_embed(); ?>
			</div>
		<?php endif; ?>
		<?php echo CST()->get_template_part( 'post/meta-byline', array( 'obj' => $obj ) ); ?>
		<div class="post-content columns small-12 medium-8 p402_premium end" itemprop="articleBody">
		<?php
		CST()->frontend->inject_chatter_parameters( $obj );
		$yieldmo_tag = $obj->get_yieldmo_tag();
		if ( $yieldmo_tag ) {
			$yieldmo_printed_tag = CST()->yieldmo_tags->ym_get_demo_tag( $yieldmo_tag );
			esc_html_e( $yieldmo_printed_tag );
		}
		$obj->the_content();
		$user_logins = array();
		foreach ( $obj->get_authors() as $author ) {
			$user_logins[] = $author->get_user_login();
		}
		if ( in_array( 'associated-press', $user_logins ) ) { ?>
			<p class="post-copyright">Copyright <?php
			// Support for multiple years
			if ( date( 'Y' ) != $obj->get_post_date_gmt( 'Y' ) ) {
				echo esc_html( $obj->get_post_date_gmt( 'Y' ) ) . '-';
			}
			echo date( 'Y' ); ?> Associated Press. All rights reserved. This material may not be published, broadcast, rewritten, or redistributed.</p>
		<?php } ?>
		</div>
	<?php else : ?>
		<?php
		if ( $obj->get_excerpt() ) :
			echo CST()->get_template_part( 'post/post-excerpt', array( 'obj' => $obj ) );
		endif;
		if ( $obj->get_featured_image_id() ) {
			echo CST()->get_template_part( 'post/wire-featured-image', array( 'obj' => $obj ) );
		} ?>
	<?php endif; ?>

<?php endif;
