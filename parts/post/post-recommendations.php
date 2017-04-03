<?php
    $post_sections = $obj->get_section_slugs();
    if( in_array( 'dear-abby', $post_sections ) ) :
        $query = array(
                    'post_type'             => array( 'cst_article' ),
                    'ignore_sticky_posts'   => true,
                    'posts_per_page'        => 4,
                    'post_status'           => 'publish',
                    'orderby'               => 'rand',
                    'cst_section'           => 'dear-abby',
                );
        CST()->frontend->cst_dear_abby_recommendation_block( $query );
    endif;
