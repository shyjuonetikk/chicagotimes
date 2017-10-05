<div class="amp-wp-title-bar">
	<div class="site-logo" >
		<a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>">
			<amp-img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/chicago-sun-times-logo.png' ); ?>" height="40" width="219" layout="responsive"></amp-img>
		</a>
	</div>
	<button on='tap:sidebar.open' class="cst-button">&#9776;</button>
</div>
<amp-app-banner layout="nodisplay" id="cst-app-banner">
	<amp-img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/cst-app-logo.svg' ); ?>"
			 width="60" height="60">
	</amp-img>
	<div id="banner-text">
		<h5>Chicago Sun-Times</h5>
		<p>Enjoy a richer experience on our mobile app!</p>
		<div class="actions">
			<button open-button>Get the app</button>
		</div>
	</div>
</amp-app-banner>
