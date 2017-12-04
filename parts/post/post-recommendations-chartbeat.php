<?php
if ( $obj ) {
	$feed_url = 'https://api.chartbeat.com/live/toppages/v3/?apikey=' . CST_CHARTBEAT_API_KEY . '&host=chicago.suntimes.com&section=chicago%20news,%20sports,%20entertainment,%20lifestyles,%20columnists,%20politics,features&all_platforms=1&types=1&limit=8&metrics=post_id';
	CST()->frontend->cst_post_recommendation_block( $feed_url );
}
