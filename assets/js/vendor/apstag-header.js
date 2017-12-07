//Helper function
//Get Browser Window Dimensions -- Used in parseSizeMappings
function getWindowDimensions() {
  var width = window.innerWidth ||
    document.documentElement.clientWidth ||
    document.body.clientWidth;
  var height = window.innerHeight ||
    document.documentElement.clientHeight ||
    document.body.clientHeight;
  return [width, height];
}


// given a size mapping like: [[[1000, 600], [[300, 250], [300,600]]],[[0,0], [[300,250]]]]
// return the valid size mapping as an array like: [[300,250]] when the screen dimensions
// are less than 1000 width and 600 height
function parseSizeMappings(sizeMappings) {
  try{ 
    // get current window dimensions
    var sd = getWindowDimensions();
 
    // filter mappings that are valid by confirming that the current screen dimensions
    // are both greater than or equal to the breakpoint [x, y] minimums specified in the first position in the mapping
    var validMappings = sizeMappings.filter(function(m) {return  m[0][0] <= sd[0] && m[0][1] <= sd[1]});
    document.write("<br><br><br><br><br><br><br/>validMappings ", validMappings, "<br />sizeMappings ", sizeMappings);

    // return the leftmost mapping's sizes or an empty array
    return validMappings.length > 0 ? validMappings[0][1] :  [];
  } catch (e) {
    console.log('error parsing sizeMappings:')
    console.log(sizeMappings);
    console.log(e);
    document.write("In catch area ", sizeMappings);
    // fallback to last size mapping supplied 
    return sizeMappings[ sizeMappings.length -1 ][1];
    document.write("In catch area ", sizeMappings);
    //document.write(" In catch area sizeMappings ", sizeMappings);
  } 
}
//document.write(" In catch area sizeMappings ", sizeMappings);  


 var googletag = googletag || {}; googletag.cmd = googletag.cmd || [];

  googletag.cmd.push(function() {
    //var sizeMappingBoxes = googletag.sizeMapping().
    var sizeMappings = googletag.sizeMapping().
    addSize([0, 0], [0, 0]).
    addSize([320, 560], [300, 250]). //mobile
    addSize([700, 1000], [300, 250]). //tablet
    addSize([1050, 200], [[160, 600], [300, 50], [300, 250], [300,600], [728, 90], [970, 90], [970, 250]]). //desktop
    //addSize([300, 600]).
    //addSize([728, 90]).
    //addSize([980, 690], [[300, 250], [300,600]]).
    //addSize([500, 500], [300, 250]).
    //addSize([0,0], []).
    build();

    //confirmed ad sizes 728x90, 300x250, 300x600, 160x600, 970x90, 970x250, 320x50


//parseSizeMappings();
var a9mappings = parseSizeMappings(sizeMappings);
//window["parseSizeMappings"](sizeMappings);

    //googletag.defineSlot('/61924087/test-a9', [300, 250], 'div-gpt-ad-test-a9').defineSizeMapping(sizeMappings).addService(googletag.pubads());  
    //googletag.defineSlot('/61924087/slot2', [300, 600], 'div-gpt-ad-test2-a9').defineSizeMapping(sizeMappings).addService(googletag.pubads());  
    //googletag.defineSlot('/61924087/slot3', [728, 90], 'div-gpt-ad-leaderboard-a9').defineSizeMapping(sizeMappings).addService(googletag.pubads()); 
    //googletag.defineSlot('/61924087/slot3', [728, 90], 'div-gpt-atf-leaderboard-1').defineSizeMapping(sizeMappings).addService(googletag.pubads()); 

    //googletag.defineSlot('/61924087/test-a9', [300, 250], 'div-gpt-ad-cube1-a9').defineSizeMapping(googletag.validMappings).addService(googletag.pubads());  
    //googletag.defineSlot('/61924087/slot2', [300, 600], 'div-gpt-ad-cube2-a9').defineSizeMapping(googletag.validMappings).addService(googletag.pubads());  
    //googletag.defineSlot('/61924087/slot3', [728, 90], 'div-gpt-ad-leaderboard-a9').defineSizeMapping(googletag.validMappings).addService(googletag.pubads()); 
    //googletag.defineSlot('/61924087/slot3', [728, 90], 'div-gpt-atf-leaderboard-1').defineSizeMapping(googletag.sizeMappings).addService(googletag.pubads()); 

    googletag.defineSlot('/61924087/test-a9', [300, 250], 'div-gpt-ad-cube1-a9').defineSizeMapping(a9mappings).addService(googletag.pubads());  
    googletag.defineSlot('/61924087/slot2', [300, 600], 'div-gpt-ad-cube2-a9').defineSizeMapping(a9mappings).addService(googletag.pubads());  
    googletag.defineSlot('/61924087/slot3', [728, 90], 'div-gpt-ad-leaderboard-a9').defineSizeMapping(a9mappings).addService(googletag.pubads()); 
    googletag.defineSlot('/61924087/slot3', [728, 90], 'div-gpt-ad-leaderboard-1').defineSizeMapping(a9mappings).addService(googletag.pubads()); 


    googletag.pubads().disableInitialLoad();
    googletag.pubads().enableSingleRequest();
    googletag.enableServices();
  });  


  //!function(a9,a,p,s,t,A,g){if(a[a9])return;function q(c,r){a[a9]._Q.push([c,r])}a[a9]={init:function(){q("i",arguments)},fetchBids:function(){q("f",arguments)},setDisplayBids:function(){},targetingKeys:function(){return[]},_Q:[]};A=p.createElement(s);A.async=!0;A.src=t;g=p.getElementsByTagName(s)[0];g.parentNode.insertBefore(A,g)}("apstag",window,document,"script","//c.amazon-adsystem.com/aax2/apstag.js");
  !function(a9,a,p,s,t,A,g){if(a[a9])return;function q(c,r){a[a9]._Q.push([c,r])}a[a9]={init:function(){q("i",arguments)},fetchBids:function(){q("f",arguments)},setDisplayBids:function(){},_Q:[]};A=p.createElement(s);A.async=!0;A.src=t;g=p.getElementsByTagName(s)[0];g.parentNode.insertBefore( A,g)}("apstag",window,document,"script","//c.amazon-adsystem.com/aax2/apstag.js");


  // initialize apstag and have apstag set bids on the googletag slots when they are returned to the page
  apstag.init({
  pubID: '3443', adServer: 'googletag', videoAdServer: 'DFP', bidTimeout: 2e3
  });

  // request the bids for the four googletag slots
  apstag.fetchBids({
    slots: [{
      slotID: 'div-gpt-ad-cube1-a9',
      slotName: 'test-a9',
      sizes: [[300, 250]] 
    },
    {
      slotID: 'div-gpt-ad-cube2-a9',
      slotName: 'test2-a9', 
      sizes: [[300, 600]]  
    },
    {
      slotID: 'div-gpt-ad-leaderboard-a9',
      slotName: 'leaderboard-a9',
      sizes: [[728, 90]]  
    },
    {
     slotID: 'div-gpt-ad-leaderboard-1',
     slotName: 'leaderboard-1',
     sizes: [[970, 90], [728, 90]] 
     //sizes: [[728, 90]] 
    }]
  },

   function(bids) {
    // set apstag bids, then trigger the first request to DFP
    googletag.cmd.push(function() { apstag.setDisplayBids(); googletag.pubads().refresh();  

   });
  });



