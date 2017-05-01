<?php
echo wp_kses( CST()->dfp_handler->interstitial(),
	CST()->dfp_kses
);
get_template_part( 'parts/header-brand-navigation' );
?>
<div class="homepage_wrapper">
	<div class="hp-bn-wrapper">
		<?php
		if ( is_active_sidebar( 'homepage_breaking_news' ) ) :
			dynamic_sidebar( 'homepage_breaking_news' );
		endif;
		?>
	</div>
<?php
if ( ( is_home() || is_front_page() ) && ! WP_DEBUG ) {
	echo wp_kses( CST()->dfp_handler->dynamic_unit( 2, 'div-gpt-super-leaderboard', 'dfp dfp-super-leaderboard dfp-centered', 'super_leaderboard_mapping', 'Super leaderboard 2 970x90' ),
		CST()->dfp_kses
	);
}