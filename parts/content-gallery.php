<?php echo CST()->get_template_part( 'post/title', $vars ); ?>

<?php if ( ! empty( $is_main_query ) ) : ?>

	<?php if ( is_singular() ) : ?>
		<div class="post-lead-media post-content columns medium-11 medium-offset-1 end">
			<?php echo do_shortcode( '[cst-content id="' . $obj->get_id() . '"]' ); ?>
		</div>
		<?php echo CST()->get_template_part( 'post/meta-byline', array( 'obj' => $obj ) ); ?>
		<?php if ( $obj->get_content() ) : ?>
		<div class="post-content columns medium-9 medium-offset-1 end">
			<script>
				window.SECTIONS_FOR_YIELD_MO = <?php echo json_encode( CST_Frontend::$post_sections ); ?>;
			</script>
			<?php $obj->the_content(); ?>
		</div>
		<?php endif; ?>
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