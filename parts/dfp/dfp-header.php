<?php global $dfp_slug; ?>
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
<?php $parent_inventory = CST()->frontend->get_dfp_inventory(); ?>
<?php if ( $dfp_slug !== 'yieldmo' ) { ?>
<script type='text/javascript'>
	googletag.cmd.push(function() {

		if ( window.innerWidth > 640 ) {
			CSTAdTags['div-gpt-sbb'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [2,2], 'div-gpt-sbb')
			.addService(googletag.pubads())
			.setTargeting("pos","SBB");
			
			CSTAdTags['div-gpt-wallpaper'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [1363, 1000], 'div-gpt-wallpaper')
			.addService(googletag.pubads())
			.setTargeting("pos","wallpaper");

			CSTAdTags['div-gpt-interstitial'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [1, 1], 'div-gpt-interstitial')
			.addService(googletag.pubads())
			.setTargeting("pos","1x1");

			CSTAdTags['div-gpt-atf-leaderboard'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [728, 90], 'div-gpt-atf-leaderboard')
			.addService(googletag.pubads())
			.setTargeting("pos","atf leaderboard");

			CSTAdTags['div-gpt-btf-leaderboard'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [728, 90], 'div-gpt-btf-leaderboard')
			.addService(googletag.pubads())
			.setTargeting("pos","btf leaderboard");

<?php if( is_singular() ) : ?>

            CSTAdTags['div-gpt-sky-scraper'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [160, 600], 'div-gpt-sky-scraper')
            .addService(googletag.pubads())
            .setTargeting("pos","SkyScraper");

            CSTAdTags['div-gpt-rr-cube-promo'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [300, 250], 'div-gpt-rr-cube-promo')
			.addService(googletag.pubads())
			.setTargeting("pos","rr cube promo");

<?php endif; ?>

		} else {

			CSTAdTags['div-gpt-atf-leaderboard'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [320, 50], 'div-gpt-mobile-leaderboard')
			.addService(googletag.pubads())
			.setTargeting("pos","mobile leaderboard");

        <?php if( is_singular() ) : ?>

            CSTAdTags['div-gpt-ym-craig'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [300, 250], 'div-gpt-ym-craig')
            .addService(googletag.pubads())
            .setTargeting("pos","ym craig")
            .setCollapseEmptyDiv(true,true);

        <?php endif; ?>

		}

		CSTAdTags['div-gpt-rr-cube-1'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [300, 250], 'div-gpt-rr-cube-1')
		.addService(googletag.pubads())
		.setTargeting("pos","rr cube 1");

		CSTAdTags['div-gpt-rr-cube-2'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [300, 250], 'div-gpt-rr-cube-2')
		.addService(googletag.pubads())
		.setTargeting("pos","rr cube 2");

		CSTAdTags['div-gpt-rr-cube-3'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [300, 250], 'div-gpt-rr-cube-3')
		.addService(googletag.pubads())
		.setTargeting("pos","rr cube 3");

<?php if( is_tax() ) : ?>

		CSTAdTags['div-gpt-rr-cube-4'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-4')
		.addService(googletag.pubads())
		.setTargeting("pos","rr cube 4");

		CSTAdTags['div-gpt-rr-cube-5'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-5')
		.addService(googletag.pubads())
		.setTargeting("pos","rr cube 5");

		CSTAdTags['div-gpt-rr-cube-6'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-6')
		.addService(googletag.pubads())
		.setTargeting("pos","rr cube 6");

        CSTAdTags['div-gpt-rr-cube-promo'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [300, 250], 'div-gpt-rr-cube-promo')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube promo");

		CSTAdTags['div-gpt-billboard'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [970, 250], 'div-gpt-billboard')
        .addService(googletag.pubads())
        .setTargeting("pos","Billboard 970x250")
        .setCollapseEmptyDiv(true,true);
		CSTAdTags['div-gpt-super-leaderboard-1'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index' ); ?>, [970, 90], 'div-gpt-super-leaderboard-1')
		.addService(googletag.pubads())
		.setTargeting("pos","Super Leaderboard 970x90")
		.setCollapseEmptyDiv(true,true);
		CSTAdTags['div-gpt-super-leaderboard-2'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index' ); ?>, [970, 90], 'div-gpt-super-leaderboard-2')
		.addService(googletag.pubads())
		.setTargeting("pos","Super Leaderboard 2 970x90")
		.setCollapseEmptyDiv(true,true);

<?php else : ?>

		CSTAdTags['div-gpt-rr-cube-4'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [300, 250], 'div-gpt-rr-cube-4')
		.addService(googletag.pubads())
		.setTargeting("pos","rr cube 4");

		CSTAdTags['div-gpt-rr-cube-5'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [300, 250], 'div-gpt-rr-cube-5')
		.addService(googletag.pubads())
		.setTargeting("pos","rr cube 5");

		CSTAdTags['div-gpt-rr-cube-6'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [300, 250], 'div-gpt-rr-cube-6')
		.addService(googletag.pubads())
		.setTargeting("pos","rr cube 6");

<?php endif; ?>

		CSTAdTags['div-gpt-gallery-1'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [300, 250], 'div-gpt-gallery-1')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 1");

        CSTAdTags['div-gpt-gallery-2'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [300, 250], 'div-gpt-gallery-2')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 2");
        
        CSTAdTags['div-gpt-gallery-3'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [300, 250], 'div-gpt-gallery-3')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 3");

        CSTAdTags['div-gpt-gallery-4'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_slug . '/chicago.suntimes.com.' . $dfp_slug . '.index'); ?>, [300, 250], 'div-gpt-gallery-4')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 4");

		// Enable services
		googletag.enableServices();

	});
</script>

<?php } else { ?>
    <?php get_template_part( 'parts/dfp/dfp-yieldmo' ); ?>
<?php } ?>