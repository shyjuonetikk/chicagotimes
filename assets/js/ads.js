// Production steps of ECMA-262, Edition 5, 15.4.4.18
// Reference: http://es5.github.io/#x15.4.4.18
if (!Array.prototype.forEach) {

  Array.prototype.forEach = function(callback, thisArg) {

    var T, k;

    if (this === null) {
      throw new TypeError(' this is null or not defined');
    }

    // 1. Let O be the result of calling toObject() passing the
    // |this| value as the argument.
    var O = Object(this);

    // 2. Let lenValue be the result of calling the Get() internal
    // method of O with the argument "length".
    // 3. Let len be toUint32(lenValue).
    var len = O.length >>> 0;

    // 4. If isCallable(callback) is false, throw a TypeError exception.
    // See: http://es5.github.com/#x9.11
    if (typeof callback !== "function") {
      throw new TypeError(callback + ' is not a function');
    }

    // 5. If thisArg was supplied, let T be thisArg; else let
    // T be undefined.
    if (arguments.length > 1) {
      T = thisArg;
    }

    // 6. Let k be 0
    k = 0;

    // 7. Repeat, while k < len
    while (k < len) {

      var kValue;

      // a. Let Pk be ToString(k).
      //    This is implicit for LHS operands of the in operator
      // b. Let kPresent be the result of calling the HasProperty
      //    internal method of O with argument Pk.
      //    This step can be combined with c
      // c. If kPresent is true, then
      if (k in O) {

        // i. Let kValue be the result of calling the Get internal
        // method of O with argument Pk.
        kValue = O[k];

        // ii. Call the Call internal method of callback with T as
        // the this value and argument list containing kValue, k, and O.
        callback.call(T, kValue, k, O);
      }
      // d. Increase k by 1.
      k++;
    }
    // 8. return undefined
  };
}
var CSTAds;

(function( $ ){

	CSTAds = {

    refreshing: false,
    adTimer: 0,
    isSection: false,
    isSingular: false,
    content_body: false,
		scrollUnits: [
			'div-gpt-rr-cube-2',
			'div-gpt-rr-cube-3',
			'div-gpt-rr-cube-4',
			'div-gpt-rr-cube-5'
		],

		currentScrollUnit: '',

		loadedUnits: {},

		/**
		 * Initialize basic ads JavaScript
		 */
		init: function() {
      CSTAds.content_body = $('body');
      if ( CSTAds.content_body.hasClass('tax-cst_section') ) {
        CSTAds.isSection = true;
      }
      if ( CSTAds.content_body.hasClass('single') ) {
        CSTAds.isSingular = true;
      }
      this.clearAndResetAdRefreshInterval();
      console.info('Initializing Ad interval')
		},

    clearAndResetAdRefreshInterval: function() {
      CSTAds.AdTimer = setInterval( CSTAds.refreshArticleCubeAds , 60000 );
    },

		/**
		 * Trigger refresh of the ad unit
		 */
		triggerUnitRefresh: function( unit ) {

			if ( 'undefined' !== typeof CSTAdTags[unit] ) {
        if ( undefined !== CSTAdTags[unit].doNotRefresh && !CSTAdTags[unit].doNotRefresh ) {
          googletag.cmd.push(function () {
            var unitInstance = CSTAdTags[unit];
            googletag.pubads().refresh([unitInstance]);
          });
          console.info( 'Refreshed ' .concat(unit) );
        }
      }

		},
    refreshAllArticleAds: function() {
      if ( CSTAds.isSingular && ! CSTAds.refreshing && ! CSTAds.content_body.hasClass( "post-gallery-lightbox-active" ) ) {
        CSTAds.refreshing = true;
        var tags_to_refresh = Object.keys(CSTAdTags);
        tags_to_refresh.forEach(function(ad_slot) {
          CSTAds.triggerUnitRefresh(ad_slot)
        })
        CSTAds.refreshing = false;
      console.info('All ad units refreshed and interval reset')
      }

    },
    refreshArticleCubeAds: function() {
      if ( CSTAds.isSingular && ! CSTAds.refreshing && ! CSTAds.content_body.hasClass( "post-gallery-lightbox-active" ) ) {
        console.info('Interval expired. Refreshing Cube Ads');
        CSTAds.refreshing = true;
        var tags_to_refresh = Object.keys(CSTAdTags);
        tags_to_refresh.forEach(function (ad_slot) {
          if (ad_slot.match(/rr-cube-[0-9]{1,3}$/)) {
              CSTAds.triggerUnitRefresh(ad_slot)
          }
        })
        CSTAds.refreshing = false;
      }
    },
    handleGptVisibility: function(event) {
		  var slotId = event.slot.getSlotElementId();
      console.log('Slot visibility changed for: ' + slotId + ' to ' + event.inViewPercentage );
      event.inViewPercentage <= 15 ? CSTAdTags[slotId].doNotRefresh = true :  CSTAdTags[slotId].doNotRefresh = false;
    },
    handleGptImpressionViewability: function (event) {
      var slotId = event.slot.getSlotElementId();
      console.log('Slots ' + slotId + ' available for viewable impressions.');
      CSTAdTags[slotId].doNotRefresh = false;
    }
	};

	/**
	 * Wait until the document is ready before initializing the ads
	 */
	$(document).ready(function(){
		CSTAds.init();
	});

}( jQuery ) );
