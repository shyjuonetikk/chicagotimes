<?php if ( !is_front_page() ) {
	get_template_part( 'parts/page-footer' );
} ?>
</div>
<?php wp_footer(); ?>
<?php 
    if( ! is_user_logged_in() && is_singular() ) :
        get_template_part( 'parts/vendors/google-survey-footer' );
    endif;
?>
<?php get_template_part( 'parts/analytics/chartbeat-footer' ); ?>
</body>
</html>