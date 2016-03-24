<?php echo CST()->get_template_part( 'post/title', $vars ); ?>
<?php if ( ! empty( $is_main_query ) ) : ?>

	<?php if ( is_singular() ) : ?>
		<?php
		if ( 'image' == $obj->get_featured_media_type() ) :
			$featured_image_id = $obj->get_featured_image_id();
			if ( $attachment = \CST\Objects\Attachment::get_by_post_id( $featured_image_id )  ) : ?>
			<div class="post-lead-media columns medium-11 medium-offset-1 end">
				<?php echo $attachment->get_html( 'cst-article-featured' );
				if ( $caption = $attachment->get_caption() ) : ?>
				<div class="image-caption"><?php echo wpautop( esc_html( $caption ) ); ?></div>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		<?php elseif ( 'gallery' == $obj->get_featured_media_type() && $gallery = $obj->get_featured_gallery() ) : ?>
			<div class="post-lead-media post-content columns medium-11 medium-offset-1 end">
				<?php echo do_shortcode( '[cst-content id="' . $gallery->get_id() . '"]' ); ?>
			</div>
		<?php endif; ?>
		<?php echo CST()->get_template_part( 'post/meta-byline', array( 'obj' => $obj ) ); ?>
		<div class="post-content columns medium-11 medium-offset-1 p402_premium end" itemprop="articleBody">
		<?php 
			if ( $agg_primary_section = $obj->get_primary_section() ) : 
				if( $agg_primary_section->parent != 0 ) {
					$agg_primary_section = $obj->get_grandchild_parent_section();
				}
				$agg_primary_section_slug = $agg_primary_section->slug;
			else :
				$agg_primary_section_slug = 'politics';
			endif;
		?>
		<script>
          window.SECTIONS_FOR_YIELD_MO = <?php echo json_encode( CST_Frontend::$post_sections ); ?>;
          window.SECTIONS_FOR_AGGREGO_CHATTER = <?php echo json_encode( $agg_primary_section_slug ); ?>;
        </script>
         <div id="z64aff56b-2200-4008-a1ce-12f9d32c7205" style='display:none' ></div>
			<?php $obj->the_content(); ?>
			<?php
			$user_logins = array();
			foreach( $obj->get_authors() as $author ) {
				$user_logins[] = $author->get_user_login();
			}
			if ( in_array( 'associated-press', $user_logins ) ) : ?>
			<p class="post-copyright">Copyright <?php
			// Support for multiple years
			if ( date( 'Y' ) != $obj->get_post_date_gmt( 'Y' ) ) {
				echo esc_html( $obj->get_post_date_gmt( 'Y' ) ) . '-';
			}
			echo date( 'Y' ); ?> Associated Press. All rights reserved. This material may not be published, broadcast, rewritten, or redistributed.</p>
			<?php endif; ?>
		</div>
	<?php else : ?>
		<?php
			if ( $obj->get_excerpt() ) :
				echo CST()->get_template_part( 'post/post-excerpt', array( 'obj' => $obj ) );
			endif;
			?>
		<?php if ( $obj->get_featured_image_id() ) {
			echo CST()->get_template_part( 'post/wire-featured-image', array( 'obj' => $obj ) );
		} ?>
	<?php endif; ?>

<?php endif; ?>