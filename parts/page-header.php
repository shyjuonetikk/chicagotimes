<?php $current_obj = \CST\Objects\Post::get_by_post_id( get_the_ID() );
	if ( $current_obj ) {
		$conditional_nav = $current_obj->get_primary_parent_section();
	} else {
		$conditional_nav = 'menu';
	}
?>
<div class="off-canvas-wrap" data-offcanvas>
	<?php 
		if( ! is_single() ) { 
			get_template_part( 'parts/dfp/dfp-interstitial' );
		} 
	?>
	<div class="inner-wrap">
	<?php 
		if( is_home() || is_front_page() || is_tax() ) { 
			get_template_part( 'parts/dfp/dfp-atf-leaderboard' );
			get_template_part( 'parts/dfp/dfp-mobile-leaderboard' ); 
		}
	?>
<header id="header">

	<?php if ( ! is_404() ) { ?>
	<section id="headlines-slider">
		<?php echo CST()->get_template_part( 'headlines/headlines-slider' ); ?>
	</section>
	<section id="primary-navigation" class="primary-normal">
		<?php $weather = CST()->frontend->get_weather(); ?>
		<?php if( ! empty( $weather ) ) : ?>
		<div id="weather" class="show-for-medium-up">
			<span class="degrees"><i class="wi <?php echo esc_attr( CST()->frontend->get_weather_icon( $weather[0]->WeatherIcon ) ); ?>"></i> 
			<?php echo esc_html( $weather[0]->Temperature->Imperial->Value . '&deg;' ); ?></span>
		</div>
		<?php endif; ?>
		<div id="social-links" class="show-for-medium-up">
			<ul>
			    <li class="facebook"><a href="<?php echo esc_url( 'https://www.facebook.com/thechicagosuntimes' ); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
			    <li class="twitter"><a href="<?php echo esc_url( 'https://twitter.com/suntimes' ); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
			</ul>
		</div>

		<a href="#" class="left-off-canvas-toggle" id="burger-bar">
			<i class="fa fa-bars"></i>
		</a>

		<div id="logo-wrap">
			<a id="suntimes-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php get_template_part( 'parts/images/company-logo'); ?></a>
			<?php get_template_part( 'parts/images/main-site-logo'); ?>
		</div>

		<div id="trending-container">
		<?php 	if ( $current_obj ) {
					if( in_array( $conditional_nav->slug, CST_Frontend::$post_sections ) ) {
						switch( $conditional_nav->slug ) {
							case 'news': ?>
							<span class="menu-label"><?php _e( 'Trending', 'chicagosuntimes' ); ?></span>
						<?php 	wp_nav_menu( array( 'theme_location' => $conditional_nav->slug.'-trending', 'menu_id' => 'menu-trending', 'menu_class' => 'menu ' . $conditional_nav->slug, 'container_class' => 'menu-trending-container','fallback_cb' => false ) );
								break;
							case 'sports': ?>
							<span class="menu-label"><?php _e( 'Chicago Teams', 'chicagosuntimes' ); ?></span>
						<?php	wp_nav_menu( array( 'theme_location' => $conditional_nav->slug.'-trending', 'menu_id' => 'menu-trending', 'menu_class' => 'menu ' . $conditional_nav->slug, 'container_class' => 'menu-trending-container','fallback_cb' => false ) );
								break;
							default: ?>
							<span class="menu-label"><?php _e( 'Trending', 'chicagosuntimes' ); ?></span>
						<?php 	wp_nav_menu( array( 'theme_location' => $conditional_nav->slug.'-trending', 'menu_id' => 'menu-trending', 'menu_class' => 'menu ' . $conditional_nav->slug, 'container_class' => 'menu-trending-container','fallback_cb' => false ) );
								break;
						}
					} else { ?>
						<span class="menu-label"><?php esc_html_e( 'Trending', 'chicagosuntimes' ); ?></span>
						<?php 	wp_nav_menu( array( 'theme_location' => 'news-trending', 'menu_id' => 'menu-trending', 'menu_class' => 'menu', 'container_class' => 'menu-trending-container','fallback_cb' => false ) );
					}
				}
		?>
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
		<?php get_template_part( 'parts/menu-footer-fixed') ?>
	</div>
</aside>

<?php
if ( is_singular() ) {
	$classes = array( 'columns', 'large-10', 'large-offset-2', 'end' );
} else {
	$classes = array();
}
?>

<?php 
	if( ! is_single() ) { 
		get_template_part( 'parts/dfp/dfp-wallpaper' ); 
	}
?>

<?php 
	if ( ! is_404() ) :
		get_template_part( 'parts/dfp/dfp-sbb' );
	endif; 
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
	<?php if ( $section_slug ) : ?>
		<?php if ( 'sports' == $section_slug ) : ?>
			<section id="comscore" class="row grey-background">
				<div class="large-8 columns">
					<iframe src="http://scores.suntimes.com/sports-scores/score-carousel.aspx?Leagues=NFL;MLB;NBA;NHL&amp;numVisible=4" scrolling="no" frameborder="0" style="border:0; width:625px; height:90px;">Live Scores</iframe>
				</div>
			</section>
			<section id="rss" class="row grey-background">
				<div class="large-8 columns">
					<a href="<?php echo esc_url( get_term_feed_link( $section_obj->term_id , 'cst_section' ) ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/rss.png" alt="rss">Subscribe to Sports</a>
				</div>
			</section>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
