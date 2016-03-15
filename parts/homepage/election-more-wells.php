<hr/>
<h2 class="section-title"><span><?php esc_html_e( 'Elections 2016', 'chicagosuntimes' ); ?></span></h2>
<hr/>
<div class="large-6 columns">
	<?php
	if ( shortcode_exists( 'election-2016' ) ) {
		echo do_shortcode( '[election-2016 page="President" height="520px"]' );
	}
	?>
</div>
<div class="large-6 columns">
	<?php
	if ( shortcode_exists( 'election-2016' ) ) {
		echo do_shortcode( '[election-2016 page="States_Attorney" height="191px"]' );
	}
	if ( shortcode_exists( 'election-2016' ) ) {
		echo do_shortcode( '[election-2016 page="Circuit_Court_Clerk" height="191px"]' );
	}
	?>
</div>
