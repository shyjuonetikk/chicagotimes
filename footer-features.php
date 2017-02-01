<?php if ( ! is_front_page() ) {
	get_template_part( 'parts/page-footer' );
} ?>
</div>

<?php wp_footer(); ?>

<?php get_template_part( 'parts/analytics/chartbeat-footer' );
get_template_part( 'parts/features-footer-brand-navigation' );
do_action( 'closing_body' );
?>
</body>
</html>
