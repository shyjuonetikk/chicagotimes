/* global googletag, CSTYieldMoData, CSTData, CSTData.home_url, CSTInfiniteScrollData, CSTInfiniteScrollData.readMoreLabel */
;(function( $ ){

	var isIE = ( -1 != navigator.userAgent.search( "MSIE" ) );
	if ( isIE ) {
		var IEVersion = navigator.userAgent.match(/MSIE\s?(\d+)\.?\d*;/);
		var IEVersion = parseInt( IEVersion[1] );
	}

	var CSTInfiniteScroll = {

		sidebarLoadInProgress: false,
		sidebarEnd: false,
		scroller: false,
		activePage: 0,
		activeURI: window.location.href.replace( window.location.origin, "" ),
		baseURLWithoutPage: window.location.href.replace(/page\/[\d]+\//,"").replace( window.location.hash, "" ),
    featuredPosts: $('#headlines-slider').height(),

		init: function() {

      if ( "object" === typeof (addthis) ) {
        addthis.toolbox(".addthis_toolbox");
      }

			this.scroller.body.on( "post-load", function( e, response ) {
				if ( typeof response.html !== "undefined" ) {
					var post = $(response.html).find("article.post"),
						post_id = post.data("cst-post-id");
          if ( "object" === typeof (addthis) ) {
            addthis.toolbox("#addthis-" + post_id);
          }

					// Add "Read More" link to articles longer than 350 words
					if ( post.hasClass("cst_article") ) {
						var post_content = post.find(".post-content"),
							word_count = post_content.text().trim().replace(/\s+/gi, " ").split(" ").length,
							max_count = 350;

						if ( word_count > max_count ) {
							var currentCount = 0,
								addedReadMore = false;
							var livePostContent = $("#post-body").find("article#post-" + post_id + " .post-content");
							post_content.children().each( function( index, value ){
								var el = $(value),
									el_count = el.text().trim().replace(/\s+/gi, " ").split(" ").length;
								currentCount += el_count;
								if ( currentCount > max_count ) {
									livePostContent.children().eq( index + 1 ).addClass("read-more-hidden");
									if ( ! addedReadMore ) {
										var readMore = $("<p class=\"read-more-wrap\"><a href=\"#\" class=\"read-more button\"></a></p>");
										readMore.find("a").text( CSTInfiniteScrollData.readMoreLabel );
										livePostContent.children().eq( index + 1 ).before( readMore );
										addedReadMore = true;
									}
								}

							});
						}

					} else if ( post.hasClass("cst_liveblog") ) {

						var livePost = $("#post-body").find("article#post-" + post_id),
							entries = livePost.find("#liveblog-entries .liveblog-entry");
						if ( entries.length > 5 ) {

							entries.each( function( index, value ){
								if ( index >= 5 ) {
									$(this).addClass("read-more-hidden");
								}
							});

							var readMore = $("<p class=\"read-more-wrap\"><a href=\"#\" class=\"read-more button\"></a></p>");
							readMore.find("a").text( CSTInfiniteScrollData.readMoreLabel );
							livePost.find("#liveblog-container").after( readMore );
						}

					}
				}
			});

			if ( $("body").hasClass("single") ) {
				$("#post-body").on("click", "a.read-more", function( e ){
					e.preventDefault();
					var el = $(this);
					el.closest(".post-content").find(".read-more-hidden").removeClass("read-more-hidden");
					el.parent().remove();
				});
			}

		},

		/**
		 * Overload the scroller page updater with our own :)
		 */
		determineURL: function() {

			var uri, url, post_id, wp_title, current_hash, visible_page, post, active_post;

			if ( $("body.single").length ) {
				post = $("#main").find(".cst-active-scroll-post").eq(0);
				if ( ! post.length ) {
					return;
				}

				uri = post.data("cst-post-uri");
        active_post = jQuery(".cst-active-scroll-post");
        var trigger = active_post.find(".post-meta-social")||null;
        if ( trigger ) {
          var active_post_position = active_post.position().top;
          jQuery(".sidebar-scroll-container").css("top", active_post_position + "px");
        }
				if ( uri === CSTInfiniteScroll.activeURI ) {
					return;
				}
				CSTInfiniteScroll.activeURI = uri;

				if ( CSTInfiniteScroll.supportsPushState() && window.location.href != uri ) {
					history.pushState( null, null, uri );
					CSTAnalytics.currentURL = window.location.href;
				} else if ( ! CSTInfiniteScroll.supportsPushState() ) {
					var home_uri = CSTData.home_url.replace( window.location.origin, "" );
					window.location.hash = uri.replace( home_uri, "" ).slice( 1 );
					CSTAnalytics.currentURL = window.location.origin + uri;
				}

        CSTInfiniteScroll.fireTaboola(uri);
        CSTInfiniteScroll.fireYieldmo();
        CSTInfiniteScroll.fireChatter();


			    if(window.SECTIONS_FOR_AGGREGO_HEADLINESNETWORK){
            window.AggregoHeadlinesNetwork && AggregoHeadlinesNetwork.inject(window.SECTIONS_FOR_AGGREGO_HEADLINESNETWORK)
			    }
        wp_title = post.data("cst-wp-title");

				document.title = wp_title;

        window.CSTAds && CSTAds.refreshAllArticleAds();
        window.CSTTripleLift && CSTTripleLift.inject()
				CSTAnalytics.triggerPageview();
				
			} else {
				CSTInfiniteScroll.originalDetermineURL();

				if ( CSTInfiniteScroll.supportsPushState() ) {
					if ( window.location.href.replace( window.location.origin, "" ) !== CSTInfiniteScroll.activeURI ) {
						CSTAnalytics.currentURL = window.location.href;
						CSTAnalytics.triggerPageview();
						CSTInfiniteScroll.activeURI = window.location.href.replace( window.location.origin, "" );
					}
				} else {

					current_hash = window.location.hash;
					offset = window.infiniteScroll.scroller.offset > 0 ? window.infiniteScroll.scroller.offset - 1 : 0;
					visible_page = CSTInfiniteScroll.activePage + offset;
					url = CSTInfiniteScroll.baseURLWithoutPage;
					if ( CSTInfiniteScroll.activePage < 1 && current_hash != "" && current_hash != "#" && current_hash != "#page/" + visible_page + "/" ) {
						window.location.hash = "";
					} else if ( CSTInfiniteScroll.activePage > 1 && current_hash != "#page/" + visible_page + "/" ) {
						window.location.hash = "page/" + visible_page + "/";
					}

					if ( visible_page && visible_page > 1 ) {
						url = url + "page/" + visible_page + "/";
					} else {
						url = CSTInfiniteScroll.baseURLWithoutPage;
					}

					uri = url.replace( window.location.origin, "" );

					if ( CSTInfiniteScroll.activeURI != uri ) {
						CSTAnalytics.currentURL = url;
						CSTAnalytics.triggerPageview();
						CSTInfiniteScroll.activeURI = CSTAnalytics.currentURL.replace( window.location.origin, "" );
					}

				}

			}

		},

		/**
		 * Override updateURL method so we can capture the active page
		 */
		updateURL: function( page ) {

			var self = window.infiniteScroll.scroller,
				offset = self.offset > 0 ? self.offset - 1 : 0,
				pageSlug = -1 == page ? self.origURL : window.location.protocol + "//" + self.history.host + self.history.path.replace( /%d/, page + offset ) + self.history.parameters;
			if ( CSTInfiniteScroll.supportsPushState() && window.location.href != pageSlug ) {
				history.pushState( null, null, pageSlug );
			}

			CSTInfiniteScroll.activePage = page > 1 ? page : 1;

		},

		/**
		 * Whether or not this browser supports pushState
		 */
		supportsPushState: function() {
			return typeof history.pushState !== "undefined";
		},
		fireTaboola: function(uri) {
      /* global taboola_container_id */
      if( ! $("#" + CSTData.taboola_container_id).hasClass("trc_related_container") ) {
        window._taboola = window._taboola || [];
        _taboola.push({mode:"thumbnails-c", container: CSTData.taboola_container_id, placement: "Below Article Thumbnails", target_type: "mix"});
        _taboola.push({article:"auto", url:uri});
      }
    },
		fireChatter: function() {
      if(window.SECTIONS_FOR_AGGREGO_CHATTER){
        window.AggregoChatter && AggregoChatter.inject(window.SECTIONS_FOR_AGGREGO_CHATTER)
      }
    },
		fireYieldmo: function() {
      if (CSTYieldMoData.SECTIONS_FOR_YIELD_MO) {
        window.YieldMo && YieldMo.inject(CSTYieldMoData.SECTIONS_FOR_YIELD_MO)
      }
      if (window.YIELDMO_DEMO_TAG) {
        googletag.cmd.push(function () {
          var unitInstance = googletag.defineSlot("/61924087/chicago.suntimes.com/chicago.suntimes.com.ym", [300, 250], "" + window.YIELDMO_DEMO_TAG + "");
          googletag.pubads().refresh([unitInstance]);
        });
      }
    },

		setupInfiniteScroll: function() {
      CSTInfiniteScroll.scroller = window.infiniteScroll.scroller;
      CSTInfiniteScroll.originalDetermineURL = window.infiniteScroll.scroller.determineURL;
      window.infiniteScroll.scroller.determineURL = CSTInfiniteScroll.determineURL;
      CSTInfiniteScroll.originalUpdateURL = window.infiniteScroll.scroller.updateURL;
      window.infiniteScroll.scroller.updateURL = CSTInfiniteScroll.updateURL;
    },
    vendor_taboola: function(uri,post_id) {
      window.page_counter++;
      var taboola_container = jQuery('.taboola-container-' + post_id);
      if ( ! taboola_container.children().length ) {
        window._taboola = window._taboola || [];
        _taboola.push({mode:'thumbnails-c', container: CSTData.taboola_container_id + window.page_counter, placement: 'Below Article Thumbnails', target_type: 'mix'});
        _taboola.push({article:'auto', url:uri});
        var taboola_container_id = CSTData.taboola_container_id + window.page_counter;
        var taboolaDiv = document.createElement("div");
        taboolaDiv.id = taboola_container_id;
        taboola_container.append( taboolaDiv );
      }
      if( window.page_counter == 1 ) {
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
    }
	};


	$(document).ready(function(){
		// infiniteScroll isn"t ready until the document is loaded
    var infinite_timer = false;
    infinite_timer = setInterval(function() {
      if ('object' === typeof infiniteScroll) {
        if ( infinite_timer ) {
          clearInterval(infinite_timer);
        }
        CSTInfiniteScroll.setupInfiniteScroll();
        CSTInfiniteScroll.init();
      }
    }, 500);

		/*
		 * Jetpack supports IE >= 10, but we support IE9 too
		 */
		if ( isIE && IEVersion == 9 ) {
			var timer = false;
			$( window ).bind( "scroll", function() {
				if ( timer ) {
					clearTimeout( timer );
				}
				timer = setTimeout( window.infiniteScroll.scroller.determineURL , 100 );
			});
		}
	});

}( jQuery ) );
