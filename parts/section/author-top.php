<a id="newsfeed-logo" href="<?php echo home_url('/'); ?>">
	<?php get_template_part( 'parts/images/main-site-logo'); ?>
</a>
<?php $author = new \CST\Objects\User( get_queried_object_id() ) ?>
<?php
if ( null === $author->get_id() ) {
	global $coauthors_plus, $author_name;
	$author = $coauthors_plus->get_coauthor_by( 'login', $author_name );
	$author_avatar_html = $coauthors_plus->guest_authors->get_guest_author_thumbnail( $author );
	$author_display_name = $author->display_name;
	$author_description = $author->description;
	$author_fields = $coauthors_plus->guest_authors->get_guest_author_fields( 'social' );
	$author_twitter = $coauthors_plus->guest_authors->get_post_meta_key( 'twitter' );
	
} else {
	$author_avatar_html = $author->get_avatar( 80 );
	$author_display_name = $author->get_display_name();
	$author_description = $author->get_description();
	$author_twitter = $author->get_twitter_username();
}
?>
<div id="section-top" class="author">
	<div class="row">
		<div class="small-2 columns">
			<?php echo $author_avatar_html; ?>
		</div>
		<div class="small-10 columns">
			<h2>
				<?php echo esc_html( $author_display_name ); ?>
			</h2>
			<p>
				<?php if ( $username = $author->get_twitter_username() ) : ?>
				<span class="author-twitter"><i class="fa fa-twitter"></i>
					<a href="<?php echo esc_url( sprintf( 'https://twitter.com/%s', $username ) ); ?>">
					<?php echo esc_html( '@' . $username ); ?>
					</a>
				</span>
				<?php endif; ?>
				<?php if ( $email = $author->get_email() ) : ?>
				<span class="author-email"><i class="fa fa-envelope"></i>
					<a href="<?php echo esc_attr( 'mailto:' . $email ); ?>">
					<?php echo esc_html( $email ); ?>
					</a>
				</span>
				<?php endif; ?>
			</p>
		</div>
		<?php if ( $description = $author_description ) : ?>
		<div class="small-12 columns">
			 <small class="author-bio"><?php echo wp_kses_post( wpautop( $description ) ); ?></small>
		</div>
		<?php endif; ?>
	</div>
</div>
