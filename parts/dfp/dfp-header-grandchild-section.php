<?php 
    global $dfp_child;
    global $dfp_grandchild;
    global $dfp_parent;

    switch( $dfp_grandchild ) {

        // Entertainment Sub-Sections
        case 'stage-reviews':
            $dfp_grandchild = 'stagereviews';
            break;
        case 'movie-reviews':
            $dfp_grandchild = 'moviereviews';
            break;
        case 'music-reviews':
            $dfp_grandchild = 'musicreviews';
            break;
        case 'television-reviews':
            $dfp_grandchild = 'televisionreviews';
            break;
        case 'celeb-spotting':
            $dfp_grandchild = 'celebspotting';
            break;
        case 'eat-drink':
            $dfp_grandchild = 'eatdrink';
            break;
        case 'health-fitness':
            $dfp_grandchild = 'healthfitness';
            break;
        case 'visual-arts':
            $dfp_grandchild = 'visualarts';
            break;
        // Sports Sub-Sections
        case 'cubs-baseball':
            $dfp_grandchild = 'cubs';
            break;
        case 'white-sox':
            $dfp_grandchild = 'whitesox';
            break;
        case 'bears-football':
            $dfp_grandchild = 'bears';
            break;
        case 'blackhawks-hockey':
            $dfp_grandchild = 'blackhawks';
            break;
        case 'fire-soccer':
            $dfp_grandchild = 'fire';
            break;
        case 'rick-morrissey':
            $dfp_grandchild = 'rickmorrissey';
            break;
        case 'rick-telander':
            $dfp_grandchild = 'ricktelander';
            break;
        case 'dale-bowman':
            $dfp_grandchild = 'dalebowman';
            break;
        case 'ladd-biro':
            $dfp_grandchild = 'laddbiro';
            break;
        case 'jeff-agrest':
            $dfp_grandchild = 'jeffagrest';
            break;
        case 'steve-greenberg':
            $dfp_grandchild = 'stevegreenberg';
            break;
        case 'other-sports':
            $dfp_grandchild = 'othersports';
            break;
        default:
            break;
    }
?>
<?php $parent_inventory = CST()->dfp_handler->get_parent_dfp_inventory(); ?>
<script type='text/javascript'>
    googletag.cmd.push(function() {

        if ( window.innerWidth > 640 ) {
            CSTAdTags['div-gpt-sbb'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [2,2], 'div-gpt-sbb')
            .addService(googletag.pubads())
            .setTargeting("pos","SBB");

            CSTAdTags['div-gpt-interstitial'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [1, 1], 'div-gpt-interstitial')
            .addService(googletag.pubads())
            .setTargeting("pos","1x1");

<?php if( is_singular() ) : ?>

            CSTAdTags['div-gpt-sky-scraper'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [160, 600], 'div-gpt-sky-scraper')
            .addService(googletag.pubads())
            .setTargeting("pos","SkyScraper");

            CSTAdTags['div-gpt-rr-cube-promo'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [300, 250], 'div-gpt-rr-cube-promo')
            .addService(googletag.pubads())
            .setTargeting("pos","rr cube promo");

<?php endif; ?>


        } else {

            CSTAdTags['div-gpt-mobile-leaderboard'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [728, 90], 'div-gpt-mobile-leaderboard')
            .addService(googletag.pubads())
            .setTargeting("pos","mobile leaderboard");

    <?php if( is_singular() ) : ?>

            CSTAdTags['div-gpt-ym-craig'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [300, 250], 'div-gpt-ym-craig')
            .addService(googletag.pubads())
            .setTargeting("pos","ym craig")
            .setCollapseEmptyDiv(true,true);

    <?php endif; ?>

        }

        CSTAdTags['div-gpt-rr-cube-1'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [300, 250], 'div-gpt-rr-cube-1')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 1");

        CSTAdTags['div-gpt-rr-cube-2'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [300, 250], 'div-gpt-rr-cube-2')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 2");

        CSTAdTags['div-gpt-rr-cube-3'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [300, 250], 'div-gpt-rr-cube-3')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 3");

<?php if( is_tax() ) : ?>

        CSTAdTags['div-gpt-rr-cube-4'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-4')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 4");

        CSTAdTags['div-gpt-rr-cube-5'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-5')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 5");

        CSTAdTags['div-gpt-rr-cube-6'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-6')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 6");

        CSTAdTags['div-gpt-rr-cube-promo'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [300, 250], 'div-gpt-rr-cube-promo')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube promo");

        CSTAdTags['div-gpt-billboard'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [[970, 250],[970, 90],[728, 90],[970, 415]], 'div-gpt-billboard')
        .addService(googletag.pubads())
        .setTargeting("pos","Billboard 970x250")
        .setCollapseEmptyDiv(true,true);

	    CSTAdTags['div-gpt-super-leaderboard-2'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild  ); ?>, [[970, 90],[728, 90], [320, 50], [300, 50]], 'div-gpt-super-leaderboard-2')
		    .addService(googletag.pubads())
		    .setTargeting("pos","Super Leaderboard 2 970x90")
		    .setCollapseEmptyDiv(true,true);
<?php else : ?>

        CSTAdTags['div-gpt-rr-cube-4'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [300, 250], 'div-gpt-rr-cube-4')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 4");

        CSTAdTags['div-gpt-rr-cube-5'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [[300, 250],[300,600]], 'div-gpt-rr-cube-5')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 5");

        CSTAdTags['div-gpt-rr-cube-6'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [[300, 250],[300,600]], 'div-gpt-rr-cube-6')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 6");

<?php endif; ?>

<?php if( is_single() ) : ?>
        CSTAdTags['div-gpt-gallery-1'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [[300, 250], [320,50], [300,50]], 'div-gpt-gallery-1')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 1");

        CSTAdTags['div-gpt-gallery-2'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [[300, 250], [320,50], [300,50]], 'div-gpt-gallery-2')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 2");
        
        CSTAdTags['div-gpt-gallery-3'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [[300, 250], [320,50], [300,50]], 'div-gpt-gallery-3')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 3");

        CSTAdTags['div-gpt-gallery-4'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [[300, 250], [320,50], [300,50]], 'div-gpt-gallery-4')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 4");
<?php endif; ?>
        // Enable services
        googletag.enableServices();

    });
</script>
