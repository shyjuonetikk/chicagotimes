(function( $ ){

  var CST_Homepage = {

    /**
     * Initialize basic theme JavaScript
     */
    init: function() {

      this.cacheElements();
      this.bindEvents();

    },

    /**
     * Cache elements to object-level variables
     */
    cacheElements: function() {

      this.body = $('body');
      this.primaryNavigation = $('#fixed-nav-wrapper');
      this.topBarSection = $('.top-bar-section');
      this.smallLogo = $('.small-logo');
          this.wpAdminBar = $('#wpadminbar');

      this.scrollToolbarHeight = this.primaryNavigation.outerHeight();
      if ( this.wpAdminBar.length ) {
        this.scrollToolbarHeight += this.wpAdminBar.outerHeight();
      }

      this.breakingNewsButton = $('.breaking-news-button');
      this.breakingNewsModal = $('#breaking-news-alert-modal');
      this.breakingNews = $('.breaking-news-story');
      this.breakingSection = $('.breaking-section-story');
      this.breakingNewsClose = $('.close-breaking-news');
      this.breakingSectionClose = $('.close-breaking-section');
      this.bearsCube = $('.bears-cube-story');
      this.bearsCubeClose = $('.close-bears-cube');
      this.header = $('header');
      this.dfpSBB = $('#div-gpt-sbb-1');
      this.interstitial = $('#div-gpt-interstitial');
      this.interstitialContainer = $('#dfp-interstitial-container');
      this.closeInterstitial = $('#dfp-interstitial-close');
      this.searchButton = $('#search-button');
      this.searchInput = $('#search-input');
      this.offCanvasMenu = $('.left-off-canvas-menu');

    },

    /**
     * Bind events happening within the theme
     */
    bindEvents: function() {
      var delayedTimer;
      $(window).scroll( $.proxy( function() {
        setTimeout( $.proxy( this.doScrollEvent, this ), 1 );
      }, this ) );

      this.breakingNewsClose.on( "click", $.proxy( function (e) {
        e.preventDefault();
        this.breakingNews.css('display', 'none');
      }, this ) );

      this.breakingSectionClose.on( "click", $.proxy( function (e) {
        e.preventDefault();
        this.breakingSection.css('display', 'none');
      }, this ) );

      this.bearsCubeClose.on( "click", $.proxy( function (e) {
        e.preventDefault();
        this.bearsCube.css('display', 'none');
      }, this ) );

      this.dfpSBB.mouseover(function() {
        $('#dfp-sbb-top').hide();
        $('#dfp-sbb-bottom').show();
      }).mouseout(function() {
        $('#dfp-sbb-top').show();
        $('#dfp-sbb-bottom').hide();
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

      $(window).resize( $.proxy( function() {
        if ( delayedTimer ) {
          clearTimeout( delayedTimer );
        }
        delayedTimer = setTimeout( $.proxy( function(){
          this.responsiveIframes();
        }, this ), 30 );
      }, this ) );
      $(document)
        .on('open.fndtn.offcanvas', '[data-offcanvas]', CST_Homepage.handleNavigation)
        .on('close.fndtn.offcanvas', '[data-offcanvas]', function() {
          document.getElementsByTagName('body')[0].style.overflow='auto';
        });
    },
    /**
     * Make some iframes responsive
     */
    responsiveIframes: function() {

      $('iframe.cst-responsive').each(function(){
        var el = $(this),
          parentWidth = el.parent().width();
        var trueHeight = el.data('true-height') ? el.data('true-height') : 640;
        var trueWidth = el.data('true-width') ? el.data('true-width') : 360;
        var newHeight = ( parentWidth / trueHeight ) * trueWidth;
        $(this).attr('height', newHeight ).attr('width', parentWidth);
      });

    },
    /**
     * Events that might need to happen when scrolling
     */
    doScrollEvent: function() {

      var scrollTop = $(window).scrollTop();
      if ( scrollTop > 0 && this.hasClass(document.getElementsByClassName('off-canvas-wrap')[0],'move-right') ) {
        this.offCanvasList.addClass('fixed-canvas-menu');

        // Specific for IE browser
        if ( $.browser.msie ) {
          this.offCanvasMenu.css("top", this.primaryNavigation.height() + scrollTop + 'px');
        } else {
          this.offCanvasMenu.css("top", scrollTop + 'px');
        }

      } else {
        this.offCanvasMenu.removeClass("fixed-canvas-menu");
      }

    },
    handleNavigation: function() {
        document.getElementsByTagName('body')[0].style.overflow='hidden';
        var scrollTop = $(window).scrollTop();
        if ( scrollTop > 0 && ! CST_Homepage.hasClass(document.getElementsByClassName('off-canvas-wrap')[0],'move-right') ) {
          // Specific for IE browser
          if ( $.browser.msie ) {
            this.offCanvasMenu.css("top", this.primaryNavigation.height() + scrollTop + 'px');
          } else {
            CST_Homepage.offCanvasMenu.css("top", scrollTop + 'px');
            CST_Homepage.offCanvasMenu.css("position", 'absolute');
          }
        }
    },
    hasClass: function(el,className) {
      if (el.classList)
        return el.classList.contains(className);
      else
        return new RegExp('(^| )' + className + '( |$)', 'gi').test(el.className);
    }

  };

  /**
   * Wait until the document is ready before initializing the theme
   */
  $(document).ready(function(){
    $(document).foundation({
      equalizer : {
// Specify if Equalizer should make elements equal height once they become stacked.
        equalize_on_stack: true
      },
      offcanvas: {
        open_method: "move",
        close_on_click: false
      },
      reveal: {
        close_on_background_click: true
      }
    });
    CST_Homepage.init();
  });

}( jQuery ) );
