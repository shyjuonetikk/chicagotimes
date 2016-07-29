<?php get_header(); ?>
<div class="homepage-content">
<?php get_template_part( 'parts/dfp/homepage/dfp-wallpaper' ); ?>
            <?php 
                if ( is_active_sidebar( 'homepage_breaking_news' ) ) :
                    dynamic_sidebar( 'homepage_breaking_news' ); 
                endif;
            ?>
            <div class="row">
                <div class="large-12 content-wrapper">
                        <div class="row">
                            <div class="large-12 columns dfp-atf-leaderboard show-for-medium-up">
                                <?php get_template_part( 'parts/dfp/homepage/dfp-atf-leaderboard' ); ?>
                            </div>
                            <div class="large-12 columns dfp-mobile-leaderboard show-for-small-only">
                                <?php get_template_part( 'parts/dfp/homepage/dfp-mobile-leaderboard' ); ?>
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
</div>
<?php get_template_part( 'parts/homepage/footer' ); ?>
<?php get_footer(); ?>
