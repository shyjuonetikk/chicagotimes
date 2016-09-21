<footer>
	<hr>
<div class="row footer-upper">
	<div class="small-12 medium-3 columns">
		<a id="suntimes-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php get_template_part( 'parts/images/company-logo'); ?></a>
		<p class="copyright"><?php echo sprintf( 'Copyright &copy; 2005 - %s Chicago Sun-Times', date( 'Y' ) ); ?></p>
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
		<li><a href="<?php echo esc_url( '/about-us' ); ?>">About us</a></li>
		<li><a href="<?php echo esc_url( '/contact-us' ); ?>">Contact us</a></li>
	</ul>
<?php }	?>

<?php if ( has_nav_menu( 'page-footer-2' ) ) {
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
		<li><a href="<?php echo esc_url( '/about-our-ads' ); ?>">About our ads</a></li>
		<li><a href="<?php echo esc_url( '/privacy-policy' ); ?>">Privacy Policy</a></li>
	</ul>
<?php }	?>
<?php if ( has_nav_menu( 'page-footer-3' ) ) {
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
		<li><a href="<?php echo esc_url( '/terms-of-use' ); ?>">Terms of use</a></li>
		<li><a href="<?php echo esc_url( 'https://payments.suntimes.com' ); ?>" target="_blank">Order Back Issues</a>&nbsp;<i class="fa fa-external-link" aria-hidden="true"></i></li>
	</ul>
<?php }	?>
	</div>
	<div class="small-12 medium-2 columns">
		<?php echo CST()->get_template_part( 'social-links'); ?>
	</div>
</div>
</footer>