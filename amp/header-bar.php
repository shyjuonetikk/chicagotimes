<div class="amp-wp-title-bar">
	<div class="site-logo" >
		<a href="<?php echo esc_url( $this->get( 'home_url' ) ); ?>">
			<amp-img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/cst-amp-logo.svg' ); ?>" height="38" width="200" layout="responsive"></amp-img>
		</a>
	</div>
	<button on='tap:sidebar.open' class="cst-button">&#9776;</button>
</div>
