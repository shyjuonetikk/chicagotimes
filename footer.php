<!--homepage_wrapper-->
<div class="clear-both"></div>
<a class="exit-off-canvas"></a>
</main>
</div><!-- /off-canvas-wrap -->
<script type="text/javascript" src="<?php echo esc_url( get_template_directory_uri());?>/assets/js/vendor/taboola-header-weather.js" ></script>
<?php
if ( is_singular() ) {
	get_template_part( 'parts/vendors/yieldmo-footer' );
	get_template_part( 'parts/vendors/aggrego-headlinesnetwork-footer' );
}
get_template_part( 'parts/analytics/chartbeat-footer' );
get_template_part( 'parts/footer-brand-navigation' );

do_action( 'closing_body' );

?>
<?php wp_footer(); ?>
</body>
</html>
