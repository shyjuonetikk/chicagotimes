<?php
if( $obj ) {
    $chartbeat_slug = 'news';
    $section_name   = 'News';
    $post_sections  = $obj->get_section_slugs();
    if( $post_sections ) {
        if( in_array( 'dear-abby', $post_sections ) || in_array( 'dear-abby-lifestyles', $post_sections ) ) :
            $chartbeat_slug = 'dear%20abby';
            $section_name   = 'Dear Abby';
        else :
            $primary_section    = $obj->get_primary_parent_section();
            $section_name       = $primary_section->name;  
            $chartbeat_slug     = $primary_section->slug;
        endif;
    }
    $feed_url = 'http://api.chartbeat.com/live/toppages/v3/?apikey=' . CST_CHARTBEAT_API_KEY . '&host=chicago.suntimes.com&section=' . $chartbeat_slug . '&sort_by=returning&now_on=1&limit=4';
    CST()->frontend->cst_post_recommendation_block( $feed_url, $section_name );
}
?>