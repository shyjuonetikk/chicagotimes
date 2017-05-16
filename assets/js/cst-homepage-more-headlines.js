/* global CSTMoreHeadlinesData */
(function( $ ){

    var CSTHomepageMoreHeadlinesWidget = {

        init: function() {

            this.bindEvents();
          this.setSort();

        },

        bindEvents: function() {

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-one");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-homepage-more-headlines-one").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-two");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-homepage-more-headlines-two").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-three");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-homepage-more-headlines-three").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-four");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-homepage-more-headlines-four").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-five");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-homepage-more-headlines-five").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-six");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-homepage-more-headlines-six").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-seven");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-homepage-more-headlines-seven").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-eight");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-homepage-more-headlines-eight").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-nine");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-homepage-more-headlines-nine").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-ten");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-homepage-more-headlines-ten").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );
          $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
            var el = widget.find(".cst-homepage-story-block-headlines-one");
            if ( el.length ) {
              this.loadSelect2( el );
            }
          }, this ) );

          $(".cst-homepage-story-block-headlines-one").each( $.proxy( function( key, el ){
            this.loadSelect2( $( el ) );
          }, this ) );

          $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
            var el = widget.find(".cst-homepage-story-block-headlines-two");
            if ( el.length ) {
              this.loadSelect2( el );
            }
          }, this ) );

          $(".cst-homepage-story-block-headlines-two").each( $.proxy( function( key, el ){
            this.loadSelect2( $( el ) );
          }, this ) );

          $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
            var el = widget.find(".cst-homepage-story-block-headlines-three");
            if ( el.length ) {
              this.loadSelect2( el );
            }
          }, this ) );

          $(".cst-homepage-story-block-headlines-three").each( $.proxy( function( key, el ){
            this.loadSelect2( $( el ) );
          }, this ) );

          $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
            var el = widget.find(".cst-homepage-story-block-headlines-four");
            if ( el.length ) {
              this.loadSelect2( el );
            }
          }, this ) );

          $(".cst-homepage-story-block-headlines-four").each( $.proxy( function( key, el ){
            this.loadSelect2( $( el ) );
          }, this ) );

          $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
            var el = widget.find(".cst-homepage-story-block-headlines-five");
            if ( el.length ) {
              this.loadSelect2( el );
            }
          }, this ) );

          $(".cst-homepage-story-block-headlines-five").each( $.proxy( function( key, el ){
            this.loadSelect2( $( el ) );
          }, this ) );
        },

        /**
         * Load select2 for the element
         */
        loadSelect2: function( el ) {

            el.select2({
                placeholder: CSTMoreHeadlinesData.placeholder_text,
                minimumInputLength: 0,
                allowClear: true,
                ajax: {
                    quietMillis: 150,
                    url: ajaxurl,
                    dataType: 'json',
                    data: function ( term ) {
                        return {
                            action: 'cst_homepage_more_headlines_get_posts',
                            nonce: CSTMoreHeadlinesData.nonce,
                            searchTerm: term
                        };
                    },
                    results: function( data ) {
                        return { results: data };
                    }
                },
                initSelection: function( el, callback ) {
                    callback( { id: el.val(), text: el.data('story-title' ) } );
                }
            });

        },
      setSort: function () {
        jQuery('.cst-headline-sort').sortable({

          revert: true,
          cursor: 'move'

        });
      }

    };

    $(document).ready(function(){

        CSTHomepageMoreHeadlinesWidget.init();

    });

}( jQuery ) );