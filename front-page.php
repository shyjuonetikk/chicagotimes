<?php get_header(); ?>
<?php
if ( is_active_sidebar( 'homepage_breaking_news' ) ) :
	dynamic_sidebar( 'homepage_breaking_news' );
endif;
?>
<div class="homepage-content">
	<div class="row">
		<div class="large-12 content-wrapper">
			<?php echo CST()->dfp_handler->unit( 1, 'div-gpt-billboard', 'dfp dfp-billboard dfp-centered' ); ?>
			<?php echo CST()->dfp_handler->unit( 1, 'div-gpt-sbb', 'dfp dfp-sbb dfp-centered' ); ?>
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
</div>
<div class="large-12">
	<h2>Currently trending:</h2>
	<div id="root"></div>
	<script type="text/javascript" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/static/js/main.6c13c9a2.js"></script>
</div>
<div class="large-12 dfp-atf-leaderboard">
	<?php echo CST()->dfp_handler->unit( 3, 'div-gpt-super-leaderboard', 'dfp dfp-super-leaderboard dfp-centered' ); ?>
</div>
	<div class="small-12 content-wrapper f">
		<?php
		if ( is_active_sidebar( 'homepage_featured_story' ) ) :
			dynamic_sidebar( 'homepage_featured_story' );
		endif;
		?>
	</div>
	<hr class="before">
	<h2 class="section-title"><span><?php esc_html_e( 'More From', 'chicagosuntimes' ); ?></span></h2>
	<hr/>
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
			<?php echo CST()->dfp_handler->unit( 4, 'div-gpt-super-leaderboard', 'dfp dfp-super-leaderboard dfp-centered' ); ?>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns content-wrapper cw">
			<?php get_template_part( 'parts/homepage/column-wells' ); ?>
		</div>
	</div>
</div>
<?php get_template_part( 'parts/homepage/footer' ); ?>
<?php get_footer(); ?>
