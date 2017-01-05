<footer>
	<hr>
<div class="row footer-upper">
	<div class="small-12 medium-3 columns">
			<a id="suntimes-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-sf-logo"><?php get_template_part( 'parts/images/company-logo' ); ?></a>
			<p class="copyright"><?php echo sprintf( 'Copyright &copy; 2005 - %s', date( 'Y' ) ); ?><br>Chicago Sun-Times</p>
	</div>
	<div class="small-12 medium-7 columns">
<?php if ( has_nav_menu( 'page-footer-1' ) ) {
	wp_nav_menu( array(
		'theme_location' => 'page-footer-1',
		'fallback_cb' => false,
		'container' => false,
		'depth' => 2,
		'items_wrap' => '<ul id="%1$s" class="">%3$s</ul>',
		)
	);
} else { ?>
	<ul>
		<li><a href="<?php echo esc_url( '/about-us' ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-footer-about">About us</a></li>
		<li><a href="<?php echo esc_url( '/contact-us' ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-footer-contact">Contact us</a></li>
	</ul>
	<?php }
if ( has_nav_menu( 'page-footer-2' ) ) {
	wp_nav_menu( array(
		'theme_location' => 'page-footer-2',
		'fallback_cb' => false,
		'container' => false,
		'depth' => 2,
		'items_wrap' => '<ul id="%1$s" class="">%3$s</ul>',
		)
	);
} else { ?>
	<ul>
		<li><a href="<?php echo esc_url( '/about-our-ads' ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-footer-about-ads">About our ads</a></li>
		<li><a href="<?php echo esc_url( '/privacy-policy' ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-footer-privacy">Privacy Policy</a></li>
	</ul>
	<?php }
if ( has_nav_menu( 'page-footer-3' ) ) {
	wp_nav_menu( array(
		'theme_location' => 'page-footer-3',
		'fallback_cb' => false,
		'container' => false,
		'depth' => 2,
		'items_wrap' => '<ul id="%1$s" class="">%3$s</ul>',
		)
	);
} else { ?>
	<ul>
		<li><a href="<?php echo esc_url( '/terms-of-use' ); ?>" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-footer-terms">Terms of use</a></li>
		<li><a href="<?php echo esc_url( 'https://payments.suntimes.com' ); ?>" target="_blank" data-on="click" data-event-category="navigation" data-event-action="navigate-hp-footer-back-order">Order Back Issues</a>&nbsp;<i class="fa fa-external-link" aria-hidden="true"></i></li>
	</ul>
	<?php } ?>
	</div>
	<div class="small-12 medium-2 columns">
		<?php echo CST()->get_template_part( 'social-links' ); ?>
	</div>
</div>
</footer>
<div id="subscribe-modal" class="reveal-modal xlarge" data-reveal aria-labelledby="Subscribe to Chicago Sun-Times" aria-hidden="true" role="dialog">
	<iframe src="http://wssp.suntimes.com/subscribe/" frameborder="0" class="cst-responsive" width="100%" height="700" allowfullscreen></iframe>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
<div id="search-container" class="reveal-modal large" data-reveal aria-labelledby="searchContainer" aria-hidden="true" role="dialog">
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
