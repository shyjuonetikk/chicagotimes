<div class="post-meta post-meta-byline columns medium-11 medium-offset-1 end">
<?php
	$byline = $obj->get_byline();
	if( ! $byline ) {
		foreach( $obj->get_authors() as $i => $author ) : ?>
	<div class="post-meta-author"><a href="<?php echo esc_url( $author->get_permalink() ); ?>"><?php echo esc_html( $author->get_display_name() ); ?></a></div>
	<?php
		if( $author->get_type() == 'guest-author' ) {
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
<?php
	if ( is_singular() ) :
		if ( $obj->get_sections() ) :
			$post_sections = $obj->get_sections();
			foreach( $post_sections as $section_check ) :
				if( $section_check->slug == 'entertainment' ) :
					echo CST()->get_template_part( 'post/signup-entertainment-newsletter' ) . '</div>';
					return;
				endif;

				if( $section_check->slug == 'news' ) :
					echo CST()->get_template_part( 'post/signup-politics-newsletter' ) . '</div>';
					return;
				endif;

				if( $section_check->slug == 'sports' ) :
					echo CST()->get_template_part( 'post/signup-sports-newsletter' ) . '</div>';
					return;
				endif;
			endforeach;
		endif;
	endif;
?>
</div>