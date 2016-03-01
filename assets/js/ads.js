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

			if ( $('body.single').length ) {
				this.startPost = 2;
				this.betweenPosts = 1;
			} else {
				this.startPost = 14;
				this.betweenPosts = 6;
			}

			this.bindEvents();

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
			} else {
				var el2 = $('#div-gpt-rr-cube-5');
				var nextScrollUnit2 = 'div-gpt-rr-cube-5';
			}
			
			$('#main .ad-container').eq( this.startPost ).append( el );
			$('#main .ad-container').eq( this.startPost ).append( el2 );
			this.triggerUnitRefresh( nextScrollUnit );
			this.triggerUnitRefresh( nextScrollUnit2 );

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

			if ( this.currentScrollUnit === 'div-gpt-rr-cube-2' ) {
				this.currentScrollUnit = 'div-gpt-rr-cube-4';
			} else {
				this.currentScrollUnit = 'div-gpt-rr-cube-2';
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

		}

	};

	/**
	 * Wait until the document is ready before initializing the ads
	 */
	$(document).ready(function(){
		CSTAds.init();
	});

}( jQuery ) );
