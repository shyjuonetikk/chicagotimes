var CSTAnalytics;

(function( $ ){

	CSTAnalytics = {

		currentURL: window.location.href,
		initialPageview: true,

		eventCategory: false,
		eventAction: false,
		eventLabel: false,

		init: function(){

			this.triggerPageview();

		},

		triggerPageview: function() {

			var data = {
				title: document.title,
				location: this.currentURL,
				page: this.currentURL.replace( window.location.origin, '' )
			};

			var i;

			// Add custom vars on single post.
			if ( CSTAnalyticsData.is_singular ) {

				// Document isn't ready yet, so we take our dimensions via JS variable
				if ( this.initialPageview ) {

					for ( i = 1; i <= 5; i++ ) {
						if ( typeof CSTAnalyticsData['dimension'+i] != 'undefined' ) {
							data['dimension'+i] = CSTAnalyticsData['dimension'+i];
						}
					}

					this.initialPageview = false;
				} else {

					if ( typeof this.main == 'undefined' ) {
						this.main = $('#main');
					}

					var activeScrollPost = this.main.find('.cst-active-scroll-post');
					for ( i = 1; i <= 5; i++ ) {
						if ( activeScrollPost.data('cst-ga-dimension-'+i).length ) {
							data['dimension'+i] = activeScrollPost.data('cst-ga-dimension-'+i);
						}
					}
				}

			}

			adblock_div = jQuery('<div />');
	        adblock_div.attr( 'class', 'afs_ads' );
	        jQuery('body').append(adblock_div);

			if( ! document.getElementsByClassName) return;
		    var ads = document.getElementsByClassName('afs_ads'),
		        ad  = ads[ads.length - 1];

		    if( ! ad
		        || ad.innerHTML.length == 0
		        || ad.clientHeight === 0) {
		    	data['dimension10'] = 1;
		    } else {
		    	data['dimension10'] = 0;
		    }

			ga('BNA.send', 'pageview', data );
			ga('networkGlobal.send', 'pageview');

			if ( typeof window.pSUPERFLY == 'object' ) {
				window.pSUPERFLY.virtualPage( this.currentURL.replace( window.location.origin, '' ), document.title );
			}

		},

		triggerEventTrack: function( e ) {

			var eventData = {};

			eventData['eventCategory'] 	= this.eventCategory;
			eventData['eventAction'] 	= this.eventAction;
			eventData['eventLabel'] 	= this.eventLabel;

			ga( 'send', 'event', eventData  );
		}

	};

	// Don't wait until the document is ready.
	CSTAnalytics.init();

}( jQuery ) );
