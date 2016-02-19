<?php echo CST()->get_template_part( 'post/title', $vars ); ?>

<?php if ( ! empty( $is_main_query ) ) : ?>

	<?php if ( is_singular() ) : ?>
		<div class="columns medium-11 medium-offset-1 end">
			<div class="video-embed"><?php echo $obj->get_video_embed(); ?></div>
		</div>
		<?php echo CST()->get_template_part( 'post/meta-byline', array( 'obj' => $obj ) ); ?>
		<?php if ( $description = $obj->get_video_description() ) : ?>
		<div class="post-content columns medium-9 medium-offset-1 end">
			<div class="video-description"><?php echo wpautop( esc_html( $description ) ); ?></div>
		</div>
		<?php endif; ?>
	<?php else : ?>
		<?php if ( $obj->get_featured_image_id() ) :
			echo CST()->get_template_part( 'post/wire-featured-image', array( 'obj' => $obj ) );
		else : ?>
		<div class="post-lead-media">
			<?php echo $obj->get_video_embed(); ?>
		</div>
		<?php endif; ?>
	<?php endif; ?>

<?php endif; ?>