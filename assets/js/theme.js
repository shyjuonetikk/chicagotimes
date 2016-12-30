(function( $ ){
  var throttleScroll;

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
            if ( $('body.single').length ) {
                $('#main .post').addClass('cst-active-scroll-post');
            }

            this.responsiveIframes();
            this.headerSlider();
            this.rescaleHeadlinesImages();
            if ( this.trendingNav.length ) {
                this.recalibrateTrendingItems();
            }
            this.positionAndSizePostSidebar();
            if (this.body.hasClass('tax-cst_section')) {
        this.anchorMe.stick_in_parent({'bottoming' : false, 'offset_top': this.adminBar.height() + this.primaryNavigation.height() + 10 });
      }
        },

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
            this.offCanvasList = $('.off-canvas-menu');
            this.searchButton = $('#search-button');
            this.searchInput = $('#search-input');
            this.leftSidebar = $('.stick-sidebar-left');
            this.footerFixed = $('#fixed-footer-container');
            this.footerBottom = this.footerFixed.find('.footer-bottom');
            this.footerMoreInfo = $('.footer-more-info');
            this.dfpSBB = $('#div-gpt-sbb');
            this.interstitial = $('#div-gpt-interstitial');
            this.interstitialContainer = $('#dfp-interstitial-container');
            this.closeInterstitial = $('#dfp-interstitial-close');
            this.cstLogo = $('header #suntimes-logo');
            this.nfLogo = $('header #newsfeed-logo');
            this.mobileHome = $('header #mobile-home');
            this.tabletHome = $('header #logo-wrap #tablet-home');
            this.header = $('#header');
      this.adminBar = $('#wpadminbar');
      this.sidebarWidgetCount = $('.widgets > li').length - 1;
      this.anchorMe = $('.widgets > li:nth(' + this.sidebarWidgetCount + ')');
      this.scrollToolbarHeight = this.primaryNavigation.outerHeight();
            if ( this.adminBar.length ) {
                this.scrollToolbarHeight += this.adminBar.outerHeight();
            }

        },

        /**
         * Bind events happening within the theme
         */
        bindEvents: function() {

            $(document.body).on('post-load', $.proxy( function() {
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

            $(window).scroll( $.proxy( function() {
        clearTimeout(throttleScroll);
        throttleScroll = setTimeout(function(){
            CST.doScrollEvent();
        }, 10);
            }, this ) );

            this.postBody.on( 'click', '.post-comments', $.proxy( function( e ) {
                e.preventDefault();
                var el = $(e.currentTarget);
            }, this ) );

            this.backToTop.on( "click", $.proxy( function (e) {

                e.preventDefault();
                $('html,body').animate({scrollTop: '0'}, 800);
                this.fixedBackToTop.hide();
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

            this.footerBottom.on( "click", $.proxy( function (e) {

                e.preventDefault();
                this.footerMoreInfo.slideToggle();

                var footerCircle = this.footerBottom.find('#footer-circle');

                if( footerCircle.hasClass("fa-chevron-circle-up") ) {
                    footerCircle.removeClass('fa-chevron-circle-up').addClass('fa-chevron-circle-down');
                } else {
                    footerCircle.removeClass('fa-chevron-circle-down').addClass('fa-chevron-circle-up');
                }
            }, this ) );

            this.dfpSBB.mouseover(function() {
                $( "#dfp-sbb-top" ).hide();
                $( "#dfp-sbb-bottom" ).show();
            }).mouseout(function() {
                $( "#dfp-sbb-top" ).show();
                $( "#dfp-sbb-bottom" ).hide();
            });

            this.closeInterstitial.on( "click", $.proxy( function (e) {
                e.preventDefault();
                this.interstitial.css('display', 'none');
                this.interstitialContainer.css('display', 'none');
            }, this ) );

            $(document)
            .on('open.fndtn.offcanvas', '[data-offcanvas]', function() {
                $('html').css('overflow', 'hidden');
            })
            .on('close.fndtn.offcanvas', '[data-offcanvas]', function() {
                $('html').css('overflow', 'auto');
            });

        },

        /**
         * Events that might need to happen when scrolling
         */
        doScrollEvent: function() {

            var scrollTop = $(window).scrollTop();
      var windowWidth = $(window).width();
            if ( scrollTop > 0 ) {

                this.topHeight = $(document).scrollTop();
                this.offCanvasList.addClass('fixed-canvas-menu');

                // Specific for IE browser
                if ( $.browser.msie ) {
                    this.offCanvasList.css("top", this.primaryNavigation.height() + this.topHeight + 'px');
                } else {
                    this.offCanvasList.css("top", this.topHeight + 'px');
                }

            } else {
                this.offCanvasList.removeClass('fixed-canvas-menu');
            }

            if ( scrollTop > this.featuredPosts.height() + this.dfpSBB.height() ) {

                // Back to Top element
                if ( ! this.fixedBackToTop.is(":visible") ) {
                    this.toggleBackToTop();
                }

                // Primary Navigation
                if ( this.primaryNavigation.hasClass('primary-normal') ) {
                    this.togglePrimaryNavigation();
                }

                if ( this.nfLogo.is(':hidden') ) {
                    this.cstLogo.hide();
                    this.nfLogo.show('slide', { direction: 'down' } );
                    this.nfLogo.css('display', 'block');
                    if ( windowWidth <= 640 ) {
                        this.mobileHome.show('slide', { direction: 'down' } );
                    }
                    if ( windowWidth > 640 && windowWidth < 981 ) {
                        this.tabletHome.show('slide', { direction: 'down' } );
                    }
                }

            } else {

                // Back to Top element
                if ( this.fixedBackToTop.is(':visible') ) {
                    this.toggleBackToTop();
                }

                // Primary Navigation
                if ( this.primaryNavigation.hasClass('primary-fixed') ) {
                    this.togglePrimaryNavigation();
                }

                if ( this.nfLogo.is(':visible') ) {
                    this.nfLogo.hide();
                    this.mobileHome.hide();
                    this.tabletHome.hide();
                    this.cstLogo.show('slide', { direction: 'up' } );
                }

            }


            // Sticky sharing tools on the articles, as well as logic for the currently viewing post
            if ( $( 'body.single' ).length ) {
        var mainPost = $('#main .post');
        mainPost.each( $.proxy( function( key, value ) {
                    var el = $(value);
                    var topBreakPoint = el.offset().top - this.scrollToolbarHeight;
                    var bottomBreakPoint = topBreakPoint + el.height() - 80;

                    if ( scrollTop > topBreakPoint && scrollTop < bottomBreakPoint && ! el.hasClass('cst-active-scroll-post') ) {
            mainPost.removeClass('cst-active-scroll-post');
                        el.addClass('cst-active-scroll-post');
                    }
                }, this ) );

            }
      this.positionAndSizePostSidebar(scrollTop);
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
         * Stick and unstick the primary navigation element
         */
        togglePrimaryNavigation: function() {

            if ( this.primaryNavigation.hasClass('primary-normal') ) {
                this.primaryNavigation.removeClass('primary-normal').addClass('primary-fixed');
                // Prevents jitter when the navigation is getting fixed
                this.featuredPosts.css( 'padding-bottom', this.primaryNavigation.outerHeight() + 'px' );
                // Accommodate desktop admin bar, but not mobile
                if ( $('body').hasClass('admin-bar') && $(window).width() > 782 ) {
                    this.primaryNavigation.css( 'top', $('#wpadminbar').height() );
                }
            } else  {
                this.primaryNavigation.removeClass('primary-fixed').addClass('primary-normal');
                this.primaryNavigation.removeAttr( 'style' );
                this.featuredPosts.removeAttr('style');
            }

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

            if ( ! this.leftSidebar.length ) {
                return;
            }
      var postSidebarTop = this.scrollToolbarHeight;

      if ( ! this.postSidebar.hasClass('sidebar-normal') && ! this.postSidebar.hasClass('sidebar-fixed') ) {
        this.postSidebar.addClass('sidebar-normal');
      }

      if ( this.postSidebar.hasClass('sidebar-normal') ) {
        postSidebarTop += this.featuredPosts.outerHeight() - this.adminBar.height();
        if ( postSidebarTop + 'px' != this.postSidebar.css('top' ) ) {
          this.postSidebar.css('top', postSidebarTop + 'px' );
        }
      } else if ( ! this.postSidebar.hasClass('sidebar-normal') || this.postSidebar.hasClass('sidebar-fixed') ) {
        if ( postSidebarTop + 'px' != this.postSidebar.css('top' ) ) {
          this.postSidebar.css('top', postSidebarTop + 'px' );
        }
      }
            if( this.leftSidebar.length && ( ( this.leftSidebar.height() + this.featuredPosts.outerHeight() - this.adminBar.height() ) / 2 ) < scrollTop ) {
                if ( ! this.leftSidebar.hasClass('fixed-bottom') ) {
                    this.leftSidebar.addClass('fixed-bottom');
                }
            } else {
                if ( this.leftSidebar.hasClass('fixed-bottom') ) {
                    this.leftSidebar.removeClass('fixed-bottom');
                }
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
                    if ( 'hidden' == el.css('visibility') ) {
                        el.css('visibility', 'visible');
                    }
                    shown = true;
                } else {
                    if ( 'visible' == el.css('visibility') ) {
                        el.css('visibility', 'hidden');
                    }
                }
            });

            if ( shown && 'hidden' == this.trendingNav.css('visibility') ) {
                this.trendingNav.css('visibility', 'visible');
            } else if ( ! shown && 'visible' == this.trendingNav.css('visibility') ){
                this.trendingNav.css('visibility', 'hidden');
            }

        },

        /**
         * Load the header slider
         */
        headerSlider: function() {

            this.featuredPosts.find('.slider').slick({
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
                slidesToShow: 5,
                dots: true,
        customPaging: function(slider, i) {
          return '<button type="button" data-on="click" data-event-category="slider-dot" data-event-action="dot-navigate">' + (i + 1) + '</button>';
        },
                arrows: true,
                prevArrow: '<a href="#" data-on="click" data-event-category="slider-arrow" data-event-action="navigate-prev"><i class="fa fa-chevron-left header-prev"></i></a>',
                nextArrow: '<a href="#" data-on="click" data-event-category="slider-arrow" data-event-action="navigate-next"><i class="fa fa-chevron-right header-next"></i></a>',
                responsive: [
                    // Small desktop
                    {
                        breakpoint: 1300,
                        settings: {
                            slidesToShow: 4
                        }
                    },
                    // Small desktop
                    {
                        breakpoint: 1100,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    // Mobile
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    // Mobile
                    {
                        breakpoint: 580,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });

        },

        /**
         * Browser detection redirect
         */
         browserDetection: function() {
            var theme_url = (CSTIE.cst_theme_url);
            var isIE = ( -1 != navigator.userAgent.search( 'MSIE' ) );
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

        $(document).foundation();
        CST.init();

    });

}( jQuery ) );
