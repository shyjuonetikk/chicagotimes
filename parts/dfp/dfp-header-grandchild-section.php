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

<script type='text/javascript'>
    googletag.cmd.push(function() {

        if ( window.innerWidth > 640 ) {
            CSTAdTags['div-gpt-sbb'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [2,2], 'div-gpt-sbb')
            .addService(googletag.pubads())
            .setTargeting("pos","SBB");
            
            CSTAdTags['div-gpt-wallpaper'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [1363, 1000], 'div-gpt-wallpaper')
            .addService(googletag.pubads())
            .setTargeting("pos","wallpaper");

            CSTAdTags['div-gpt-interstitial'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [1, 1], 'div-gpt-interstitial')
            .addService(googletag.pubads())
            .setTargeting("pos","1x1");

            CSTAdTags['div-gpt-atf-leaderboard'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [728, 90], 'div-gpt-atf-leaderboard')
            .addService(googletag.pubads())
            .setTargeting("pos","atf leaderboard");

            CSTAdTags['div-gpt-btf-leaderboard'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [728, 90], 'div-gpt-btf-leaderboard')
            .addService(googletag.pubads())
            .setTargeting("pos","btf leaderboard");    

<?php if( is_singular() ) : ?>

            CSTAdTags['div-gpt-sky-scraper'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [160, 600], 'div-gpt-sky-scraper')
            .addService(googletag.pubads())
            .setTargeting("pos","SkyScraper");

<?php endif; ?>


        } else {

            CSTAdTags['div-gpt-mobile-leaderboard'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [728, 90], 'div-gpt-mobile-leaderboard')
            .addService(googletag.pubads())
            .setTargeting("pos","mobile leaderboard");

        }

        CSTAdTags['div-gpt-rr-cube-1'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [300, 250], 'div-gpt-rr-cube-1')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 1");

        CSTAdTags['div-gpt-rr-cube-2'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [300, 250], 'div-gpt-rr-cube-2')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 2");

        CSTAdTags['div-gpt-rr-cube-3'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [300, 250], 'div-gpt-rr-cube-3')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 3");

<?php if( is_tax() ) : ?>

        CSTAdTags['div-gpt-rr-cube-4'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-4')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 4");

        CSTAdTags['div-gpt-rr-cube-5'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-5')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 5");

        CSTAdTags['div-gpt-rr-cube-6'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-6')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 6");

        CSTAdTags['div-gpt-billboard'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [970, 250], 'div-gpt-billboard')
        .addService(googletag.pubads())
        .setTargeting("pos","Billboard 970x250")
        .setCollapseEmptyDiv(true,true);

<?php else : ?>

        CSTAdTags['div-gpt-rr-cube-4'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [300, 250], 'div-gpt-rr-cube-4')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 4");

        CSTAdTags['div-gpt-rr-cube-5'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [300, 250], 'div-gpt-rr-cube-5')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 5");

        CSTAdTags['div-gpt-rr-cube-6'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [300, 250], 'div-gpt-rr-cube-6')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 6");

<?php endif; ?>

<?php if( is_single() ) : ?>
        CSTAdTags['div-gpt-gallery-1'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [300, 250], 'div-gpt-gallery-1')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 1");

        CSTAdTags['div-gpt-gallery-2'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [300, 250], 'div-gpt-gallery-2')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 2");
        
        CSTAdTags['div-gpt-gallery-3'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [300, 250], 'div-gpt-gallery-3')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 3");

        CSTAdTags['div-gpt-gallery-4'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child .'.' . $dfp_grandchild ) ?>, [300, 250], 'div-gpt-gallery-4')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 4");
<?php endif; ?>
        // Enable services
        googletag.enableServices();

    });
</script>
