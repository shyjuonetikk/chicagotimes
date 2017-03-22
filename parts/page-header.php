<?php if ( ! is_404() && ! is_author() ) {
	echo CST()->dfp_handler->interstitial();
} ?>

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
if ( is_home() || is_front_page() || is_tax() ) {
	echo CST()->dfp_handler->unit( 2, 'div-gpt-super-leaderboard', 'dfp dfp-super-leaderboard dfp-centered' );
}
?>

<?php do_action( 'header_sliding_billboard' ); ?>

<?php if ( ! is_single() ) : ?>
	<?php if ( is_tax() ) {
		$section_obj = get_queried_object();
		$section_slug = CST()->frontend->determine_section_slug( $section_obj );
} ?>
	<?php if ( isset( $section_slug ) ) : ?>
		<?php do_action( 'cst_section_front_upper_heading' );  ?>
		<?php $action_slug = str_replace( '-', '_', get_queried_object()->slug ); ?>
		<?php do_action( 'cst_section_head_comscore', $section_slug, $action_slug ); ?>
		<?php do_action( "cst_section_head_{$action_slug}" ); ?>
	<?php endif; ?>
<?php endif; ?>
