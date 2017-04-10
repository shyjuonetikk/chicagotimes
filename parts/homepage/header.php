<?php if ( ! is_page_template( 'page-monster.php' ) ) {
	get_template_part( 'parts/header-brand-navigation' );
} ?>
<div class="homepage_wrapper">
<?php
if ( is_home() || is_front_page() ) {
	echo wp_kses( CST()->dfp_handler->dynamic_unit( 2, 'div-gpt-super-leaderboard', 'dfp dfp-super-leaderboard dfp-centered', 'super_leaderboard_mapping', 'Super leaderboard 2 970x90' ),
		CST()->dfp_kses
	);
}