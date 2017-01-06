<?php ?>
<aside class="left-off-canvas-menu">
	<div class="off-canvas-menu">
		<div class="columns small-4">
			<a href="#" class="left-off-canvas-toggle burger-bar">
				<i class="fa fa-bars"></i>
			</a>
		</div>
		<div class="columns small-12">
			<div class="off-canvas-logo">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/cst-amp-logo.svg' ); ?>" alt='Chicago Sun-Times logo' height="39" width="200"></a>
			</div>
		</div>
		<ul class="off-canvas-list">
			<form class="search-wrap" autocomplete="off" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input id="search-input" placeholder="<?php esc_attr_e( 'search...', 'chicagosuntimes' ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" />
				<a href="#" id="search-button" class="search-in">
					<i class="fa fa-search"></i>
				</a>
			</form>
<?php if ( is_front_page() ) {
	wp_nav_menu( array( 'theme_location' => 'homepage-menu', 'fallback_cb' => false ) );
} else if ( $current_obj ) {
	if ( array_key_exists( $conditional_nav->slug.'-menu', get_registered_nav_menus() ) ) {
		wp_nav_menu( array( 'theme_location' => $conditional_nav->slug.'-menu', 'fallback_cb' => false ) );
	} else {
		wp_nav_menu( array( 'theme_location' => 'news-menu', 'fallback_cb' => false ) );
	}
} else {
	wp_nav_menu( array( 'theme_location' => 'news-menu', 'fallback_cb' => false ) );
}?>
		</ul>
	</div>
</aside>
