<?php $embed_data = $obj->get_embed_data();

	if ( $obj->is_embed_data_errored() ) {
		return;
	}
?>
<?php
	/**
	 * Sidebar
	 */
	if ( is_singular() && empty( $is_main_query ) ) : ?>
	<div class="post-meta post-meta-top">
		<div class="post-embed-source">
			<a href="<?php echo esc_url( sprintf( 'https://twitter.com/intent/user?screen_name=%s', $embed_data->user->screen_name ) ); ?>" target="_blank">@<?php echo esc_html( $embed_data->user->screen_name ); ?></a>
		</div>
	</div>
	<h3><a href="<?php $obj->the_permalink(); ?>"><?php echo esc_html( $embed_data->text ); ?></a></h3>
<?php elseif ( ! empty( $is_main_query ) ) :

	$classes = array(
		'post-content',
		'embed-content'
		);
	if ( is_singular() ) {
		$classes[] = 'columns medium-9 medium-offset-1 end';
	}
	?>

	<?php if ( ! empty( $embed_data->extended_entities->media ) ) :
		$media = array_shift( $embed_data->extended_entities->media );

		if ( 'photo' == $media->type ) :
			$photo_classes = array(
				'post-lead-media',
				);
			if ( is_singular() ) {
				$photo_classes[] = 'columns medium-9 medium-offset-1 end';
				$photo_url = jetpack_photon_url( $media->media_url, array( 'fit' => '543,9999' ) );
			} else {
				$photo_classes[] = 'hover-state';
				$photo_url = jetpack_photon_url( $media->media_url, array( 'resize' => '570,260' ) );
			}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $photo_classes ) ); ?>">
			<a href="<?php $obj->the_permalink(); ?>"><img src="<?php echo esc_url( $photo_url ); ?>" />
			<?php if ( ! is_singular() ) : ?>
				<i class="fa fa-twitter"></i>
			<?php endif; ?>
			</a>
		</div>
	<?php endif; endif; ?>

	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

		<img class="left show-for-medium-up tweet-avatar" src="<?php echo esc_url( $embed_data->user->profile_image_url ); ?>" width="48" height="48" />

		<div class="tweet-byline">
			<i class="fa fa-twitter"></i> <a href="<?php echo esc_url( sprintf( 'https://twitter.com/intent/user?screen_name=%s', $embed_data->user->screen_name ) ); ?>" class="tweet-display-name"><?php echo esc_html( $embed_data->user->name ); ?></a> <a href="<?php echo esc_url( sprintf( 'https://twitter.com/intent/user?screen_name=%s', $embed_data->user->screen_name ) ); ?>" class="tweet-username">@<?php echo esc_html( $embed_data->user->screen_name ); ?></a>
		</div>

		<div class="tweet-body">
			<?php if ( is_singular() ) : ?>
				<?php echo wpautop( make_clickable( esc_html( $embed_data->text ) ) ); ?>
			<?php else: ?>
			<a href="<?php $obj->the_permalink(); ?>"><?php echo wpautop( esc_html( $embed_data->text ) ); ?></a>
			<?php endif; ?>
		</div>

		<div class="post-meta-side right show-for-small-only">
			<a class="post-social reply" href="<?php echo esc_url( sprintf( 'https://twitter.com/intent/tweet?in_reply_to=%d', $embed_data->id_str ) ); ?>"><i class="fa fa-reply"></i></a>
			<a class="post-social retweet" href="<?php echo esc_url( sprintf( 'https://twitter.com/intent/retweet?tweet_id=%d', $embed_data->id_str ) ); ?>"><i class="fa fa-retweet"></i></a>
			<a class="post-social favorite" href="<?php echo esc_url( sprintf( 'https://twitter.com/intent/favorite?tweet_id=%d', $embed_data->id_str ) ); ?>"><i class="fa fa-star"></i></a>
		</div>

	</div>

	<?php if ( is_singular() ) : ?>
	<div class="columns medium-9 medium-offset-1 end">
		<div class="post-meta post-meta-social">
			<?php echo CST()->get_template_part( 'post/social-share', array( 'obj' => $obj ) ); ?>
		</div>
	</div>
	<?php endif; ?>

<?php endif;

