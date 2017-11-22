<?php if ( \CST\CST_Section_Front::get_instance()->is_sports_or_child( get_queried_object_id() ) ) { ?>
	</div><!-- section_front_wrapper -->
<?php } ?><!--homepage_wrapper-->
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
</body>
</html>
