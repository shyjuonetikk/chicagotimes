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

<script type='text/javascript'>
    googletag.cmd.push(function() {

        if ( window.innerWidth > 640 ) {
            googletag.defineSlot('/61924087/chicago.suntimes.com/chicago.suntimes.com.index', [1,1], 'div-gpt-interstitial')
            .addService(googletag.pubads()).setTargeting("pos","1x1");
            googletag.defineSlot('/61924087/chicago.suntimes.com/chicago.suntimes.com.index', [728, 90], 'div-gpt-atf-leaderboard')
            .addService(googletag.pubads()).setTargeting("pos","atf leaderboard");
            googletag.defineSlot('/61924087/chicago.suntimes.com/chicago.suntimes.com.index', [728, 90], 'div-gpt-btf-leaderboard')
            .addService(googletag.pubads()).setTargeting("pos","btf leaderboard");
        } else {
            googletag.defineSlot('/61924087/chicago.suntimes.com/chicago.suntimes.com.index', [728, 90], 'div-gpt-mobile-leaderboard')
            .addService(googletag.pubads()).setTargeting("pos","mobile leaderboard");   
        }
    googletag.pubads().enableSingleRequest();
    googletag.enableServices();
    });
</script>
