<!--homepage_wrapper-->
<div class="clear-both"></div>
<a class="exit-off-canvas"></a>
</main>
</div><!-- /off-canvas-wrap -->

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
<div id="101" class="dfp oop">
	<script class="dfp">
      googletag.cmd.push(function() {
        googletag.display("101");
      });
	</script>
</div>
</body>
</html>
