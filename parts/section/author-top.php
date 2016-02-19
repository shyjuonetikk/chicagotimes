<a id="newsfeed-logo" href="<?php echo home_url('/'); ?>">
	<?php get_template_part( 'parts/images/main-site-logo'); ?>
</a>
<?php $author = new \CST\Objects\User( get_queried_object_id() ) ?>

<div id="section-top" class="author">
	<div class="row">
		<div class="small-2 columns">
			<?php echo $author->get_avatar( 80 ); ?>
		</div>
		<div class="small-10 columns">
			<h2>
				<?php echo esc_html( $author->get_display_name() ); ?>
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
		<?php if ( $description = $author->get_description() ) : ?>
		<div class="small-12 columns">
			 <small class="author-bio"><?php echo wp_kses_post( wpautop( $description ) ); ?></small>
		</div>
		<?php endif; ?>
	</div>
</div>
