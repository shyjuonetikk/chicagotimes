<div class="post-meta post-meta-byline columns small-12 end">
	<?php
	$byline = $obj->get_byline();
	if ( ! $byline ) {
		foreach ( $obj->get_authors() as $i => $author ) : ?>
			<div class="post-meta-author"><a href="<?php echo esc_url( $author->get_permalink() ); ?>"><?php echo esc_html( $author->get_display_name() ); ?><?php echo esc_html( ' | ' . $obj->get_persistent_date() ); ?></a></div>
			<?php
			if ( 'guest-author' === $author->get_type() ) {
				$twitter_username = $author->get_guest_twitter_username();
			} else {
				$twitter_username = $author->get_twitter_username();
			}

			$email_address = $author->get_email();
			if ( $twitter_username || $email_address ) {
				$parts = array();
				if ( $twitter_username ) {
					$parts[] = '<a href="' . esc_url( sprintf( 'https://twitter.com/intent/user?screen_name=%s', $twitter_username ) ) . '">Follow on Twitter</a>';
				}
				if ( $email_address ) {
					$parts[] = '<a href="mailto:' . sanitize_email( $email_address ) . '">Email</a>';
				}
				echo '<div class="post-meta-author-contact">' . implode( ' | ', $parts ) . '</div>';
			} ?>
		<?php endforeach; ?>
	<?php } else { ?>
		<div class="post-meta-author byline-author"><?php echo esc_html( $byline ); ?><?php echo esc_html( '| ' . $obj->get_persistent_date() ); ?></div>
	<?php } ?>
</div>
