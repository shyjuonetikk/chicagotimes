(function( $ ){

	var CST_CustomPage = {

		/**
		 * Initialize basic theme JavaScript
		 */
		init: function() {

      this.jobs_navigation_link = $('.jobs-navigation-link a');
			if ( $(window).width() <= 667 ) {
				this.jobs_navigation_link.attr('href', 'http://m.suntimes.com/' );
			} else {
				this.jobs_navigation_link.attr('href', 'http://jobs.suntimes.com' );
			}

		}

	};

	/**
	 * Wait until the document is ready before initializing the theme
	 */
	$(document).ready(function(){

		$(document).foundation();

		CST_CustomPage.init();

	});

}( jQuery ) );
