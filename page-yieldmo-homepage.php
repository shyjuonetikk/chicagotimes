<?php
    /*
     * Template Name: YieldMo Homepage
     */
 ?>
<?php get_header(); ?>
            <?php
                if ( is_active_sidebar( 'homepage_breaking_news' ) ) :
                    dynamic_sidebar( 'homepage_breaking_news' ); 
                endif;

                $obj = \CST\Objects\Page::get_by_post_id( get_the_ID() );
                $yieldmo_tag = $obj->get_yieldmo_tag();
                if( $yieldmo_tag ) {
                    $yieldmo_printed_tag = CST()->yieldmo_tags->ym_get_demo_tag( $yieldmo_tag );
                    esc_html_e( $yieldmo_printed_tag );
                }
            ?>
            <div class="row">
                <div class="large-12 content-wrapper">
                        <div class="row">
                            <div class="large-12 columns dfp-atf-leaderboard show-for-medium-up">
                                <?php get_template_part( 'parts/dfp/homepage/dfp-atf-leaderboard' ); ?>
                            </div>
                        </div>
                </div>
            </div>
            <?php 
            do_action( 'above-homepage-headlines' );
                if ( is_active_sidebar( 'homepage_headlines' ) ) :
                    dynamic_sidebar( 'homepage_headlines' ); 
                endif;
            ?>
            <div class="row">
                <div class="large-12 columns content-wrapper">
                    <?php 
                        if ( is_active_sidebar( 'homepage_featured_story' ) ) :
                            dynamic_sidebar( 'homepage_featured_story' ); 
                        endif;
                    ?>
                    <?php get_template_part( 'parts/homepage/column-wells' ); ?>
                </div>
            </div>
        <?php get_template_part( 'parts/homepage/footer' ); ?>
</div>
<?php get_footer();

