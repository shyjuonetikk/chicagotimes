(function( $ ){

	var CSTAds = {

		scrollUnits: [
			'div-gpt-wire-cube-1',
			'div-gpt-wire-cube-2'
		],

		currentScrollUnit: '',

		loadedUnits: {},

		/**
		 * Initialize basic ads JavaScript
		 */
		init: function() {

			if ( $('body.single').length ) {
				this.startPost = 6;
				this.betweenPosts = 3;
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
			var placeholder = $('#main .dfp-wire-cube-placeholder').last();
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
			var placeholder = $('<div />').addClass('dfp dfp-cube dfp-wire-cube-placeholder' );
			// we need a placeholder to prevent a lurch
			el.before( placeholder );

			$('#main article.post').eq( this.startPost ).after( el );
			this.triggerUnitRefresh( nextScrollUnit );

			this.startPost = this.startPost + this.betweenPosts;

		},

		/**
		 * Swap out the closest placeholder with the previous ad
		 */
		displayPreviousScrollAd: function() {

			var placeholder = $('#main .dfp-wire-cube-placeholder').last();
			var prevScrollUnit = this.getPreviousScrollUnit();
			var el = $('#'+prevScrollUnit);
			placeholder.after( el );
			placeholder.remove();

			this.triggerUnitRefresh( prevScrollUnit );
			this.startPost = this.startPost - this.betweenPosts;

		},

		/**
		 * Get the next scroll unit
		 *
		 * @todo actually navigate the array
		 */
		getNextScrollUnit: function() {

			if ( this.currentScrollUnit === 'div-gpt-wire-cube-1' ) {
				this.currentScrollUnit = 'div-gpt-wire-cube-2';
			} else {
				this.currentScrollUnit = 'div-gpt-wire-cube-1';
			}

			return this.currentScrollUnit;
		},

		/**
		 * Get the previous scroll unit
		 *
		 * @todo actually navigate the array
		 */
		getPreviousScrollUnit: function() {

			if ( this.currentScrollUnit === 'div-gpt-wire-cube-1' ) {
				this.currentScrollUnit = 'div-gpt-wire-cube-2';
			} else {
				this.currentScrollUnit = 'div-gpt-wire-cube-1';
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
