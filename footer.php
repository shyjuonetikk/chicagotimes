<?php if ( !is_front_page() ) {
	get_template_part( 'parts/page-footer' );
} ?>
</div>
<?php wp_footer(); ?>
<?php 
    if( is_singular() ) :
        get_template_part( 'parts/vendors/google-survey-footer' );
        get_template_part( 'parts/vendors/yieldmo-footer' );
        get_template_part( 'parts/vendors/aggrego-chatter-footer' );
        get_template_part( 'parts/vendors/zedo-footer' );
    endif;
?>
<?php get_template_part( 'parts/analytics/chartbeat-footer' ); ?>
</body>
</html>