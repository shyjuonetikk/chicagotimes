(function( $ ){

	var CST_Homepage = {

		/**
		 * Initialize basic theme JavaScript
		 */
		init: function() {

			this.cacheElements();
			this.bindEvents();
			this.dfpWallpaper.css( 'top', this.header.height() + this.breakingNews.height() );

		},

		/**
		 * Cache elements to object-level variables
		 */
		cacheElements: function() {

			this.body = $('body');
			this.primaryNavigation = $('#fixed-nav-wrapper');
			this.topLogos = $('#top-logos');
      this.wpAdminBar = $('#wpadminbar');

			this.scrollToolbarHeight = this.primaryNavigation.outerHeight();
			if ( this.wpAdminBar.length ) {
				this.scrollToolbarHeight += this.wpAdminBar.outerHeight();
			}

			this.breakingNews = $('.breaking-news-story');
			this.breakingNewsClose = $('.close-breaking-news');
			this.bearsCube = $('.bears-cube-story');
			this.bearsCubeClose = $('.close-bears-cube');
			this.dfpWallpaper = $('#div-gpt-wallpaper');
			this.header = $('header');
			this.dfpSBB = $('#div-gpt-sbb');
			this.sbbTop = $('#dfp-sbb-top');
			this.sbbBottom = $('#dfp-sbb-bottom');
			this.interstitial = $('#div-gpt-interstitial');
			this.interstitialContainer = $('#dfp-interstitial-container');
			this.closeInterstitial = $('#dfp-interstitial-close');
			this.searchButton = $('#search-button');
			this.searchInput = $('#search-input');

		},

		/**
		 * Bind events happening within the theme
		 */
		bindEvents: function() {

			$(window).scroll( $.proxy( function() {
				setTimeout( $.proxy( this.doScrollEvent, this ), 1 );
			}, this ) );

			this.breakingNewsClose.on( "click", $.proxy( function (e) {
				e.preventDefault();
				this.breakingNews.css('display', 'none');
			}, this ) );

			this.bearsCubeClose.on( "click", $.proxy( function (e) {
				e.preventDefault();
				this.bearsCube.css('display', 'none');
			}, this ) );

			this.dfpSBB.mouseover(function() {
				this.sbbTop.hide();
				this.sbbBottom.show();
			}).mouseout(function() {
				this.sbbTop.show();
				this.sbbBottom.hide();
			});

			this.closeInterstitial.on( "click", $.proxy( function (e) {
				e.preventDefault();
				this.interstitial.css('display', 'none');
				this.interstitialContainer.css('display', 'none');
			}, this ) );

			this.searchButton.on( "click", $.proxy( function (e) {

				e.preventDefault();

				if( this.searchButton.hasClass('search-in')) {
					this.searchButton.removeClass('search-in').addClass('search-out');
				} else {
					this.searchButton.removeClass('search-out').addClass('search-in');
				}

				if ( this.searchInput.is(':visible') ) {

					if ( this.searchInput.val().length ) {
						this.searchInput.closest('form').trigger( 'submit' );
					} else {
						this.searchInput.toggle( "slide", { direction: "right" }  );
					}
				} else {

					this.searchInput.toggle( "slide", { direction: "right" } );
				}
			}, this ) );

		},

		/**
		 * Events that might need to happen when scrolling
		 */
		doScrollEvent: function() {

			var scrollTop = $(window).scrollTop();

			if ( scrollTop > this.topLogos.height() ) {

				// Primary Navigation
				if ( this.wpAdminBar && $(window).width() > 782 ) {
					if ( this.primaryNavigation.hasClass('fixed') ) {
						this.primaryNavigation.css( 'top', this.wpAdminBar.height() );
					}
				}

			} else {

				// Primary Navigation
				if ( this.wpAdminBar ) {
					if ( this.primaryNavigation.removeClass('fixed') ) {
						this.primaryNavigation.removeAttr('style');
					}
				}

			}

			if( scrollTop >= ( this.header.height() + 120 + this.breakingNews.height() ) ) {
				if( this.dfpWallpaper.hasClass('dfp-wallpaper-normal') ) {
					this.dfpWallpaper.removeClass('dfp-wallpaper-normal').addClass('dfp-wallpaper-fixed');
					this.dfpWallpaper.css( 'top', 122 );
				} else {
					this.dfpWallpaper.addClass('dfp-wallpaper-fixed');
				}
			} else if( scrollTop < ( this.header.height() + this.breakingNews.height() ) ) {
				if( this.dfpWallpaper.hasClass('dfp-wallpaper-fixed') ) {
					this.dfpWallpaper.removeClass('dfp-wallpaper-fixed').addClass('dfp-wallpaper-normal');
					this.dfpWallpaper.css( 'top', this.header.height() + this.breakingNews.height() + 125 );
				} else {
					this.dfpWallpaper.addClass('dfp-wallpaper-normal');
				}
			}


		}

	};

	/**
	 * Wait until the document is ready before initializing the theme
	 */
	$(document).ready(function(){

		$(document).foundation();

		CST_Homepage.init();

	});

}( jQuery ) );
