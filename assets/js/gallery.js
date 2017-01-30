(function( $ ){


	var CSTGallery = {

		adUnits: [
			"div-gpt-gallery-1",
			"div-gpt-gallery-2",
			"div-gpt-gallery-3",
			"div-gpt-gallery-4"
		],

		currentAdUnit: "",
		adContainerId: "",

		adCounter: 0,

		/**
		 * Initialize the Gallery experience
		 */
		init: function() {

			this.postBody = $("#post-body");
			this.backdrop = $("#cst-gallery-backdrop");
			this.captionButton = $("#cst-caption-button");
			this.gallerySlideCaption = $("#cst-gallery-slide-caption");
			this.wrap = $("#cst-gallery-wrap");
			this.slidesWrap = this.wrap.find("#cst-gallery-slides-wrap");
			this.ad = $("#cst-gallery-slide-ad");
			this.galleryTitle = $("#cst-gallery-title");
			this.bindEvents();

		},

		/**
		 * Bind gallery events
		 */
		bindEvents: function() {

			this.postBody.on( "click", ".post-gallery-lead-image", $.proxy( this.openLightboxGallery, this ) );
			this.postBody.on( "click", ".post-gallery-open-button", $.proxy( function( e ){
				e.preventDefault();
				this.openLightboxGallery( e );
			}, this) );

			var delayedTimer = 0;
			$(window).resize( $.proxy( function() {

				if ( 0 !== delayedTimer ) {
					clearTimeout( delayedTimer );
				}

				delayedTimer = setTimeout( $.proxy( function(){

					this.slidesWrap.find(".slide img").each($.proxy( function( key, value ){
						this.centerImageWithinSlide( $( value ) );
					}, this ) );

					delayedTimer = 0;
				}, this ), 10 );
			}, this ) );

			this.wrap.on("click", "#cst-close-gallery-button", $.proxy( function( e ){
				e.preventDefault();
				this.closeLightboxGallery();
			}, this ) );

			this.wrap.on("click", "#cst-gallery-desktop-previous-button", $.proxy( function( e ) {
				e.preventDefault();
				this.slidesWrap.find( ".slides" ).slickPrev();
			}, this ) );

			this.wrap.on("click", "#cst-gallery-desktop-next-button", $.proxy( function( e ) {
				e.preventDefault();
				this.slidesWrap.find( ".slides" ).slickNext();
			}, this ) );

			this.wrap.on("click", "#cst-caption-button", $.proxy( function( e ) {
				e.preventDefault();
				this.gallerySlideCaption.toggle();
			}, this ) );

			this.wrap.on("click", ".slick-active", $.proxy( function( e ) {
				e.preventDefault();
				this.slidesWrap.find( ".slides" ).slickNext();
			}, this ) );

			$(document).keyup( $.proxy( function( e ){

				if ( ! $("body").hasClass( "post-gallery-lightbox-active" ) ) {
					return;
				}

				switch( e.keyCode ) {
					case 27:
						this.closeLightboxGallery();
						break;

					case 37:
						this.slidesWrap.find( ".slides" ).slickPrev();
						break;

					case 39:
						this.slidesWrap.find( ".slides" ).slickNext();
						break;

				}

			}, this ) );

		},

		/**
		 * Open the gallery as a lightbox
		 */
		openLightboxGallery: function( e ) {

			var el = $(e.currentTarget);

			this.backdrop.show();
			this.wrap.show();
			this.galleryTitle.text("");

			$("body").addClass("post-gallery-lightbox-active");

			var slides = el.closest(".post-gallery").find(".slides").clone();
			CSTGallery.adContainerId = el.closest(".post-gallery").attr("id");
			var gallery_title = $(".slides").data("gallery-title");
			var title = jQuery( "<h2 />" );
				title.text( gallery_title );
				this.galleryTitle.append( title );

			this.slidesWrap.html( slides );
			var isMobile = $(window).width() <= 640;
			this.slidesWrap.find(".slide").each($.proxy( function( key, value ){
        this.buildSlide(value,isMobile);
			}, this ) );
			this.slidesWrap.find( ".slides" ).slick({
				onBeforeChange: $.proxy( function( e ) {
					this.wrap.find("#cst-gallery-slide-caption").hide();
				}, this ),
				onAfterChange: $.proxy( function( e ) {

					var caption = this.slidesWrap.find(".slick-active").data("image-caption");

					this.wrap.find("#cst-gallery-slide-caption").text( caption ).hide();
					CSTGallery.handleSmallDeviceLayout(caption)
          CSTGallery.handleUrlAndPageview();

					this.displayNextGalleryAd();

				}, this ),
				onInit: $.proxy( function() {
					var caption = this.slidesWrap.find(".slick-active").data("image-caption");
          this.wrap.find("#cst-gallery-slide-caption").text( caption );
          CSTGallery.handleSmallDeviceLayout(caption)

					this.slidesWrap.find( ".slick-prev").html("<i class=\"fa fa-chevron-left\"></i>");
					this.slidesWrap.find( ".slick-next").html("<i class=\"fa fa-chevron-right\"></i>");

          CSTGallery.handleUrlAndPageview();
					this.displayNextGalleryAd();

				}, this )
			});
			
			

		},
		handleSmallDeviceLayout: function(caption) {
      var orientation = window.matchMedia("(orientation: portrait)");
      var viewportHeight = $(window).width();
      if ( orientation.matches && viewportHeight < 768 ) {
      } else if ( viewportHeight > 737 ) {
        this.wrap.find("#cst-gallery-slide-caption").text( caption ).show();
      }
    },
		handleUrlAndPageview: function () {
      var slideUrl = this.slidesWrap.find(".slick-active").data("slide-url");
      var parts = slideUrl.split("#");
      window.location.hash = parts[1];
      CSTAnalytics.currentURL = slideUrl;
      CSTAnalytics.triggerPageview();
    },

		/**
		 * Close the gallery lightbox
		 */
		closeLightboxGallery: function() {

			$("body").removeClass("post-gallery-lightbox-active");

			this.slidesWrap.find( ".slides" ).unslick();

			window.location.hash = "";

			if ( typeof history.pushState !== "undefined" ) {
				history.pushState("", document.title, window.location.pathname);
			}

			this.backdrop.hide();
			this.wrap.hide();

		},

		displayNextGalleryAd: function() {

			var nextAdUnit = this.getNextAdUnit();

			if ( ! this.ad.find("#" + nextAdUnit ).length ) {
				this.ad.append("<div id=\"" + nextAdUnit + "\" class='cst-gallery-ad-unit'></div>");
			}
			$( ".cst-gallery-ad-unit", this.ad ).hide();
			
			this.displayAd( nextAdUnit );


		},

		/**
		* Display the ad unit
		*/
		displayAd: function( nextAdUnit ) {

			if ( this.adCounter < 4) {
				if ( window.innerWidth > 640 ) {
					googletag.cmd.push(function() {
						googletag.display( nextAdUnit );
					});
				}
			} else {
				this.triggerUnitRefresh( nextAdUnit );
			}

			this.ad.find("#" + nextAdUnit ).show();
			this.adCounter++;
		},

		/**
		* Get the next ad unit
		*/
		getNextAdUnit: function() {
			if ( this.currentAdUnit === "div-gpt-gallery-1" ) {
				this.currentAdUnit = "div-gpt-gallery-2";
			} else if ( this.currentAdUnit === "div-gpt-gallery-2" ) {
				this.currentAdUnit = "div-gpt-gallery-3";
			} else if ( this.currentAdUnit === "div-gpt-gallery-3" ) {
				this.currentAdUnit = "div-gpt-gallery-4";
			} else {
				this.currentAdUnit = "div-gpt-gallery-1";
			}

			return this.currentAdUnit;
		},

    buildSlide: function(value,isMobile) {
      var single_slide = $( value );
      var img = $("<img />");
      var src = single_slide.data("image-desktop-src");
      if ( src ) {
        if ( isMobile ) {
          src = single_slide.data("image-mobile-src");
        }
        img.data("caption", single_slide.data("image-caption") ).attr("src", src ).data("slide-url", single_slide.data("slide-url"));
        single_slide.append( img );
        img.on("load",$.proxy(function(){
          this.centerImageWithinSlide( img );
        }, this ) );
      }
    },

		/**
		 * Trigger refresh of the ad unit
		 */
		triggerUnitRefresh: function( unit ) {

			if ( typeof CSTAdTags[unit] !== "undefined" ) {
				googletag.cmd.push( function() {
					var unitInstance = CSTAdTags[unit];
					googletag.pubads().refresh([unitInstance]);
				});
			}

		},

		/**
		 * Center slide horizontally and vertically within their viewport
		 */
		centerImageWithinSlide: function( img ) {

			if ( ! $("body").hasClass( "post-gallery-lightbox-active" ) ) {
				return;
			}

			var slidesBox = this.slidesWrap.find(".slides"),
				slidesBoxOuterWidth = slidesBox.outerWidth(),
				slidesBoxInnerHeight = slidesBox.innerHeight();
				var el = img.parent();
				el.css("position", "relative");
				img.css("position", "absolute");
				img.css("max-height", slidesBoxInnerHeight + "px");
				img.css("max-width", el.css("width") );

				if ( slidesBoxInnerHeight > img.innerHeight() ) {
					img.css("top", ( ( slidesBoxInnerHeight - img.innerHeight() ) / 2 ) + "px" );
				} else {
					img.css("top", "auto");
				}
				if ( slidesBoxOuterWidth > img.innerWidth() ) {
					img.css("left", ( ( slidesBoxOuterWidth - img.innerWidth() ) / 2 ) + "px" );
				} else {
					img.css("left", "auto");
				}

		}

	};

	$(document).ready(function(){

		CSTGallery.init();

	});

}( jQuery ) );
