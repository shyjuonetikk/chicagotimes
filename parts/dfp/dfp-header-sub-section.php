<?php 
    global $dfp_child; 
    global $dfp_parent;

    switch( $dfp_child ) {

        // News Sub-Sections
        case 'nation-world':
            $dfp_child = 'nation.world';
            break;
        case 'the-watchdogs':
            $dfp_child = 'thewatchdogs';
            break;
        // Opinion Sub-Sections
        case 'letters':
            $dfp_child = 'letterstotheeditor';
            break;
        // Columnists Sub-Sections
        case 'mark-brown':
            $dfp_child = 'markbrown';
            break;
        case 'mary-mitchell':
            $dfp_child = 'marymitchell';
            break;
        case 'neil-steinberg':
            $dfp_child = 'neilsteinberg';
            break;
        case 'sneed-columnist':
            $dfp_child = 'sneed';
            break;
        // Politics Sub-Sections
        case 'chicago-politics':
            $dfp_child = 'chicago';
            break;
        case 'springfield-politics':
            $dfp_child = 'springfield';
            break;
        case 'washington-politics':
            $dfp_child = 'washington';
            break;
        case 'lynn-sweet-politics':
            $dfp_child = 'lynnsweet';
            break;
        // Entertainment Sub-Sections
        case 'architecture-and-design':
            $dfp_child = 'architecture';
            break;
        case 'bill-zwecker':
            $dfp_child = 'billzwecker';
            break;
        case 'daily-sizzle':
            $dfp_child = 'dailysizzle';
            break;
        case 'stage-reviews':
            $dfp_child = 'stagereviews';
            break;
        case 'movie-reviews':
            $dfp_child = 'moviereviews';
            break;
        case 'music-reviews':
            $dfp_child = 'musicreviews';
            break;
        case 'television-reviews':
            $dfp_child = 'televisionreviews';
            break;
        case 'the-312':
            $dfp_child = 'the312';
            break;
        case 'celeb-spotting':
            $dfp_child = 'celebspotting';
            break;
        case 'eat-drink':
            $dfp_child = 'eatdrink';
            break;
        case 'health-fitness':
            $dfp_child = 'healthfitness';
            break;
        case 'visual-arts':
            $dfp_child = 'visualarts';
            break;
        // Sports Sub-Sections
        case 'white-sox':
            $dfp_child = 'whitesox';
            break;
        case 'rick-morrissey':
            $dfp_child = 'rickmorrissey';
            break;
        case 'rick-telander':
            $dfp_child = 'ricktelander';
            break;
        case 'other-sports':
            $dfp_child = 'othersports';
            break;
        // Lifestyles Sub-Sections
        case '80-destinations':
            $dfp_child = '80destinations';
            break;
        case 'mid-west':
            $dfp_child = 'midwest';
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
            CSTAdTags['div-gpt-sbb'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [2,2], 'div-gpt-sbb')
            .addService(googletag.pubads())
            .setTargeting("pos","SBB");
            
            CSTAdTags['div-gpt-wallpaper'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [1363, 1000], 'div-gpt-wallpaper')
            .addService(googletag.pubads())
            .setTargeting("pos","wallpaper");

            CSTAdTags['div-gpt-interstitial'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [1, 1], 'div-gpt-interstitial')
            .addService(googletag.pubads())
            .setTargeting("pos","1x1");

            CSTAdTags['div-gpt-atf-leaderboard'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [728, 90], 'div-gpt-atf-leaderboard')
            .addService(googletag.pubads())
            .setTargeting("pos","atf leaderboard");

            CSTAdTags['div-gpt-btf-leaderboard'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [728, 90], 'div-gpt-btf-leaderboard')
            .addService(googletag.pubads())
            .setTargeting("pos","btf leaderboard");

            CSTAdTags['div-gpt-gallery-1'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-gallery-1')
            .addService(googletag.pubads())
            .setTargeting("pos","gallery 1");

            CSTAdTags['div-gpt-gallery-2'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-gallery-2')
            .addService(googletag.pubads())
            .setTargeting("pos","gallery 2");
            
            CSTAdTags['div-gpt-gallery-3'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-gallery-3')
            .addService(googletag.pubads())
            .setTargeting("pos","gallery 3");

            CSTAdTags['div-gpt-gallery-4'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-gallery-4')
            .addService(googletag.pubads())
            .setTargeting("pos","gallery 4");           


        } else {

            CSTAdTags['div-gpt-mobile-leaderboard'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [728, 90], 'div-gpt-mobile-leaderboard')
            .addService(googletag.pubads())
            .setTargeting("pos","mobile leaderboard");

        }

        CSTAdTags['div-gpt-rr-cube-1'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-rr-cube-1')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 1");

        CSTAdTags['div-gpt-rr-cube-2'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-rr-cube-2')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 2");

        CSTAdTags['div-gpt-rr-cube-3'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-rr-cube-3')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 3");

        CSTAdTags['div-gpt-rr-cube-4'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-rr-cube-4')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 4");

        CSTAdTags['div-gpt-rr-cube-5'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-rr-cube-5')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 5");

        CSTAdTags['div-gpt-rr-cube-6'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-rr-cube-6')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 6");

        CSTAdTags['div-gpt-gallery-1'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-gallery-1')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 1");

        CSTAdTags['div-gpt-gallery-2'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-gallery-2')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 2");
        
        CSTAdTags['div-gpt-gallery-3'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-gallery-3')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 3");

        CSTAdTags['div-gpt-gallery-4'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/chicago.suntimes.com/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-gallery-4')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 4");

        // Enable services
        googletag.enableServices();

    });
</script>
