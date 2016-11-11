<?php
/*
 * Template Name: AMP navigation items
 *
 * This template forces the return of a JSON object representing available section
 * navigation for use with AMP templates
 */
@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );

$result = wp_cache_get( 'cst_amp_nav_json', 'default' ); //VIP: for some reason fetch_feed is not caching this properly.
if ( false === $result || WP_DEBUG ) {
	$navigation_markup = wp_nav_menu( array(
			'theme_location' => 'homepage-menu',
			'echo'           => false,
			'fallback_cb'    => false,
			'container'      => false,
			'depth'          => 1,
			'items_wrap'     => '<ul id="%1$s" class="section-menu">%3$s</ul>',
			'walker'         => new GC_walker_nav_menu(),
		)
	);
	wp_cache_set( 'cst_amp_nav_json', $navigation_markup, 'default', 1 * MINUTE_IN_SECONDS );
} else {
	$navigation_markup = $result;
}

echo( wp_kses_post ( $navigation_markup ) );
if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
	wp_die();
} else {
	die;
}