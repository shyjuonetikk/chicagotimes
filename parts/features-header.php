<?php
$conditional_nav = CST()->frontend->get_conditional_nav();
$obj = CST()->frontend->get_current_object();
?>
<div class="off-canvas-wrap" data-offcanvas>
	<div class="inner-wrap">

<header id="header" class="masthead">

	<?php if ( ! is_404() ) { ?>

	<section id="primary-navigation" class="primary-normal">

		<div class="feature-social-container show-for-medium-up">
			<?php echo CST()->get_template_part( 'post/social-share', array( 'obj' => $obj ) ); ?>
		</div>

		<a href="#" class="left-off-canvas-toggle" id="burger-bar">
			<i class="fa fa-bars"></i>
		</a>

		<div id="logo-wrap">
			<a id="suntimes-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-sf-logo">
				<img src="<?php echo esc_url( get_stylesheet_directory_uri()  . '/cst-amp-logo.svg' ); ?>" height="57" width="300" alt="Chicago Sun-Times logo">
			</a>

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
			<?php if ( CST()->frontend->get_current_object() ) {
				if ( array_key_exists( $conditional_nav->slug.'-menu', get_registered_nav_menus() ) ) {
					wp_nav_menu( array( 'theme_location' => $conditional_nav->slug.'-menu', 'fallback_cb' => false ) );
				} else {
					wp_nav_menu( array( 'theme_location' => 'news-menu', 'fallback_cb' => false ) );
				}
} else {
				wp_nav_menu( array( 'theme_location' => 'news-menu', 'fallback_cb' => false ) );
}?>
		</ul>
		<?php
		if ( $obj ) {
			echo CST()->get_template_part( 'post/social-share', array( 'obj' => $obj ) );
		}
		?>
	</div>
</aside>
<div class="spacer"></div>
<?php
if ( is_singular() ) {
	$classes = array( 'columns', 'large-12', 'end' );
} else {
	$classes = array();
}

