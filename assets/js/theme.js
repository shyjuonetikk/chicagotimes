;(function( $ ){
  var throttleScroll, previousPosition, taboola_container_id;

    var CST = {

      lastScrollPosition: 0,
    saveTriggerPoint: 0,
        /**
         * Initialize basic theme JavaScript
         */
        init: function() {

            this.browserDetection();
            this.cacheElements();
            this.bindEvents();

            // Trigger the scroll with styling for social
            if ( this.body.hasClass("single") ) {
                $("#main .post").addClass("cst-active-scroll-post");
            }

			this.responsiveIframes();
			if ( this.body.hasClass("single") ) {
        this.positionAndSizePostSidebar();
      }
      if ( this.trendingNav.length ) {
				this.recalibrateTrendingItems();
			}
			if ('false' === CSTData.customize_preview) {
			  this.taboola();
      }
			},

        /**
         * Cache elements to object-level variables
         */
        cacheElements: function() {

            this.body = $('body');
            this.mainNav = $(".main-navigation");
            this.trendingNav = $('#trending-container');
            this.fixedBackToTop = $('#fixed-back-to-top');
            this.backToTop = $('#back-to-top');
            this.primaryNavigation = $('#primary-navigation');
            this.postSidebar = $('.article-sidebar');
            this.postBody = $('#post-body');
            this.offCanvasList = $('.left-off-canvas-menu');
            this.leftOffCanvasList = $('.left-off-canvas-menu');
            this.searchButton = $('#search-button');
            this.searchInput = $('#search-input');
            this.leftSidebar = $('.stick-sidebar-left');
            this.dfpSBB = $('#div-gpt-sbb');
          this.header = $('#header');
          this.stickyParent = $(".off-canvas-wrap");
            this.articleUpperAdUnit = $('.article-upper-ad-unit');
            this.spacer = $(".spacer");
      this.adminBar = $('#wpadminbar');
      this.sidebarWidgetCount = $('.widgets > li').length - 1;
      this.anchorMe = $('.widgets > li:nth(' + this.sidebarWidgetCount + ')');
      this.scrollToolbarHeight = this.header.outerHeight();
            if ( this.adminBar.length ) {
                this.scrollToolbarHeight += this.adminBar.outerHeight();
            }

        },

        /**
         * Bind events happening within the theme
         */
        bindEvents: function() {

            $(document.body).on("post-load", $.proxy( function() {
                setTimeout( $.proxy( function() {
                    this.responsiveIframes();
                }, this ), 1 );
            }, this ) );
            var delayedTimer = false;
            $(window).resize( $.proxy( function() {
                if ( delayedTimer ) {
                    clearTimeout( delayedTimer );
                }
                delayedTimer = setTimeout( $.proxy( function(){
                    this.responsiveIframes();
                    this.positionAndSizePostSidebar();
                    if ( this.trendingNav.length ) {
                        this.recalibrateTrendingItems();
                    }
                }, this ), 30 );
            }, this ) );

            if ( this.body.hasClass("single") || this.body.hasClass("archive") ) {
              $(window).scroll($.proxy(function () {
                clearTimeout(throttleScroll);
                throttleScroll = setTimeout(function () {
                  CST.doScrollEvent();
                }, 10);
              }, this));
            }


            this.backToTop.on( "click", $.proxy( function (e) {

                e.preventDefault();
                $("html,body").animate({scrollTop: "0"}, 800);
                this.fixedBackToTop.hide();
            }, this ) );

           this.dfpSBB.mouseover(function() {
                $( "#dfp-sbb-top" ).hide();
                $( "#dfp-sbb-bottom" ).show();
            }).mouseout(function() {
                $( "#dfp-sbb-top" ).show();
                $( "#dfp-sbb-bottom" ).hide();
            });
          $(document)
            .on('open.fndtn.offcanvas', '[data-offcanvas]', CST.handleNavigation)
            .on('close.fndtn.offcanvas', '[data-offcanvas]', function() {
              document.getElementsByTagName('body')[0].style.overflow='auto';
            });

        },

        /**
         * Events that might need to happen when scrolling
         */
        doScrollEvent: function() {
          var scrollTop = $(window).scrollTop();
            previousPosition = scrollTop;
            if ( scrollTop > 0 && this.hasClass(document.getElementsByClassName('off-canvas-wrap')[0],'move-right') ) {

                this.topHeight = $(document).scrollTop();
                this.leftOffCanvasList.addClass('fixed-canvas-menu');

                // Specific for IE browser
                if ( $.browser.msie ) {
                    this.leftOffCanvasList.css("top", this.primaryNavigation.height() + this.topHeight + 'px');
                } else {
                    this.leftOffCanvasList.css("top", this.topHeight + 'px');
                }

            } else {
                this.leftOffCanvasList.removeClass("fixed-canvas-menu");
            }

            if ( scrollTop > this.mainNav.height() ) {

                // Back to Top element
                if ( ! this.fixedBackToTop.is(":visible") ) {
                    this.toggleBackToTop();
                }
            } else {
                // Back to Top element
                if ( this.fixedBackToTop.is(":visible") ) {
                    this.toggleBackToTop();
                }
            }


            // Sticky sharing tools on the articles, as well as logic for the currently viewing post
            if ( $( 'body.single' ).length ) {
              var mainPost = $('#main .post');
              mainPost.each( $.proxy( function( key, value ) {
                var el = $(value);
                var topBreakPoint = el.offset().top - this.scrollToolbarHeight;
                var bottomBreakPoint = topBreakPoint + el.height() - 80;

                if ( ! el.hasClass('cst-active-scroll-post') ) {
                  if ( scrollTop > topBreakPoint &&  scrollTop < bottomBreakPoint ) {
                    mainPost.removeClass('cst-active-scroll-post');
                    el.addClass('cst-active-scroll-post');
                  }
                }
              }, this ) );
            }
            this.positionAndSizePostSidebar(scrollTop);
            this.stickSectionSidebar();
            },
      handleNavigation: function() {
        document.getElementsByTagName('body')[0].style.overflow='hidden';
        var scrollTop = $(window).scrollTop();
        if ( scrollTop > 0 && ! CST.hasClass(document.getElementsByClassName('off-canvas-wrap')[0],'move-right') ) {
          // Specific for IE browser
          if ( $.browser.msie ) {
            CST.leftOffCanvasList.css("top", scrollTop + 'px');
          } else {
            CST.leftOffCanvasList.css("top", scrollTop + 'px');
            CST.leftOffCanvasList.css("position", 'absolute');
          }
        }
      },
      hasClass: function(el,className) {
        if (el.classList)
          return el.classList.contains(className);
        else
          return new RegExp('(^| )' + className + '( |$)', 'gi').test(el.className);
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

          pageHeight = 800;
          pageWidth = 750;
          $('iframe.cst-embed-responsive').each(function(){
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
        },

        /**
         * Show and hide the "Back to Top" element
         */
        toggleBackToTop: function() {

            if ( ! this.fixedBackToTop.is(":visible") ) {
                this.fixedBackToTop.fadeIn("slow");
            } else {
                this.fixedBackToTop.fadeOut('slow');
            }

        },

        /**
         * Stick and unstick the post sidebar
         */
        positionAndSizePostSidebar: function(scrollTop) {
          return;
            if ( ! this.leftSidebar.length ) {
                return;
            }
      var postSidebarTop = this.scrollToolbarHeight;

      if ( ! this.postSidebar.hasClass('sidebar-normal') && ! this.postSidebar.hasClass('sidebar-fixed') ) {
        this.postSidebar.addClass('sidebar-normal');
      }

      if ( this.postSidebar.hasClass('sidebar-normal') ) {
        // postSidebarTop += this.header.outerHeight() - this.adminBar.height() + this.articleUpperAdUnit.height();
        postSidebarTop += this.spacer.outerHeight() - this.adminBar.height();
        if ( postSidebarTop + 'px' !== this.postSidebar.css('top' ) ) {
          this.postSidebar.css('top', postSidebarTop + 'px' );
        }
      } else if ( ! this.postSidebar.hasClass('sidebar-normal') || this.postSidebar.hasClass('sidebar-fixed') ) {
        if ( postSidebarTop + 'px' !== this.postSidebar.css('top' ) ) {
          this.postSidebar.css('top', postSidebarTop + 'px' );
        }
      }
            if( this.leftSidebar.length && ( ( this.leftSidebar.height() + this.spacer.outerHeight() - this.adminBar.height() ) / 2 ) < scrollTop ) {
                if ( ! this.leftSidebar.hasClass('fixed-bottom') ) {
                    this.leftSidebar.addClass('fixed-bottom');
                }
            } else {
                if ( this.leftSidebar.hasClass('fixed-bottom') ) {
                    this.leftSidebar.removeClass('fixed-bottom');
                }
            }

        },

      stickSectionSidebar: function() {
        let displaySidebar = true;
        if ( 'object' === typeof CSTInfiniteScrollData ) {
          if ( 'false' === CSTInfiniteScrollData.displaySidebar ) {
            displaySidebar = false;
          }
        }
          if ( displaySidebar && this.body.hasClass("tax-cst_section")) {
            if (!this.anchorMe.hasClass('is_stuck')) {
              this.anchorMe.stick_in_parent({"parent" : this.stickyParent, "offset_top": this.adminBar.height() + this.header.height() + 10});
            }
          }
      },


        /**
         * Recalibrate the visible Trending menu items based on its available width
         */
        recalibrateTrendingItems: function() {

            var availableWidth = this.trendingNav.innerWidth() - this.trendingNav.find('.menu-label').width();

            var shown = false;
            this.trendingNav.find('ul#menu-trending li.menu-item').each(function(){
                var el = $(this);
                availableWidth -= el.outerWidth();
                if ( availableWidth > 0 ) {
                    if ( 'hidden' === el.css('visibility') ) {
                        el.css('visibility', 'visible');
                    }
                    shown = true;
                } else {
                    if ( 'visible' === el.css('visibility') ) {
                        el.css('visibility', 'hidden');
                    }
                }
            });

            if ( shown && 'hidden' === this.trendingNav.css('visibility') ) {
                this.trendingNav.css('visibility', 'visible');
            } else if ( ! shown && 'visible' === this.trendingNav.css('visibility') ){
                this.trendingNav.css('visibility', 'hidden');
            }

        },

        /**
         * Load the header slider
         */

		taboola: function() {
      var post = $('#main').find('.cst-active-scroll-post').eq(0);
      var post_id = post.data('cst-post-id');
      window.page_counter++;
      taboola_container_id = CSTData.taboola_container_id + window.page_counter;
      var taboolaDiv = document.createElement("div");
      taboolaDiv.id = taboola_container_id;
      var placeholder = jQuery('.taboola-container-' + post_id);
      placeholder.append( taboolaDiv );

      if( window.page_counter === 1 ) {
        window._taboola = window._taboola || [];
        _taboola.push({
          mode:'thumbnails-c',
          container: taboola_container_id,
          placement: 'Below Article Thumbnails',
          target_type: 'mix'
        });
        _taboola.push({
          article:'auto',
          url:''
        });
      }
    },/**
		 * Browser detection redirect
		 */
		 browserDetection: function() {
		 	var theme_url = (CSTIE.cst_theme_url);
		 	var isIE = ( -1 !== navigator.userAgent.search( 'MSIE' ) );
			if ( isIE ) {
				var IEVersion = navigator.userAgent.match(/MSIE\s?(\d+)\.?\d*;/);
				var IEVersion = parseInt( IEVersion[1] );
				if( IEVersion <= 8 ) {
					$('.off-canvas-wrap').hide();
					$('#ie8-user').css('display', 'block');
					$( "#ie8-user" ).load( "parts/section/ie8.php" );
				}
			} 
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
            open_method: "move"
          },
          reveal: {
            close_on_background_click: true
          }
        });
        CST.init();

    });

}( jQuery ) );
