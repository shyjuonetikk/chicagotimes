<script type='text/javascript'>
	var googletag = googletag || {};
	googletag.cmd = googletag.cmd || [];
	var CSTAdTags = {};
	(function() {
		var gads = document.createElement('script');
		gads.async = true;
		gads.type = 'text/javascript';
		var useSSL = 'https:' == document.location.protocol;
		gads.src = (useSSL ? 'https:' : 'http:') + 
		'//www.googletagservices.com/tag/js/gpt.js';
		var node = document.getElementsByTagName('script')[0];
		node.parentNode.insertBefore(gads, node);
	})();
</script>

<?php
	$dfp_child = get_queried_object();
	$dfp_child_slug = $dfp_child->slug;
	if( isset( $dfp_child_slug ) && ! empty( $dfp_child_slug ) ) {
		switch( $dfp_child_slug ) {
			case 'baseball':
				get_template_part( 'parts/dfp/sports/dfp-sports-baseball' );
				break;
			case 'cubs':
				get_template_part( 'parts/dfp/sports/dfp-sports-baseball-cubs' );
				break;
			case 'whitesox':
				get_template_part( 'parts/dfp/sports/dfp-sports-baseball-whitesox' );
				break;
			case 'basketball':
				get_template_part( 'parts/dfp/sports/dfp-sports-basketball' );
				break;
			case 'bulls':
				get_template_part( 'parts/dfp/sports/dfp-sports-basketball-bulls' );
				break;
			case 'football':
				get_template_part( 'parts/dfp/sports/dfp-sports-football' );
				break;
			case 'bears':
				get_template_part( 'parts/dfp/sports/dfp-sports-football-bears' );
				break;
			case 'hockey':
				get_template_part( 'parts/dfp/sports/dfp-sports-hockey' );
				break;
			case 'blackhawks':
				get_template_part( 'parts/dfp/sports/dfp-sports-hockey-blackhawks' );
				break;
			case 'soccer':
				get_template_part( 'parts/dfp/sports/dfp-sports-soccer' );
				break;
			case 'fire':
				get_template_part( 'parts/dfp/sports/dfp-sports-soccer-fire' );
				break;
			case 'commentary':
				get_template_part( 'parts/dfp/sports/dfp-sports-commentary' );
				break;
			case 'colleges':
				get_template_part( 'parts/dfp/sports/dfp-sports-colleges' );
				break;
			default:
				get_template_part( 'parts/dfp/sports/dfp-sports-header-index' );
				break;
		}
	}
