<?php if ( ! empty( $is_main_query ) ) { ?>

	<?php if ( is_singular() ) {
		echo wp_kses_post( CST()->get_template_part( 'post/meta-top', array( 'obj' => $obj, 'is_main_query' => true ) ) );
		echo wp_kses_post( CST()->get_template_part( 'post/title', $vars ) );
		?>
		<div class="post-lead-media post-content columns small-12 end">
			<?php echo do_shortcode( '[cst-content id="' . $obj->get_id() . '"]' ); ?>
		</div>
		<?php echo wp_kses_post( CST()->get_template_part( 'post/meta-byline', array( 'obj' => $obj ) ) ); ?>
		<?php if ( $obj->get_content() ) { ?>
			<div class="post-content columns small-12 end">
				<script>
                  window.SECTIONS_FOR_YIELD_MO = <?php echo wp_json_encode( CST_Frontend::$post_sections ); ?>;
				</script>
				<?php $obj->the_content(); ?>
			</div>
		<?php } ?>
	<?php } else { ?>
		<div class="section-front small-12">

			<?php
			if ( $obj->get_featured_image_id() ) { ?>
				<div class="section-image small-4">
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
