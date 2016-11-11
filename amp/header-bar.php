<div class="amp-wp-title-bar">
	<div class="site-logo" >
		<a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>">
			<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/cst-amp-logo.svg' ); ?>"/>
			<?php $site_icon_url = $this->get( 'site_icon_url' ); ?>
			<?php if ( $site_icon_url ) : ?>
				<amp-img src="<?php echo esc_url( $site_icon_url ); ?>" width="32" height="32" class="amp-wp-site-icon"></amp-img>
			<?php endif; ?>
			<?php echo esc_html( $this->get( 'blog_name' ) ); ?>
		</a>
	</div>
	<button on='tap:sidebar.open' class="cst-button">&#9776;</button>
</div>
<?php
echo AMP_HTML_Utils::build_tag(
	'amp-sidebar',
	array(
		'id'     => 'sidebar',
		'layout' => 'nodisplay',
		'side'   => 'left',
	), sprintf( '
	<ul class="section-menu">
		<li class="header">Sections</li>
		<li class="section-break"></li>
	</ul>
	%2$s
	<ul class="section-menu">
		<li class="section-break"></li>
		<li class="colophon"><a href="http://wssp.suntimes.com/terms-of-use/">Terms of Use</a></li>
		<li class="colophon"><a href="http://wssp.suntimes.com/privacy-policy/">Privacy Policy</a></li>
		<li class="colophon"><a href="http://wssp.suntimes.com/contact-us/">Contact Us</a></li>
		<li class="copyright">%1$d Chicago Sun-Times</li>
	</ul>

', date( 'Y' ), CST()->amp_nav_markup() )
);
?>
