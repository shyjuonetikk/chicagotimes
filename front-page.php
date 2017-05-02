<?php get_header(); ?>
	<div class="homepage-content">
		<div class="row">
			<div class="columns small-12">
				<div class="cst-ad-container dfp dfp-centered"><img src="http://placehold.it/970x90/6060e5/130100&amp;text=[ad-will-be-responsive]"></div>
			</div>
		</div>
		<div class="row">
			<div class="large-12 content-wrapper">
				<div class="large-12 columns dfp-mobile-leaderboard show-for-small-only">
					<?php if ( ! WP_DEBUG ) { get_template_part( 'parts/dfp/homepage/dfp-mobile-leaderboard' ); } ?>
				</div>
			</div>
		</div>
		<?php
		do_action( 'above-homepage-headlines' );
		if ( is_active_sidebar( 'homepage_headlines' ) ) :
			dynamic_sidebar( 'homepage_headlines' );
		endif;
		?>
		<div class="large-12 dfp-atf-leaderboard">
			<?php echo wp_kses( CST()->dfp_handler->unit( 3, 'div-gpt-super-leaderboard', 'dfp dfp-super-leaderboard dfp-centered' ),
				CST()->dfp_kses
			); ?>
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
			<div class="large-12 dfp-atf-leaderboard">
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
	</div>
<?php get_template_part( 'parts/homepage/footer' ); ?>
<?php get_footer();
