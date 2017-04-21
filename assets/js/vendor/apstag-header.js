var googletag = googletag || {}; googletag.cmd = googletag.cmd || [];
googletag.cmd.push(function() {
var sizeMappingBoxes = googletag.sizeMapping().
addSize([300,250]).
/*
addSize([980, 690], [[300, 250], [300,600]]).
addSize([500, 500], [300, 250]).
addSize([0,0], []).
*/
build();
googletag.defineSlot('/61924087/slot1', [[300, 250], [728, 90]], 'div-gpt-ad-test-a9').defineSizeMapping(sizeMappingBoxes).addService(googletag.pubads());    
googletag.pubads().disableInitialLoad(); 
googletag.pubads().enableSingleRequest(); 
googletag.enableServices();
});

!function(a9,a,p,s,t,A,g){if(a[a9])return;function q(c,r){a[a9]._Q.push([c,r])}a[a9]={init:function(){q("i",arguments)},fetchBids:function()
{q("f",arguments)},setDisplayBids:function(){},_Q:[]};A=p.createElement(s);A.async=!0;A.src=t;g=p.getElementsByTagName(s)[0];g.parentNode.insertBefore( A,g)}("apstag",window,document,"script","//c.amazon-adsystem.com/aax2/apstag.js");
// initialize apstag and have apstag set bids on the googletag slots when they are returned to the page
apstag.init({
pubID: '3443', adServer: 'googletag', bidTimeout: 2e3
});
// request the bids for the four googletag slots
apstag.fetchBids({ slots: [{
slotID: 'div-gpt-ad-test-a9',
sizes: [[300, 250]] },
]
}, function(bids) {
// trigger the first request to DFP
googletag.cmd.push(function() { apstag.setDisplayBids(); googletag.pubads().refresh();
}); });