<?php if ( is_front_page() || is_page() || is_404() || is_post_type_archive( 'cst_feature' ) || is_singular( 'cst_feature' ) || is_tax() ) { ?>
<footer id="cst-footer">
	<div class="footerlead">
		<div class="row">
			<div class="columns small-12 back-to-top">
				<a href="#">
					<p><i class="fa fa-arrow-circle-up"></i><?php esc_html_e( '&nbsp;Back To Top', 'chicagosuntimes' ); ?></p>
				</a>
			</div>
		</div>
	</div>
	<div class="row footer-upper" data-equalizer>
	<div class="small-10 columns">
			<a id="suntimes-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-sf-logo"><img src="<?php echo esc_url( get_template_directory_uri() . '/cst-amp-logo.svg' ); ?>" alt='Chicago Sun-Times logo' height="39" width="200"></a>
	</div>
	<div class="small-12 medium-2 columns">
		<?php echo wp_kses_post( CST()->get_template_part( 'social-links' ) ); ?>
	</div>
	<div class="small-12 columns separate-me">
		<div class="row">
<?php if ( has_nav_menu( 'page-footer-1' ) ) {
	wp_nav_menu( array(
		'theme_location' => 'page-footer-1',
		'fallback_cb' => false,
		'container' => false,
		'depth' => 2,
		'items_wrap' => '<div class="small-12 medium-3 columns" ><ul id="%1$s" class="">%3$s</ul></div>',
		)
	);
} else { ?>
	<div class="small-12 medium-3 columns" >
		<ul>
			<li><a href="<?php echo esc_url( '/about-us' ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-footer-about">About us</a></li>
			<li><a href="<?php echo esc_url( '/contact-us' ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-footer-contact">Contact us</a></li>
		</ul>
	</div>
	<?php }
if ( has_nav_menu( 'page-footer-2' ) ) {
	wp_nav_menu( array(
		'theme_location' => 'page-footer-2',
		'fallback_cb' => false,
		'container' => false,
		'depth' => 2,
		'items_wrap' => '<div class="small-12 medium-3 columns" ><ul id="%1$s" class="">%3$s</ul></div>',
		)
	);
} else { ?>
	<div class="small-12 medium-3 columns" >
		<ul>
			<li><a href="<?php echo esc_url( '/about-our-ads' ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-footer-about-ads">About our ads</a></li>
			<li><a href="<?php echo esc_url( '/privacy-policy' ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-footer-privacy">Privacy Policy</a></li>
		</ul>
	</div>
<?php }
if ( has_nav_menu( 'page-footer-3' ) ) {
	wp_nav_menu( array(
		'theme_location' => 'page-footer-3',
		'fallback_cb' => false,
		'container' => false,
		'depth' => 2,
		'items_wrap' => '<div class="small-12 medium-3 columns" ><ul id="%1$s" class="">%3$s</ul></div>',
		)
	);
} else { ?>
	<div class="small-12 medium-3 columns" >
		<ul>
			<li><a href="<?php echo esc_url( '/terms-of-use' ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-footer-terms">Terms of use</a></li>
			<li><a href="<?php echo esc_url( 'https://payments.suntimes.com' ); ?>" target="_blank" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-footer-back-order">Order Back Issues</a>&nbsp;<i
						class="fa fa-external-link" aria-hidden="true"></i></li>
		</ul>
	</div>
	<?php }
if ( has_nav_menu( 'page-footer-4' ) ) {
	wp_nav_menu( array(
		'theme_location' => 'page-footer-4',
		'fallback_cb' => false,
		'container' => false,
		'depth' => 2,
		'items_wrap' => '<div class="small-12 medium-3 columns" ><ul id="%1$s" class="">%3$s</ul></div>',
		)
	);
} else { ?>
	<div class="small-12 medium-3 columns" >
		<ul>
			<li><a href="<?php echo esc_url( '/subscribe' ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-footer-terms">Subscribe-temp</a></li>
			<li><a href="<?php echo esc_url( '/terms-of-use' ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-footer-terms">Terms of use</a></li>
			<li><a href="<?php echo esc_url( 'https://payments.suntimes.com' ); ?>" target="_blank" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-footer-back-order">Order Back Issues</a>&nbsp;<i
						class="fa fa-external-link" aria-hidden="true"></i></li>
		</ul>
	</div>
	<?php } ?>
		</div>
	</div>
	</div>
	<div class="row footer-lower">
		<div class="small-10 columns">
			<p class="copyright"><?php echo sprintf( 'Copyright &copy; 2005 - %s', esc_attr( date( 'Y' ) ) ); ?> Chicago Sun-Times</p>
		</div>
		<div class="small-2 columns">
			<?php echo wp_kses_post( str_replace( 'rel="generator', 'rel="', vip_powered_wpcom_img_html( 6 ) ) ); ?>
		</div>
	</div>
</footer>
<?php } ?>
<?php
// Inject newsletter modal customized to the section being displayed
if ( ! CST()->frontend->display_minimal_nav() ) { ?>
<div id="search-container" class="reveal-modal large" data-reveal aria-labelledby="search-container" aria-hidden="true" role="dialog">
	<a class="close-reveal-modal">&#215;</a>
	<div class="row">
		<div class="small-4 small-centered columns">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/cst-masthead.svg' ); ?>" alt='Chicago Sun-Times logo'>
		</div>
	</div>
	<div class="small-12 columns">
		<h3>Search</h3>
		<form class="search-wrap" autocomplete="off" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="text" id="full-search-input" class="search-input" placeholder="<?php esc_attr_e( 'SEARCH', 'chicagosuntimes' ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>"/>
		</form>
	</div>
</div>
<?php }
