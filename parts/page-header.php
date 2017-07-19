<?php if ( ! is_page_template( 'page-monster.php' ) ) {
	get_template_part( 'parts/header-brand-navigation' );
} ?>
<div class="spacer"></div>
<?php if ( is_tax() ) { ?>
	<div class="row sf-head">
		<?php do_action( 'cst_section_front_heading' ); ?>
	</div>
	<?php
}
if ( is_home() || is_front_page() ) {
	echo wp_kses( CST()->dfp_handler->dynamic_unit( 2, 'div-gpt-super-leaderboard', 'dfp dfp-super-leaderboard dfp-centered', 'hp_upper_super_leaderboard_mapping', 'Super leaderboard 2 970x90' ),
		CST()->dfp_kses
	);
}
if ( is_tax() ) {
	echo wp_kses( CST()->dfp_handler->dynamic_unit( 2, 'div-gpt-super-leaderboard', 'dfp dfp-super-leaderboard dfp-centered', 'super_leaderboard_mapping', 'Super leaderboard 2 970x90' ),
		CST()->dfp_kses
	);
	$section_obj = get_queried_object();
	$section_slug = CST()->frontend->determine_section_slug( $section_obj );
	if ( isset( $section_slug ) ) :
		do_action( 'cst_section_front_upper_heading' );
		$action_slug = str_replace( '-', '_', get_queried_object()->slug );
		do_action( 'cst_section_head_comscore', $section_slug, $action_slug );
		do_action( "cst_section_head_{$action_slug}" );
	endif;
}
