<?php if ( ! is_front_page() ) {
	get_template_part( 'parts/page-footer' );
} ?>
</div>

<?php
if ( is_singular() ) {
	get_template_part( 'parts/vendors/google-survey-footer' );
	get_template_part( 'parts/vendors/yieldmo-footer' );
	get_template_part( 'parts/vendors/triplelift-footer' );
	get_template_part( 'parts/vendors/aggrego-headlinesnetwork-footer' );
	get_template_part( 'parts/vendors/gum-gum-footer' );
}
get_template_part( 'parts/analytics/chartbeat-footer' );
get_template_part( 'parts/footer-brand-navigation' );

do_action( 'closing_body' );
?>
<?php wp_footer(); ?>
</body>
</html>
