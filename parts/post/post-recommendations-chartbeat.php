<?php
if ( $obj ) {
	$chartbeat_slug = 'chicago%20news';
	$section_name   = 'News';
	$post_sections  = $obj->get_section_slugs();
	if ( $post_sections ) {
		if ( in_array( 'dear-abby', $post_sections, true ) || in_array( 'dear-abby-lifestyles', $post_sections, true ) ) :
			$chartbeat_slug = 'dear%20abby';
			$section_name   = 'Dear Abby';
		else :
			$primary_section = $obj->get_primary_parent_section();
			$section_name    = $primary_section->name;
			$chartbeat_slug  = $primary_section->slug;
			if ( 'news' === $chartbeat_slug ) {
				$chartbeat_slug = 'chicago%20news';
			}
		endif;
	}
	$feed_url = 'https://api.chartbeat.com/live/toppages/v3/?apikey=' . CST_CHARTBEAT_API_KEY . '&host=chicago.suntimes.com&section=chicago%20news,%20sports,%20entertainment,%20lifestyles,%20columnists,%20politics,features&all_platforms=1&types=1&limit=6&metrics=post_id';
	CST()->frontend->cst_post_recommendation_block( $feed_url, $section_name );
}
