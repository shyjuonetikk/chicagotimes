<?php get_header(); ?>
<?php
if ( is_active_sidebar( 'homepage_breaking_news' ) ) :
	dynamic_sidebar( 'homepage_breaking_news' );
endif;
?>
<div class="homepage-content">
	<div class="row">
		<div class="large-12 content-wrapper">
			<?php get_template_part( 'parts/dfp/homepage/dfp-super-leaderboard' ); ?>
			<?php get_template_part( 'parts/dfp/homepage/dfp-billboard' ); ?>
			<?php get_template_part( 'parts/dfp/homepage/dfp-sbb' ); ?>
			<div class="large-12 columns dfp-mobile-leaderboard show-for-small-only">
				<?php get_template_part( 'parts/dfp/homepage/dfp-mobile-leaderboard' ); ?>
			</div>
		</div>
	</div>
	<?php
	do_action( 'above-homepage-headlines' );
	if ( is_active_sidebar( 'homepage_headlines' ) ) :
		dynamic_sidebar( 'homepage_headlines' );
	endif;
	?>
	<div class="large-12 columns content-wrapper">
		<?php
		if ( is_active_sidebar( 'homepage_featured_story' ) ) :
			dynamic_sidebar( 'homepage_featured_story' );
		endif;
		?>
		<?php get_template_part( 'parts/homepage/column-wells' ); ?>
	</div>
</div>
<?php get_template_part( 'parts/homepage/footer' ); ?>
<?php get_footer(); ?>
