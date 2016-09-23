<?php if ( is_page_template( 'page-monster.php' ) ) { return; } ?>
<script type='text/javascript'>
	var googletag = googletag || {};
	googletag.cmd = googletag.cmd || [];
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
<?php $parent_inventory = CST()->frontend->get_dfp_inventory(); ?>
<?php if ( is_page( 'yieldmo-homepage' ) ) { ?>
<script type='text/javascript'>
	googletag.cmd.push(function() {

		if ( window.innerWidth > 640 ) {
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [1,1], 'div-gpt-interstitial')
			.addService(googletag.pubads()).setTargeting("pos","1x1");
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [728, 90], 'div-gpt-atf-leaderboard')
			.addService(googletag.pubads()).setTargeting("pos","atf leaderboard");
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [[2, 2], [970, 90]], 'div-gpt-sbb')
			.addService(googletag.pubads()).setTargeting("pos","sbb");
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [970, 250], 'div-gpt-billboard')
			.addService(googletag.pubads()).setTargeting("pos","Billboard 970x250").setCollapseEmptyDiv(true,true);
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [970, 90], 'div-gpt-super-leaderboard')
			.addService(googletag.pubads()).setTargeting("pos","Super Leaderboard 970x90").setCollapseEmptyDiv(true,true);
		} else {
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [320, 50], 'div-gpt-mobile-leaderboard')
			.addService(googletag.pubads()).setTargeting("pos","mobile leaderboard")
			.setCollapseEmptyDiv(true,true);
		}
		if ( window.innerWidth > 767 ) {
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [728, 90], 'div-gpt-btf-leaderboard')
			.addService(googletag.pubads()).setTargeting("pos","btf leaderboard")
			.setCollapseEmptyDiv(true,true);
		}
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-1')
			.addService(googletag.pubads()).setTargeting("pos","rr cube 1");
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [[300, 250]], 'div-gpt-rr-cube-2')
			.addService(googletag.pubads()).setTargeting("pos","rr cube 2");
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [[300, 250]], 'div-gpt-rr-cube-3')
			.addService(googletag.pubads()).setTargeting("pos","rr cube 3");
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [[300, 250]], 'div-gpt-rr-cube-4')
			.addService(googletag.pubads()).setTargeting("pos","rr cube 4");
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-5')
			.addService(googletag.pubads()).setTargeting("pos","rr cube 5");
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-6')
			.addService(googletag.pubads()).setTargeting("pos","rr cube 6");
	googletag.pubads().enableSingleRequest();
	googletag.enableServices();
	});
</script>
<?php } else { ?>
<script type='text/javascript'>
	googletag.cmd.push(function() {

		if ( window.innerWidth > 640 ) {
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [1,1], 'div-gpt-interstitial')
			.addService(googletag.pubads()).setTargeting("pos","1x1");
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [728, 90], 'div-gpt-atf-leaderboard')
			.addService(googletag.pubads()).setTargeting("pos","atf leaderboard");
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [[2, 2], [970, 90]], 'div-gpt-sbb-1')
			.addService(googletag.pubads()).setTargeting("pos","sbb");
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [[970, 250],[970, 90],[970, 415],[728, 90],[320, 50],[300, 50]], 'div-gpt-billboard-1')
			.addService(googletag.pubads()).setTargeting("pos","Billboard 970x250").setCollapseEmptyDiv(true,true);
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [[970, 250],[970, 90],[970, 415],[728, 90],[320, 50],[300, 50]], 'div-gpt-billboard-2')
			.addService(googletag.pubads()).setTargeting("pos","Billboard 2 970x250").setCollapseEmptyDiv(true,true);
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [970, 90], 'div-gpt-super-leaderboard')
			.addService(googletag.pubads()).setTargeting("pos","Super leaderboard 970x90").setCollapseEmptyDiv(true,true);
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [970, 90], 'div-gpt-super-leaderboard-2')
			.addService(googletag.pubads()).setTargeting("pos","Super leaderboard 2 970x90").setCollapseEmptyDiv(true,true);
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [970, 90], 'div-gpt-super-leaderboard-3')
			.addService(googletag.pubads()).setTargeting("pos","Super leaderboard 2 970x90").setCollapseEmptyDiv(true,true);
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [970, 90], 'div-gpt-super-leaderboard-4')
			.addService(googletag.pubads()).setTargeting("pos","Super leaderboard 2 970x90").setCollapseEmptyDiv(true,true);
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [970, 90], 'div-gpt-super-leaderboard-5')
			.addService(googletag.pubads()).setTargeting("pos","Super leaderboard 2 970x90").setCollapseEmptyDiv(true,true);
		} else {
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [320, 50], 'div-gpt-mobile-leaderboard')
			.addService(googletag.pubads()).setTargeting("pos","mobile leaderboard")
			.setCollapseEmptyDiv(true,true);
		}
		if ( window.innerWidth > 767 ) {
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [ [970,90], [728, 90] ], 'div-gpt-btf-leaderboard')
			.addService(googletag.pubads()).setTargeting("pos","btf leaderboard")
			.setCollapseEmptyDiv(true,true);
		}
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-1')
			.addService(googletag.pubads()).setTargeting("pos","rr cube 1");
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [[300, 250]], 'div-gpt-rr-cube-2')
			.addService(googletag.pubads()).setTargeting("pos","rr cube 2");
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [[300, 250]], 'div-gpt-rr-cube-3')
			.addService(googletag.pubads()).setTargeting("pos","rr cube 3");
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [[300, 250]], 'div-gpt-rr-cube-4')
			.addService(googletag.pubads()).setTargeting("pos","rr cube 4");
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-5')
			.addService(googletag.pubads()).setTargeting("pos","rr cube 5");
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-6')
			.addService(googletag.pubads()).setTargeting("pos","rr cube 6");
		if ( window.innerWidth > 1256 ) {
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [184, 90], 'div-gpt-sponsor-ear-left')
				.addService(googletag.pubads()).setTargeting("pos","Sponsor Ear Left")
				.setCollapseEmptyDiv(true,true);
			googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.index' ); ?>, [184, 90], 'div-gpt-sponsor-ear-right')
				.addService(googletag.pubads()).setTargeting("pos","Sponsor Ear Right")
				.setCollapseEmptyDiv(true,true);
		}
	googletag.pubads().enableSingleRequest();
	googletag.enableServices();
	});
</script>
<?php }
