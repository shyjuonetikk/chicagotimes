<?php
if ( is_single() ) {
	$current_obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
	if ( $current_obj ) {
		$conditional_nav = $current_obj->get_primary_parent_section();
		if ( ! $conditional_nav ) {
			$conditional_nav = $current_obj->get_child_parent_section();
			if ( ! in_array( $conditional_nav, CST_Frontend::$post_sections ) ) {
				$conditional_nav = $current_obj->get_grandchild_parent_section();
			}
		}
	} else {
		$conditional_nav = 'menu';
	}
} elseif ( is_tax() ) {
	$current_obj = get_queried_object();
	if ( 'cst_section' == $current_obj->taxonomy ) {
		if ( 0 != $current_obj->parent ) {
			$parent_terms = get_term( $current_obj->parent, 'cst_section' );
			if ( ! in_array( $parent_terms->slug, CST_Frontend::$post_sections ) ) {
				$child_terms = get_term( $parent_terms->parent, 'cst_section' );
				$conditional_nav = $child_terms;
			} else {
				$conditional_nav = $parent_terms;
			}
		} else {
			$conditional_nav = $current_obj;
		}
	} else {
		$conditional_nav = 'news';
	}
} else {
	$conditional_nav = 'menu';
}
?>
<div class="off-canvas-wrap" data-offcanvas>
	<?php get_template_part( 'parts/dfp/dfp-interstitial' ); ?>

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
