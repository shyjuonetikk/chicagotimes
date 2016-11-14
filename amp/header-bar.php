<div class="amp-wp-title-bar">
	<div class="site-logo" >
		<a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>">
			<amp-img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/cst-amp-logo.svg' ); ?>" height="38" width="200" layout="responsive"></amp-img>
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
		<li class="colophon"><a href="%3$s/terms-of-use/">Terms of Use</a></li>
		<li class="colophon"><a href="%3$s/privacy-policy/">Privacy Policy</a></li>
		<li class="colophon"><a href="%3$s/contact-us/">Contact Us</a></li>
		<li class="copyright">%1$d Chicago Sun-Times</li>
	</ul>

', date( 'Y' ), CST()->amp_nav_markup(), esc_url( get_bloginfo( 'url' ) ) )
);
?>
