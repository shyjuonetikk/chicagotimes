<?php
    $post_sections = $obj->get_section_slugs();
    print_r($post_sections);
    if( in_array( 'dear-abby', $post_sections ) ) :
        $query = array(
                    'post_type'             => array( 'cst_article' ),
                    'ignore_sticky_posts'   => true,
                    'posts_per_page'        => 5,
                    'post_status'           => 'publish',
                    'cst_section'           => 'dear-abby',
                );
                CST()->frontend->cst_recommendation_block( $query );
    endif;
?>