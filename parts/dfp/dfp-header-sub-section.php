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
        case 'health-care':
            $dfp_child = 'healthcare';
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
        case 'bill-zwecker-columnists':
            $dfp_child = 'billzwecker';
            break;
        case 'dale-bowman-columnists':
            $dfp_child = 'dalebowman';
            break;
        case 'dan-mihalopoulos':
            $dfp_child = 'danmihalopoulos';
            break;
        case 'hedy-weiss':
            $dfp_child = 'hedyweiss';
            break;
        case 'jeff-agrest-columnists':
            $dfp_child = 'jeffagrest';
            break;
        case 'ladd-biro-columnists':
            $dfp_child = 'laddbiro';
            break;
        case 'lynn-sweet-columnist':
            $dfp_child = 'lynnsweet';
            break;
        case 'rich-roeper':
            $dfp_child = 'richroeper';
            break;
        case 'rick-morrissey-columnists':
            $dfp_child = 'rickmorrissey';
            break;
        case 'rick-telander-columnists':
            $dfp_child = 'ricktelander';
            break;
        case 'steve-greenberg-columnists':
            $dfp_child = 'stevegreenberg';
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
        case 'entertainment-news':
            $dfp_child = 'dailysizzle';
            break;
        case 'hedy-weiss-entertainment':
            $dfp_child = 'hedyweiss';
            break;
        case 'celebrity':
            $dfp_child = 'people';
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
        case 'chicago-celebrities':
            $dfp_child = 'celebspotting';
            break;
        case 'dining-chicago':
            $dfp_child = 'eatdrink';
            break;
        case 'health-fitness':
            $dfp_child = 'healthfitness';
            break;
        case 'visual-arts':
            $dfp_child = 'visualarts';
            break;
        // Lifestyles Sub-Sections
        case '80-destinations':
            $dfp_child = '80destinations';
            break;
        case 'mid-west':
            $dfp_child = 'midwest';
            break;
        case 'dear-abby':
            $dfp_child = 'dearabby';
            break;
        case 'health-fitness':
            $dfp_child = 'healthfitness';
            break;
        case 'relationship-advice':
            $dfp_child = 'relationshipadvice';
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
<?php $parent_inventory = CST()->frontend->get_dfp_inventory(); ?>
<script type='text/javascript'>
    googletag.cmd.push(function() {

        if ( window.innerWidth > 640 ) {
            CSTAdTags['div-gpt-sbb'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [2,2], 'div-gpt-sbb')
            .addService(googletag.pubads())
            .setTargeting("pos","SBB");
            
            CSTAdTags['div-gpt-wallpaper'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [1363, 1000], 'div-gpt-wallpaper')
            .addService(googletag.pubads())
            .setTargeting("pos","wallpaper");

            CSTAdTags['div-gpt-interstitial'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [1, 1], 'div-gpt-interstitial')
            .addService(googletag.pubads())
            .setTargeting("pos","1x1");

            CSTAdTags['div-gpt-atf-leaderboard'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [728, 90], 'div-gpt-atf-leaderboard')
            .addService(googletag.pubads())
            .setTargeting("pos","atf leaderboard");

            CSTAdTags['div-gpt-btf-leaderboard'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [728, 90], 'div-gpt-btf-leaderboard')
            .addService(googletag.pubads())
            .setTargeting("pos","btf leaderboard");   

<?php if( is_singular() ) : ?>

            CSTAdTags['div-gpt-sky-scraper'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [160, 600], 'div-gpt-sky-scraper')
            .addService(googletag.pubads())
            .setTargeting("pos","SkyScraper");

            CSTAdTags['div-gpt-rr-cube-promo'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-rr-cube-promo')
            .addService(googletag.pubads())
            .setTargeting("pos","rr cube promo");

<?php endif; ?>


        } else {

            CSTAdTags['div-gpt-mobile-leaderboard'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [320, 50], 'div-gpt-mobile-leaderboard')
            .addService(googletag.pubads())
            .setTargeting("pos","mobile leaderboard");

    <?php if( is_singular() ) : ?>

            CSTAdTags['div-gpt-ym-craig'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-ym-craig')
            .addService(googletag.pubads())
            .setTargeting("pos","ym craig")
            .setCollapseEmptyDiv(true,true);

    <?php endif; ?>

        }

        CSTAdTags['div-gpt-rr-cube-1'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-rr-cube-1')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 1");

        CSTAdTags['div-gpt-rr-cube-2'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-rr-cube-2')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 2");

        CSTAdTags['div-gpt-rr-cube-3'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-rr-cube-3')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 3");

<?php if( is_tax() ) : ?>

        CSTAdTags['div-gpt-rr-cube-4'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-4')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 4");

        CSTAdTags['div-gpt-rr-cube-5'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-5')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 5");

        CSTAdTags['div-gpt-rr-cube-6'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [[300, 250], [300, 600]], 'div-gpt-rr-cube-6')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 6");

        CSTAdTags['div-gpt-rr-cube-promo'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-rr-cube-promo')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube promo");

        CSTAdTags['div-gpt-billboard'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [970, 250], 'div-gpt-billboard')
        .addService(googletag.pubads())
        .setTargeting("pos","Billboard 970x250")
        .setCollapseEmptyDiv(true,true);

	    CSTAdTags['div-gpt-super-leaderboard'] = googletag.defineSlot(<?php echo wp_json_encode('/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ); ?>, [970, 90], 'div-gpt-super-leaderboard')
		    .addService(googletag.pubads())
		    .setTargeting("pos","Super Leaderboard 970x90")
		    .setCollapseEmptyDiv(true,true);

<?php else : ?>

        CSTAdTags['div-gpt-rr-cube-4'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-rr-cube-4')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 4");

        CSTAdTags['div-gpt-rr-cube-5'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-rr-cube-5')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 5");

        CSTAdTags['div-gpt-rr-cube-6'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-rr-cube-6')
        .addService(googletag.pubads())
        .setTargeting("pos","rr cube 6");
        
<?php endif; ?>

<?php if( is_single() ) : ?>
        CSTAdTags['div-gpt-gallery-1'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-gallery-1')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 1");

        CSTAdTags['div-gpt-gallery-2'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-gallery-2')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 2");
        
        CSTAdTags['div-gpt-gallery-3'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-gallery-3')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 3");

        CSTAdTags['div-gpt-gallery-4'] = googletag.defineSlot(<?php echo wp_json_encode( '/61924087/' . $parent_inventory . '/chicago.suntimes.com.' . $dfp_parent . '/chicago.suntimes.com.' . $dfp_parent . '.' . $dfp_child ) ?>, [300, 250], 'div-gpt-gallery-4')
        .addService(googletag.pubads())
        .setTargeting("pos","gallery 4");
<?php endif; ?>
        // Enable services
        googletag.enableServices();

    });
</script>
