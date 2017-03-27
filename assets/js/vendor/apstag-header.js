
 !function(a9,a,p,s,t,A,g){if(a[a9])return;function q(c,r){a[a9]._Q.push([c,r])}a[a9]={init:function(){q("i",arguments)},fetchBids:function(){q("f",arguments)},setDisplayBids:function(){},_Q:[]};A=p.createElement(s);A.async=!0;A.src=t;g=p.getElementsByTagName(s)[0];g.parentNode.insertBefore(A,g)}("apstag",window,document,"script","//c.amazon-adsystem.com/aax2/apstag.js");
 apstag.init({
     pubID: '3443',
     adServer: 'googletag'
 });
 apstag.fetchBids({
     slots: [{
         slotID: 'div-gpt-ad-1475102693815-0',
         sizes: [[300, 250], [300, 600]]
     },
     {
         slotID: 'div-gpt-ad-1475185990716-0',
         sizes: [[728 ,90]]
     }], 
     timeout: 2e3
 }, function(bids) {
     // Your callback method, in this example it triggers the first DFP request for googletag's disableInitialLoad integration after bids have been set
     googletag.cmd.push(function(){
         apstag.setDisplayBids();
         googletag.pubads().refresh();
     });
 });
