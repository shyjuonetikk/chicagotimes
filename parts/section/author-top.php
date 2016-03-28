<a id="newsfeed-logo" href="<?php echo home_url('/'); ?>">
	<?php get_template_part( 'parts/images/main-site-logo'); ?>
</a>
<?php $author = new \CST\Objects\User( get_queried_object_id() ) ?>
<?php
$author_avatar_html = false;
$author_description = false;
$author_twitter = false;
if ( is_a( $author, 'CST\Objects\User' ) ) {
	if ( $author->is_cst_author() && $author->get_id() ) {
		$author_avatar_html  = $author->get_avatar( 80 );
		$author_display_name = $author->get_display_name();
		$author_description  = $author->get_description();
		$author_twitter      = $author->get_twitter_username();
		$author_email        = $author->get_email();
	} else {
		global $coauthors_plus, $author_name;
		$author              = $coauthors_plus->get_coauthor_by( 'login', $author_name );
		$guest_author        = $coauthors_plus->get_coauthor_by( 'ID', $author->ID );
		$author_avatar_html  = coauthors_get_avatar( $guest_author, 80 );
		$author_display_name = $author->user_nicename;
		$author_description  = $author->description;
		$author_twitter      = $guest_author->twitter;
		$author_email        = $guest_author->user_email;
	}
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
				<?php if ( $author_twitter ) : ?>
				<span class="author-twitter"><i class="fa fa-twitter"></i>
					<a href="<?php echo esc_url( sprintf( 'https://twitter.com/%s', $author_twitter ) ); ?>">
					<?php echo esc_html( '@' . $author_twitter ); ?>
					</a>
				</span>
				<?php endif; ?>
				<?php if ( $author_email ) : ?>
				<span class="author-email"><i class="fa fa-envelope"></i>
					<a href="<?php echo esc_attr( 'mailto:' . $author_email ); ?>">
					<?php echo esc_html( $author_email ); ?>
					</a>
				</span>
				<?php endif; ?>
			</p>
		</div>
		<?php if ( $author_description ) : ?>
		<div class="small-12 columns">
			 <small class="author-bio"><?php echo wp_kses_post( wpautop( $author_description ) ); ?></small>
		</div>
		<?php endif; ?>
	</div>
</div>
