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


			// this.bindEvents();

		},

		/**
		 * Bind events happening within the theme
		 */
		bindEvents: function() {

			$(window).scroll( $.proxy( function() {
				setTimeout( $.proxy( this.doScrollEvent, this ), 1 );
			}, this ) );

		},

		/**
		 * Events that might need to happen when scrolling
		 */
		doScrollEvent: function() {

			var scrollTop = $(window).scrollTop();

			var post = $('#main article.post').eq(this.startPost);
			// Load the next cube when there are enough posts
			// and the iframe is getting close to the viewport
			if ( post.length && ( post.offset().top + 200 ) < ( $(window).height() + scrollTop ) ) {
				this.displayNextScrollAd();
			}

			// If there's a placeholder getting close to the top
			var placeholder = $('#main .ad-container .dfp-wire-cube-placeholder').last();
			if ( placeholder.length && ( placeholder.offset().top + placeholder.outerHeight() ) > ( scrollTop - 200 ) ) {
				this.displayPreviousScrollAd();
			}

		},

		/**
		 * Load the first cube on initial page load, then alternate between
		 */
		displayNextScrollAd: function() {

			var nextScrollUnit = this.getNextScrollUnit();

			// Create the next unit if it isn't created,
			var el = $( '#' + nextScrollUnit );
			
			if( nextScrollUnit == 'div-gpt-rr-cube-2' ) {
				var el2 = $('#div-gpt-rr-cube-3');
				var nextScrollUnit2 = 'div-gpt-rr-cube-3';

				$('#main .ad-container').eq( this.startPost ).append( el );
				$('#main .ad-container').eq( this.startPost ).append( el2 );
				this.triggerUnitRefresh( nextScrollUnit );
				this.triggerUnitRefresh( nextScrollUnit2 );
				this.triggerUnitRefresh( 'div-gpt-rr-cube-5' );
				this.triggerUnitRefresh( 'div-gpt-rr-cube-6' );
			} else {
				$('#main .ad-container').eq( this.startPost ).append( el );
				this.triggerUnitRefresh( nextScrollUnit );
				this.triggerUnitRefresh( nextScrollUnit2 );
				this.triggerUnitRefresh( 'div-gpt-rr-cube-5' );
				this.triggerUnitRefresh( 'div-gpt-rr-cube-6' );
			}
			
			this.startPost = this.startPost + this.betweenPosts;
		
		},

		/**
		 * Swap out the closest placeholder with the previous ad
		 */
		displayPreviousScrollAd: function() {

			var placeholder = $('#main .ad-container').last();
			var prevScrollUnit = this.getPreviousScrollUnit();
			var el = $('#'+prevScrollUnit);
			if( prevScrollUnit == 'div-gpt-rr-cube-2' ) {
				var el2 = $('#div-gpt-rr-cube-3');
				var prevScrollUnit2 = 'div-gpt-rr-cube-3';
			} else {
				var el2 = $('#div-gpt-rr-cube-5');
				var prevScrollUnit2 = 'div-gpt-rr-cube-5';
			}
			placeholder.after( el );
			placeholder.after( el2 );
			placeholder.remove();

			this.triggerUnitRefresh( prevScrollUnit );
			this.triggerUnitRefresh( prevScrollUnit2 );
			this.startPost = this.startPost - this.betweenPosts;

		},

		/**
		 * Get the next scroll unit
		 *
		 * @todo actually navigate the array
		 */
		getNextScrollUnit: function() {

			if( jQuery('.cst-active-scroll-post').length ) {
				if ( this.currentScrollUnit === 'div-gpt-rr-cube-2' ) {
					this.currentScrollUnit = 'div-gpt-atf-leaderboard-1';
				} else {
					this.currentScrollUnit = 'div-gpt-rr-cube-2';
				}
			} else {
				if ( this.currentScrollUnit === 'div-gpt-rr-cube-2' ) {
					this.currentScrollUnit = 'div-gpt-rr-cube-4';
				} else {
					this.currentScrollUnit = 'div-gpt-rr-cube-2';
				}
			}

			return this.currentScrollUnit;
		},

		/**
		 * Get the previous scroll unit
		 *
		 * @todo actually navigate the array
		 */
		getPreviousScrollUnit: function() {

			if ( this.currentScrollUnit === 'div-gpt-rr-cube-2' ) {
				this.currentScrollUnit = 'div-gpt-rr-cube-4';
			} else {
				this.currentScrollUnit = 'div-gpt-rr-cube-2';
			}

			return this.currentScrollUnit;

		},

		/**
		 * Trigger refresh of the ad unit
		 */
		triggerUnitRefresh: function( unit ) {

			if ( typeof CSTAdTags[unit] !== 'undefined' ) {
				googletag.cmd.push( function() {
					var unitInstance = CSTAdTags[unit];
					googletag.pubads().refresh([unitInstance]);
				});
            } 

		},
    refreshArticle: function() {
      var tags_to_refresh = Object.keys(CSTAdTags);
      tags_to_refresh.forEach(function(ad_slot) {
        if ( ad_slot.match(/rr-cube-[0-9]{1,3}$/) ) {
          if ( 'undefined' !== typeof CSTAdTags[ad_slot] ) {
            var unitInstance = CSTAdTags[ad_slot];
            console.log('Triggering refresh for ' + unitInstance );
            googletag.cmd.push(function() {
              googletag.pubads().refresh(unitInstance);
            })
          }
        }
      })
    }

	};

	/**
	 * Wait until the document is ready before initializing the ads
	 */
	$(document).ready(function(){
		CSTAds.init();
	});

}( jQuery ) );
