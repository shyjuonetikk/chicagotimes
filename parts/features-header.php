<?php 
if( is_single() ) {
	$current_obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
	if ( $current_obj ) {
		$conditional_nav = $current_obj->get_primary_parent_section();
		if( ! $conditional_nav ) {
			$conditional_nav = $current_obj->get_child_parent_section();
			if( ! in_array( $conditional_nav, CST_Frontend::$post_sections ) ) {
				$conditional_nav = $current_obj->get_grandchild_parent_section();
			}
		}
	} else {
		$conditional_nav = 'menu';
	}
} elseif( is_tax() ) {
	$current_obj = get_queried_object();
	if( $current_obj->taxonomy == 'cst_section' ) {
		if( $current_obj->parent != 0 ) {
			$parent_terms = get_term( $current_obj->parent, 'cst_section' );
			if( ! in_array( $parent_terms->slug, CST_Frontend::$post_sections ) ) {
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
	<div class="inner-wrap">

<header id="header">

	<?php if ( ! is_404() ) { ?>

	<section id="primary-navigation" class="primary-normal">

		<?php get_template_part( 'parts/social-links' ); ?>

		<a href="#" class="left-off-canvas-toggle" id="burger-bar">
			<i class="fa fa-bars"></i>
		</a>

		<div id="logo-wrap">
			<a id="suntimes-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-sf-logo">
				<img src="<?php echo esc_url( get_stylesheet_directory_uri()  . '/cst-amp-logo.svg' ); ?>" alt="Chicago Sun-Times logo">
			</a>
			<?php get_template_part( 'parts/images/main-site-logo' ); ?>

			<div id="tablet-home">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fa fa-home"></i></a>
			</div>
		</div>

		<div id="mobile-home">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fa fa-home"></i></a>
		</div>

		<div id="trending-container">

		</div>
	</section>
	<?php } ?>
</header>

<aside class="left-off-canvas-menu">
	<div class="off-canvas-menu">
		<ul class="off-canvas-list">
			<form class="search-wrap" autocomplete="off" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input id="search-input" placeholder="<?php esc_attr_e( 'search...', 'chicagosuntimes' ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" />
				<a href="#" id="search-button" class="search-in">
					<i class="fa fa-search"></i>
				</a>
			</form>
			<?php if ( $current_obj ) {
				if ( array_key_exists( $conditional_nav->slug.'-menu', get_registered_nav_menus() ) ) {
					wp_nav_menu( array( 'theme_location' => $conditional_nav->slug.'-menu', 'fallback_cb' => false ) );
				} else {
					wp_nav_menu( array( 'theme_location' => 'news-menu', 'fallback_cb' => false ) );
				}
			} else {
				wp_nav_menu( array( 'theme_location' => 'news-menu', 'fallback_cb' => false ) );
			}?>
		</ul>
		<?php echo CST()->get_template_part( 'social-links' ); ?>
	</div>
</aside>

<?php
if ( is_singular() ) {
	$classes = array( 'columns', 'large-12', 'end' );
} else {
	$classes = array();
}
?>


<?php if ( ! is_single() ) : ?>
	<?php if ( is_tax() ){
		$section_obj = get_queried_object();
		if( $section_obj->taxonomy == 'cst_section' ) {
			if( $section_obj->parent != 0 ) {
				$parent_terms = get_term( $section_obj->parent, 'cst_section' );
				if( ! in_array( $parent_terms->slug, CST_Frontend::$post_sections ) ) {
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
		<?php do_action( "cst_section_head_comscore", $section_slug, $action_slug ); ?>
		<?php do_action( "cst_section_head_{$action_slug}" ); ?>
		<section id="rss" class="row grey-background">
			<div class="large-8 columns">
				<a href="<?php echo esc_url( get_term_feed_link( $section_obj->term_id , 'cst_section' ) ); ?>"  data-on="click" data-event-category="navigation" data-event-action="navigate-sf-feed"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/rss.png" alt="rss">Subscribe to <?php esc_html_e( $section_obj->name ); ?></a>
			</div>
		</section>
	<?php endif; ?>
<?php endif; ?>
