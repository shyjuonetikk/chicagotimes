<footer>
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
			<?php echo CST()->get_template_part( 'social-links' ); ?>
		</div>
	</div>
	<div class="row footer-lower">
		<div class="small-12 columns">
			<p class="copyright"><?php echo sprintf( 'Copyright &copy; 2005 - %s', date( 'Y' ) ); ?> Chicago Sun-Times</p>
		</div>
	</div>
</footer>
