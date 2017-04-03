<div class="post-meta post-meta-byline columns small-12 large-12 end">
	<div class="row">

		<div class="large-5 medium-4 small-12 columns author-meta-box">
			<?php
			$byline = $obj->get_byline();
			if ( ! $byline ) {
				foreach ( $obj->get_authors() as $i => $author ) : ?>
					<div class="post-meta-author"><a href="<?php echo esc_url( $author->get_permalink() ); ?>" data-on="click" data-event-category="author-byline" data-event-action="view author"><?php echo esc_html( $author->get_display_name() ); ?></a></div>
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
							$parts[] = '<a href="' . esc_url( sprintf( 'https://twitter.com/intent/user?screen_name=%s', $twitter_username ) ) . '">@' . esc_html( $twitter_username ) . '</a>';
						}
						if ( $email_address ) {
							$parts[] = '<a href="mailto:' . sanitize_email( $email_address ) . '">' . esc_html__( 'email', 'chicagosuntimes' ) . '</a>';
						}
						echo '<div class="post-meta-author-contact">' . implode( ' | ', $parts ) . '</div>';
					} ?>
				<?php endforeach; ?>
			<?php } else { ?>
				<div class="post-meta-author byline-author"><?php echo esc_html( $byline ); ?></div>
			<?php } ?>
		</div>
		<?php
		if ( is_singular() ) {
			if ( $obj->get_sections() ) {
				$post_sections = $obj->get_sections();
				foreach ( $post_sections as $section_check ) {
					if ( 'entertainment' === $section_check->slug ) {
						CST()->frontend->inject_newsletter_signup( $section_check->slug );
						break;
					}

					if ( 'news' === $section_check->slug ) {
						CST()->frontend->inject_newsletter_signup( $section_check->slug );
						break;
					}

					if ( 'sports' === $section_check->slug ) {
						CST()->frontend->inject_newsletter_signup( $section_check->slug );
						break;
					}
				}
			}
		}
?>
	</div>
</div>
