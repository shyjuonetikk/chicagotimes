(function( $ ){

	var CSTEventsTracking = {

		init: function() {

			this.loadLatest 			= $('#load-latest');
			this.carouselHeadline 		= $('.slide-text a');
			this.carouselArrowNext 		= $('.header-next');
			this.carouselArrowPrev 		= $('.header-prev');
			this.trending		 		= $('.menu-trending-container a');

			this.bindEvents();
		},

		bindEvents: function() {

			this.loadLatest.on( 'click', $.proxy( function( e ) {

				CSTAnalytics.eventAction 	= 'Click';
				CSTAnalytics.eventCategory 	= 'Button';
				CSTAnalytics.eventLabel 	= 'LoadLatest';

				CSTAnalytics.triggerEventTrack();

			}, this) );

			this.carouselHeadline.on( 'click', $.proxy( function( e ) {

				CSTAnalytics.eventAction 	= 'Click';
				CSTAnalytics.eventCategory 	= 'Carousel';
				CSTAnalytics.eventLabel 	= 'Headline';

				CSTAnalytics.triggerEventTrack();

			}, this) );

			this.articleComments.on( 'click', $.proxy( function( e ) {

				CSTAnalytics.eventAction 	= 'Click';
				CSTAnalytics.eventCategory 	= 'Comments';
				CSTAnalytics.eventLabel 	= 'Open';

				CSTAnalytics.triggerEventTrack();

			}, this) );

			this.articleCommentsOpen.on( 'click', $.proxy( function( e ) {

				CSTAnalytics.eventAction 	= 'Click';
				CSTAnalytics.eventCategory 	= 'Comments';
				CSTAnalytics.eventLabel 	= 'Close';

				CSTAnalytics.triggerEventTrack();

			}, this) );

			this.trending.on( 'click', $.proxy( function( e ) {

				CSTAnalytics.eventAction 	= 'Click';
				CSTAnalytics.eventCategory 	= 'Trending';
				CSTAnalytics.eventLabel 	= 'Tag';

				CSTAnalytics.triggerEventTrack();

			}, this) );

			this.carouselArrowNext.on( 'click', $.proxy( function( e ) {

				this.eventArrows();

			}, this) );

			this.carouselArrowPrev.on( 'click', $.proxy( function( e ) {

				this.eventArrows();

			}, this) );

		},

		eventArrows: function() {

			CSTAnalytics.eventAction 	= 'Click';
			CSTAnalytics.eventCategory 	= 'Carousel';
			CSTAnalytics.eventLabel 	= 'Arrows';

			CSTAnalytics.triggerEventTrack();

		}

	};

	$(document).ready(function(){

		CSTEventsTracking.init();

	});
}( jQuery ) );