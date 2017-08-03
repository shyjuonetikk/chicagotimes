<?php if ( ! empty( $is_main_query ) ) { ?>

	<?php if ( is_singular() ) { ?>
		<?php echo wp_kses_post( CST()->get_template_part( 'post/title', $vars ) ); ?>

		<?php if ( is_singular() ) { ?>
			<div class="columns small-12 end">
				<div class="video-embed"><?php echo $obj->get_video_embed(); // Content escaped in Video::get_video_embed() ?></div>
			</div>
			<?php echo wp_kses_post( CST()->get_template_part( 'post/meta-byline', array( 'obj' => $obj ) ) ); ?>
			<?php if ( $description = $obj->get_video_description() ) { ?>
				<div class="post-content columns medium-12 end">
					<div class="video-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
				</div>
			<?php } ?>
		<?php } else { ?>
			<?php if ( $obj->get_featured_image_id() ) {
				echo wp_kses_post( CST()->get_template_part( 'post/wire-featured-image', array( 'obj' => $obj ) ) );
} else { ?>
				<div class="post-lead-media">
					<?php echo $obj->get_video_embed(); // Content escaped in Video::get_video_embed() ?>
				</div>
			<?php } ?>
		<?php } ?>
	<?php }
}
