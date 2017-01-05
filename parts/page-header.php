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
	<div class="inner-wrap">
	<?php
	if ( is_home() || is_front_page() || is_tax() ) {
		get_template_part( 'parts/dfp/dfp-mobile-leaderboard' );
		echo CST()->dfp_handler->unit( 2, 'div-gpt-super-leaderboard', 'dfp dfp-super-leaderboard dfp-centered' );
	}
	?>
<header id="header">

	<?php if ( ! is_404() ) { ?>

	<section id="primary-navigation" class="primary-normal">
		<?php $weather = CST()->frontend->get_weather(); ?>
		<?php if ( ! empty( $weather ) ) : ?>
		<div id="weather" class="show-for-medium-up">
			<a href="<?php echo esc_url( home_url( '/' ) . 'weather' ); ?>" class="weather-link"  data-on="click" data-event-category="navigation" data-event-action="navigate-weather">
				<span class="degrees"><i class="wi <?php echo esc_attr( CST()->frontend->get_weather_icon( $weather[0]->WeatherIcon ) ); ?>"></i>
				<?php echo esc_html( $weather[0]->Temperature->Imperial->Value . '&deg;' ); ?></span>
			</a>
		</div>
		<?php endif; ?>
		<?php get_template_part( 'parts/social-links' ); ?>

		<a href="#" class="left-off-canvas-toggle" id="burger-bar">
			<i class="fa fa-bars"></i><span>SECTIONS</span>
		</a>

		<div id="logo-wrap">
			<a id="suntimes-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-sf-logo">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/cst-amp-logo.svg' ); ?>" alt='Chicago Sun-Times logo' height="40" width="207"></a>
			<?php get_template_part( 'parts/images/main-site-logo' ); ?>

			<div id="tablet-home">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fa fa-home"></i></a>
			</div>
		</div>
		<div id="trending-container">
		<?php
		if ( $current_obj ) {
			if ( in_array( $conditional_nav->slug, CST_Frontend::$post_sections ) ) {
				switch ( $conditional_nav->slug ) {
					case 'news': ?>
					<span class="menu-label"><?php _e( 'Trending', 'chicagosuntimes' ); ?></span>
				<?php 	wp_nav_menu( array( 'theme_location' => $conditional_nav->slug.'-trending', 'menu_id' => 'menu-trending', 'menu_class' => 'menu ' . $conditional_nav->slug, 'container_class' => 'menu-trending-container', 'fallback_cb' => false ) );
						break;
					case 'sports': ?>
					<span class="menu-label"><?php _e( 'Chicago Teams', 'chicagosuntimes' ); ?></span>
				<?php	wp_nav_menu( array( 'theme_location' => $conditional_nav->slug.'-trending', 'menu_id' => 'menu-trending', 'menu_class' => 'menu ' . $conditional_nav->slug, 'container_class' => 'menu-trending-container', 'fallback_cb' => false ) );
						break;
					default: ?>
					<span class="menu-label"><?php _e( 'Trending', 'chicagosuntimes' ); ?></span>
				<?php 	wp_nav_menu( array( 'theme_location' => $conditional_nav->slug.'-trending', 'menu_id' => 'menu-trending', 'menu_class' => 'menu ' . $conditional_nav->slug, 'container_class' => 'menu-trending-container', 'fallback_cb' => false ) );
						break;
				}
			} else { ?>
				<span class="menu-label"><?php esc_html_e( 'Trending', 'chicagosuntimes' ); ?></span>
				<?php 	wp_nav_menu( array( 'theme_location' => 'news-trending', 'menu_id' => 'menu-trending', 'menu_class' => 'menu', 'container_class' => 'menu-trending-container', 'fallback_cb' => false ) );
			}
		}
		?>
		</div>
	</section>
	<?php } ?>
	<?php if ( is_singular() ) { ?>
	<section id="headlines-slider">
		<?php echo CST()->get_template_part( 'headlines/headlines-slider' ); ?>
	</section>
	<?php } ?>
</header>

<?php get_template_part( 'parts/off-canvas-menu' ); ?>
<?php
if ( is_singular() ) {
	$classes = array( 'columns', 'large-10', 'large-offset-2', 'end' );
} else {
	$classes = array();
}
?>
		<?php
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
		<section id="rss" class="row grey-background">
			<div class="large-8 columns">
				<a href="<?php echo esc_url( get_term_feed_link( $section_obj->term_id , 'cst_section' ) ); ?>"  data-on="click" data-event-category="navigation" data-event-action="navigate-sf-feed"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/rss.png" alt="rss">Subscribe to <?php esc_html_e( $section_obj->name ); ?></a>
			</div>
		</section>
	<?php endif; ?>
<?php endif; ?>
