<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function()
{ (i[r].q=i[r].q||[]).push(arguments)}
,i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-52083976-1', 'auto', {name: 'BNA'});
ga('BNA.require', 'displayfeatures');
ga('create', 'UA-53290409-1', 'auto', {name: 'networkGlobal'});
ga('networkGlobal.require', 'displayfeatures');
<?php
// taken from here: http://www.labnol.org/internet/track-404-error-pages/13509/
if ( is_404() ) { ?>
/* Track 404 Errors */
var url = "/404/?url=" + window.location.pathname + window.location.search + "&from=" + document.referrer;
ga('send', 'pageview', url);
<?php } ?>
</script>