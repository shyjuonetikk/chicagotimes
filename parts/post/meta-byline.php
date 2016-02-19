<div class="post-meta post-meta-byline columns medium-11 medium-offset-1 end">
	<?php foreach( $obj->get_authors() as $i => $author ) : ?>
	<div class="post-meta-author"><a href="<?php echo esc_url( $author->get_permalink() ); ?>"><?php echo esc_html( $author->get_display_name() ); ?></a></div>
	<?php
		$twitter_username = $author->get_twitter_username();
		$email_address = $author->get_email();
		if ( $twitter_username || $email_address ) {
			$parts = array();
			if ( $twitter_username ) {
				$parts[] = '<a href="' . esc_url( sprintf( 'https://twitter.com/intent/user?screen_name=%s', $twitter_username ) ) . '">@' . esc_html( $twitter_username ) . '</a>';
			}
			if ( $email_address ) {
				$parts[] = '<a href="mailto:' . sanitize_email( $email_address ) . '">' . esc_html__( 'email', 'chicagosuntimes' ) . '</a>';
			}
			echo '<div class="post-meta-author-contact">' . implode( ' | ', $parts ) . '</div>';
		} ?>
	<?php endforeach; ?>
</div>