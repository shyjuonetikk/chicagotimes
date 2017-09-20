(function( $ ){

  var CSTPage = {

    init: function () {
      this.bindEvents();
    },
    bindEvents: function() {
      var delayedTimer = false;
      $(window).resize( $.proxy( function() {
        if ( delayedTimer ) {
          clearTimeout( delayedTimer );
        }
        delayedTimer = setTimeout( $.proxy( function(){
          CSTPage.responsiveIframes();
        }, this ), 30 );
      }, this ) );
    },
    /**
     * Make some iframes responsive
     */
    responsiveIframes: function() {

      pageHeight = 800;
      pageWidth = 750;
      $('iframe.cst-page-responsive').each(function(){
        var ouriFrame = $(this),
          parentWidth = ouriFrame.parent().width();
        var trueHeight = ouriFrame.data('true-height') ? ouriFrame.data('true-height') : pageHeight;
        var trueWidth = ouriFrame.data('true-width') ? ouriFrame.data('true-width') : pageWidth;
        var newHeight = ( parentWidth / trueHeight ) * trueWidth;
        if ( newHeight < pageHeight ) {
          newHeight = pageHeight;
        }
        ouriFrame.attr('height', newHeight ).attr('width', parentWidth);
      });

    }
  };
	/**
	 * Wait until the document is ready before initializing the theme
	 */
	$(document).ready(function(){

		$(document).foundation();
    CSTPage.init();
	});

}( jQuery ) );
