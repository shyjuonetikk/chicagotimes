<?php get_header(); ?>
<div class="homepage-content">
	<?php
	do_action( 'above-homepage-headlines' );
	if ( is_active_sidebar( 'homepage_headlines' ) ) :
		dynamic_sidebar( 'homepage_headlines' );
	endif;
	?>
</div>
<div class="large-12">
	<?php echo wp_kses( CST()->dfp_handler->unit( 3, 'div-gpt-super-leaderboard', 'dfp dfp-super-leaderboard dfp-centered' ),
		CST()->dfp_kses
	); ?>
</div>
<div class="row">
	<div class="small-12 content-wrapper featured-story columns">
		<?php
		if ( is_active_sidebar( 'homepage_featured_story' ) ) :
			dynamic_sidebar( 'homepage_featured_story' );
		endif;
		?>
	</div>
	<div class="columns">
		<hr class="before">
		<h2 class="section-title"><span><?php esc_html_e( 'More From', 'chicagosuntimes' ); ?></span></h2>
		<hr/>
	</div>
</div>
<!-- circular flipp -->
	<div class="row">
		<?php
		if ( is_active_sidebar( 'undermorefrom' ) ) :
			dynamic_sidebar( 'undermorefrom' );
		endif;
		?>
	</div>
	<div>
		<div class="large-12">
			<?php echo wp_kses( CST()->dfp_handler->unit( 4, 'div-gpt-super-leaderboard', 'dfp dfp-super-leaderboard dfp-centered' ),
				CST()->dfp_kses
			); ?>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns content-wrapper cw">
			<?php get_template_part( 'parts/homepage/column-wells' ); ?>
		</div>
	</div>
	<div class="other-stories show-for-large-up">
		<hr>
		<h3>[test]Trending in the Chicago Sun-Times (Chartbeat)</h3>
		<div id="root"></div>
		<script type="text/javascript" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/js/main.a7ae93e0-cb-dev-test.js' ); ?>"></script>
	</div>
</div>
<?php get_template_part( 'parts/homepage/footer' ); ?>
<?php get_footer();
