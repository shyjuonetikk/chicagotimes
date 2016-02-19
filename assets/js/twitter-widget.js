(function( $ ){

	var CST_Twitter_Widget = {

		init: function() {

			this.cacheElements();
			this.tweetContainer.slick({
				dots: true,
				onInit: function( e ){
					e.$slider.parent().show();
				},
				prevArrow: '<i class="fa fa-chevron-left twitter-widget-prev"></i>',
				nextArrow: '<i class="fa fa-chevron-right twitter-widget-next"></i>'
			});

		},

		cacheElements: function() {

			this.tweetContainer = $('.widget .tweet-tweet');

		}

	};

	$(document).ready(function(){

		CST_Twitter_Widget.init();

	});

}( jQuery ) );