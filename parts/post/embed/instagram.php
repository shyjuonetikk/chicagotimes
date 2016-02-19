<?php $embed_data = $obj->get_embed_data();

	if ( ! $embed_data ) {
		return;
	}

?>
<?php
	/**
	 * Sidebar
	 */
	if ( is_singular() && empty( $is_main_query ) ) : ?>
	<?php $embed_data = $obj->get_embed_data(); ?>
	<div class="post-meta post-meta-top">
		<div class="post-embed-source">
			<a target="_blank" href="<?php echo esc_url( $embed_data->author_url ); ?>" class="tweet-display-name"><?php echo esc_html( $embed_data->author_name ); ?></a>
		</div>
	</div>
	<h3><a href="<?php $obj->the_permalink(); ?>"><?php echo esc_html( $embed_data->title ); ?></a></h3>
<?php elseif ( ! empty( $is_main_query ) ) :

	$classes = array(
		'post-content',
		'embed-content'
		);
	if ( is_singular() ) {
		$classes[] = 'columns medium-9 medium-offset-1 end';
	}
	?>

	<?php
	$photo_classes = array(
		'post-lead-media',
		);
	if ( is_singular() ) {
		$photo_classes[] = 'columns medium-9 medium-offset-1 end';
	} else {
		$photo_classes[] = 'hover-state';
	}
	?>
	<div class="<?php echo esc_attr( implode( ' ', $photo_classes ) ); ?>">
		<?php if ( 'photo' == $embed_data->type ) {
			if ( is_singular() ) {
				$photo_url = jetpack_photon_url( $embed_data->url, array( 'fit' => '543,9999' ) );
			} else {
				$photo_url = jetpack_photon_url( $embed_data->url, array( 'resize' => '570,260' ) );
			}
			?>
			<a href="<?php $obj->the_permalink(); ?>"><img src="<?php echo esc_url( $photo_url ); ?>" />
			<?php if ( ! is_singular() ) : ?>
				<i class="fa fa-instagram"></i>
			<?php endif; ?>
			</a>
		<?php } elseif ( ( 'video' == $embed_data->type ) && ! is_singular() ) {
			$photo_url = jetpack_photon_url( $embed_data->thumbnail_url, array( 'resize' => '570,260' ) );?>
			<a href="<?php $obj->the_permalink(); ?>"><img src="<?php echo esc_url( $photo_url ); ?>" /><i class="fa fa-instagram"></i></a>

		<?php } else {
			echo $embed_data->html;
		} ?>
	</div>

	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<div class="instagram-body">
			<div class="instagram-byline">
				<i class="fa fa-instagram"></i> <a target="_blank" href="<?php echo esc_url( $embed_data->author_url ); ?>"><?php echo esc_html( $embed_data->author_name ); ?></a>
			</div>
			<?php if ( ! is_singular() ) : ?>
				<a href="<?php $obj->the_permalink(); ?>">
			<?php endif; ?>
			<?php echo wpautop( esc_html( $embed_data->title ) ); ?>
			<?php if ( ! is_singular() ) : ?>
				</a>
			<?php endif; ?>
		</div>

	</div>

<?php endif; ?>