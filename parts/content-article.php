<?php if ( ! empty( $is_main_query ) ) { ?>

	<?php if ( is_singular() ) { ?>
		<?php echo wp_kses_post( CST()->get_template_part( 'post/title', $vars ) ); ?>
		<?php if ( $obj->get_sponsored_content() ) { ?>
			<div class="medium-7 columns end section-sponsor-banner">
				<h4 class="sponsored-notification">SPONSORED CONTENT</h4>
			</div>
		<?php } ?>
		<?php
		echo wp_kses_post( CST()->get_template_part( 'post/meta-top', array( 'obj' => $obj, 'is_main_query' => true ) ) );
		$media_type = $obj->get_featured_media_type();
		if ( 'image' === $media_type ) {
			CST()->featured_image_markup( $obj );
		} elseif ( 'gallery' === $media_type && $gallery = $obj->get_featured_gallery() ) { ?>
			<div class="post-lead-media post-content columns small-12 end">
				<?php echo do_shortcode( '[cst-content id="' . $gallery->get_id() . '"]' ); ?>
			</div>
		<?php } elseif ( 'video' === $media_type ) { ?>
			<div class="post-lead-media post-content columns small-12 end">
				<?php
				echo wp_kses( $obj->get_featured_video_embed(), CST()->sendtonews_kses );
				?>
			</div>
		<?php } ?>
		<?php echo wp_kses_post( CST()->get_template_part( 'post/meta-byline', array( 'obj' => $obj ) ) ); ?>
		<div class="post-content columns small-12 large-12 p402_premium end" itemprop="articleBody">
		<?php
		CST()->frontend->inject_chatter_parameters( $obj );
		$yieldmo_tag = $obj->get_yieldmo_tag();
		if ( $yieldmo_tag ) {
			$yieldmo_printed_tag = CST()->yieldmo_tags->ym_get_demo_tag( $yieldmo_tag );
			echo esc_html( $yieldmo_printed_tag );
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
			echo esc_attr( date( 'Y' ) ); ?> Associated Press. All rights reserved. This material may not be published, broadcast, rewritten, or redistributed.</p>
		<?php } ?>
		</div>
	<?php } else { ?>
		<div class="section-front small-12">
		<?php
		if ( $obj->get_featured_image_id() ) { ?>
			<div class="section-image small-4">
				<?php if ( is_sticky() && ! is_singular( ) ) { echo wp_kses_post( CST()->get_template_part( 'post/meta-top', array( 'obj' => $obj, 'is_main_query' => true, 'developing' => true ) ) ); } ?>
				<?php echo wp_kses_post( CST()->get_template_part( 'post/wire-featured-image', array( 'obj' => $obj ) ) ); ?>
			</div>
		<?php } ?>
			<div class="section-title small-8">
				<?php echo wp_kses_post( CST()->get_template_part( 'post/meta-top', array( 'obj' => $obj, 'is_main_query' => true ) ) ); ?>
				<?php echo wp_kses_post( CST()->get_template_part( 'post/title', $vars ) ); ?>
				<?php if ( $obj->get_excerpt() ) {
					echo wp_kses_post( CST()->get_template_part( 'post/post-excerpt', array( 'obj' => $obj ) ) );
				} ?>
			</div>
		</div>
	<?php } ?>

<?php }
