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
        this.headerSlider();
        this.rescaleHeadlinesImages();
        this.positionAndSizePostSidebar();
        window.CSTTripleLift && CSTTripleLift.inject();
      }
      if ( this.trendingNav.length ) {
				this.recalibrateTrendingItems();
			}
      this.stickSectionSidebar();
			this.taboola();},

        /**
         * Cache elements to object-level variables
         */
        cacheElements: function() {

            this.body = $('body');
            this.featuredPosts = $('#headlines-slider');
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
                    this.rescaleHeadlinesImages();
                    if ( this.trendingNav.length ) {
                        this.recalibrateTrendingItems();
                    }
                }, this ), 30 );
            }, this ) );

            if ( this.body.hasClass("single") ||  this.body.hasClass("archive") ) {
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
                    this.leftOffCanvasList.css("top", this.primaryNavigation.height() + this.topHeight + this.featuredPosts.height() + 'px');
                } else {
                    this.leftOffCanvasList.css("top", this.topHeight + this.featuredPosts.height() + 'px');
                }

            } else {
                this.leftOffCanvasList.removeClass("fixed-canvas-menu");
            }

            if ( scrollTop > this.dfpSBB.height() ) {

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
        if (this.body.hasClass("tax-cst_section")) {
          this.anchorMe.stick_in_parent({"bottoming": false, "offset_top": this.adminBar.height() + this.header.height() + 10});
        }
      },
        /**
         * Dynamically rescale headlines images
         */
        rescaleHeadlinesImages: function() {

            if ( $(window).width() <= 640 ) {
                return;
            }

            $('#featured-posts .featured-post-with-image').each(function() {
                var el = $(this),
                    elHeight = el.height(),
                    elWidth = el.width(),
                    imageUrl = false;
                    imageHeight = false,
                    imageWidth = false;
                if ( el.hasClass( 'featured-main' ) ) {
                    imageUrl = el.data('image-medium-url');
                    imageHeight = el.data('image-medium-height');
                    imageWidth = el.data('image-medium-width');
                } else {
                    imageUrl = el.data('image-small-url');
                    imageHeight = el.data('image-small-height');
                    imageWidth = el.data('image-small-width');
                }

                if ( el.css('background-image') == 'none' && imageUrl ) {
                    el.css('background-image', 'url("' + imageUrl + '")' );
                }

                var scaledHeight = elHeight,
                    scaledWidth = elWidth,
                    backgroundTopPosition = 0,
                    backgroundLeftPosition = 0;
                if ( ( elHeight / elWidth ) < ( imageHeight / imageWidth ) ) {
                    scaledWidth = elWidth;
                    scaledHeight = ( imageHeight / imageWidth ) * scaledWidth;
                    backgroundTopPosition = ( ( scaledHeight - elHeight ) / 2 ) * -1;
                } else {
                    scaledHeight = elHeight;
                    scaledWidth = ( imageWidth / imageHeight ) * scaledHeight;
                    backgroundLeftPosition = ( ( scaledWidth - elWidth ) / 2 ) * -1;
                }
                el.css('background-size', scaledWidth + 'px ' + scaledHeight + 'px' );
                el.css('background-position', backgroundLeftPosition + 'px ' + backgroundTopPosition + 'px' );

            });

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
        headerSlider: function() {

			if(this.featuredPosts) {this.featuredPosts.find('.slider').slick({
				onInit: $.proxy( function() {
					this.featuredPosts.find('.slick-slide:not(.slick-cloned)').each( $.proxy( function( index, el ){
						if ( $(el).hasClass('slick-active') ) {
							this.featuredPosts.find('.slick-dots li').eq( index ).addClass('slick-active');
						}
					}, this ) );
				}, this ),
				onBeforeChange: $.proxy( function() {
					this.featuredPosts.find('.slick-dots').addClass('force-normal-dots');
				}, this ),
				onAfterChange: $.proxy( function() {
					this.featuredPosts.find('.slick-slide:not(.slick-cloned)').each( $.proxy( function( index, el ){
						if ( $(el).hasClass('slick-active') ) {
							this.featuredPosts.find('.slick-dots li').eq( index ).addClass('slick-active');
						}
					}, this ) );
					this.featuredPosts.find('.slick-dots').removeClass('force-normal-dots');
				}, this ),
				slide: '.slide',
				slidesToShow: 6,
				dots: true,
        customPaging: function(slider, i) {
          return '<button type="button" data-on="click" data-event-category="slider-dot" data-event-action="dot-navigate">' + (i + 1) + '</button>';
        },
				arrows: true,
				prevArrow: '<button data-on="click" data-event-category="slider-arrow" data-event-action="navigate-prev"><i class="fa fa-chevron-left header-prev"></i></button>',
				nextArrow: '<button data-on="click" data-event-category="slider-arrow" data-event-action="navigate-next"><i class="fa fa-chevron-right header-next"></i></button>',
				responsive: [
					// Small desktop
					{
						breakpoint: 1300,
						settings: {
							slidesToShow: 5
						}
					},
					// Small desktop
					{
						breakpoint: 1100,
						settings: {
							slidesToShow: 4
						}
					},
					// Mobile
					{
						breakpoint: 768,
						settings: {
							slidesToShow: 3
						}
					},
					// Mobile
					{
						breakpoint: 580,
						settings: {
							slidesToShow: 2
						}
					}
				]
			});
}
		},

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
