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
				<?php do_action( 'cst_section_front_heading', $section_front_spacing ); ?>
			</div>
			<?php
		}
if ( is_home() || is_front_page() || is_tax() ) {
	echo CST()->dfp_handler->unit( 2, 'div-gpt-super-leaderboard', 'dfp dfp-super-leaderboard dfp-centered' );
}
get_template_part( 'parts/off-canvas-menu' );
if ( is_singular() ) {
	$classes = array( 'columns', 'large-10', 'large-offset-2', 'end' );
} else {
	$classes = array();
}

if ( is_front_page() ) {
	wp_nav_menu( array(
		'theme_location' => 'homepage-menu',
		'fallback_cb' => false,
		'depth' => 1,
		'container_class' => 'cst-navigation-container',
		'items_wrap' => '<div class="nav-holder hp"><div class="nav-descriptor"><ul><li>In the news:</li></ul><ul id="%1$s" class="">%3$s</ul></div></div>',
		'walker' => new GC_walker_nav_menu(),
		)
	);
}
?>

<?php do_action( 'header_sliding_billboard' ); ?>

<?php if ( ! is_single() ) : ?>
	<?php if ( is_tax() ) {
		$section_obj = get_queried_object();
		if ( $section_obj->taxonomy == 'cst_section' ) {
			if ( $section_obj->parent != 0 ) {
				$parent_terms = get_term( $section_obj->parent, 'cst_section' );
				if ( ! in_array( $parent_terms->slug, CST_Frontend::$post_sections ) ) {
					$child_terms = get_term( $parent_terms->parent, 'cst_section' );
					$section_slug = $child_terms->slug;
				} else {
					$section_slug = $parent_terms->slug;
				}
			} else {
				$section_slug = $section_obj->slug;
			}
		} else {
			$section_slug = 'news';
		}
	} ?>
	<?php if ( isset( $section_slug ) ) : ?>
		<?php do_action( 'cst_section_front_upper_heading' );  ?>
		<?php $action_slug = str_replace( '-', '_', get_queried_object()->slug ); ?>
		<?php do_action( 'cst_section_head_comscore', $section_slug, $action_slug ); ?>
		<?php do_action( "cst_section_head_{$action_slug}" ); ?>
	<?php endif; ?>
<?php endif; ?>
