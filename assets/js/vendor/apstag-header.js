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
/* Defing the slot sizes here. If allowed here it overrides the sizes in the fetchBids*/
googletag.defineSlot('/61924087/slot1', [[300, 250], [728, 90]], 'div-gpt-ad-test-a9').defineSizeMapping(sizeMappingBoxes).addService(googletag.pubads());  
googletag.defineSlot('/61924087/slot2', [[300, 600]], 'div-gpt-ad-test2-a9').defineSizeMapping(sizeMappingBoxes).addService(googletag.pubads());  
googletag.defineSlot('/61924087/slot3', [[728, 90]], 'div-gpt-ad-leaderboard-a9').defineSizeMapping(sizeMappingBoxes).addService(googletag.pubads()); 
googletag.defineSlot('/61924087/slot4', [728, 90], 'div-gpt-atf-leaderboard-1').defineSizeMapping(sizeMappingBoxes).addService(googletag.pubads());
// DFP matched slots
googletag.defineSlot('/61924087/slot1', [[728, 90], [970, 90]], 'div-gpt-ad-top-leaderboard').defineSizeMapping(sizeMappingBoxes).addService(googletag.pubads()); 
googletag.defineSlot('/61924087/slot2', [[300, 250], [300, 600]], 'div-gpt-ad-cube1').defineSizeMapping(sizeMappingBoxes).addService(googletag.pubads()); 
googletag.defineSlot('/61924087/slot3', [[300, 250], [300, 600]], 'div-gpt-ad-cube2').defineSizeMapping(sizeMappingBoxes).addService(googletag.pubads()); 
googletag.defineSlot('/61924087/slot4', [[160, 600]], 'div-gpt-ad-sky1').defineSizeMapping(sizeMappingBoxes).addService(googletag.pubads()); 
googletag.defineSlot('/61924087/slot5', [[160, 600]], 'div-gpt-ad-sky2').defineSizeMapping(sizeMappingBoxes).addService(googletag.pubads()); 
googletag.defineSlot('/61924087/slot6', [[970, 250]], 'div-gpt-ad-need-defined').defineSizeMapping(sizeMappingBoxes).addService(googletag.pubads()); 
googletag.defineSlot('/61924087/slot7', [[320, 50]], 'div-gpt-atf-leaderboard-1').defineSizeMapping(sizeMappingBoxes).addService(googletag.pubads()); 
googletag.defineSlot('/61924087/slot8', [[320, 50]], 'div-gpt-placement-a-535').defineSizeMapping(sizeMappingBoxes).addService(googletag.pubads()); 

googletag.pubads().disableInitialLoad(); 
googletag.pubads().enableSingleRequest(); 
googletag.enableServices();
});

// Begin Step 1
!function(a9,a,p,s,t,A,g){if(a[a9])return;function q(c,r){a[a9]._Q.push([c,r])}a[a9]={init:function(){q("i",arguments)},fetchBids:function()
{q("f",arguments)},setDisplayBids:function(){},_Q:[]};A=p.createElement(s);A.async=!0;A.src=t;g=p.getElementsByTagName(s)[0];g.parentNode.insertBefore( A,g)}("apstag",window,document,"script","//c.amazon-adsystem.com/aax2/apstag.js");
// initialize apstag and have apstag set bids on the googletag slots when they are returned to the page


apstag.init({
pubID: '3443', adServer: 'googletag', bidTimeout: 2e3
});
// End Step 1 

// Begin step 2
// request the bids for the four googletag slots
apstag.fetchBids({ 
	slots: [
		{
		slotID: 'div-gpt-ad-test-a9',
		sizes: [[300, 250]],
		slotName: 'test-a9'  
		},
		{
		slotID: 'div-gpt-ad-test2-a9',
		sizes: [[300, 600]],
		slotName: 'test2-a9'   
		},
		{
		slotID: 'div-gpt-ad-leaderboard-a9',
		sizes: [[728, 90]],
		slotName: 'leaderboard-a9'   
		},
		{
		slotID: 'div-gpt-atf-leaderboard-1',
		sizes: [[970, 90], [728, 90]],
		slotName: 'atf-leaderboard-1'   
		},
		{
		slotID: 'div-gpt-placement-a-535',
		sizes: [[728, 90]],
		slotName: 'placement-a-535'   
		},
	]
}, function(bids) {

// Begin Step 3
// trigger the first request to DFP
googletag.cmd.push(function() { apstag.setDisplayBids(); googletag.pubads().refresh();
}); });
