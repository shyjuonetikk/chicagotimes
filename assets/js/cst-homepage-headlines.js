/* global CSTCategoryHeadlinesData */
(function( $ ){

    var CSTHomepageHeadlinesWidget = {

        init: function() {

            this.bindEvents();

        },

        bindEvents: function() {

          $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
              var el = widget.find(".cst-homepage-headlines-one");
              if ( el.length ) {
                  this.loadSelect2( el );
              }
          }, this ) );

          $(".cst-homepage-headlines-one").each( $.proxy( function( key, el ){
              this.loadSelect2( $( el ) );
          }, this ) );

          $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
              var el = widget.find(".cst-homepage-headlines-two");
              if ( el.length ) {
                  this.loadSelect2( el );
              }
          }, this ) );

          $(".cst-homepage-headlines-two").each( $.proxy( function( key, el ){
              this.loadSelect2( $( el ) );
          }, this ) );

          $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
              var el = widget.find(".cst-homepage-headlines-three");
              if ( el.length ) {
                  this.loadSelect2( el );
              }
          }, this ) );

          $(".cst-homepage-headlines-three").each( $.proxy( function( key, el ){
              this.loadSelect2( $( el ) );
          }, this ) );

          $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
              var el = widget.find(".cst-homepage-mini-headlines-one");
              if ( el.length ) {
                  this.loadSelect2( el );
              }
          }, this ) );

          $(".cst-homepage-mini-headlines-one").each( $.proxy( function( key, el ){
            this.loadSelect2( $( el ) );
          }, this ) );

          $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
            var el = widget.find(".cst-homepage-mini-headlines-two");
            if ( el.length ) {
              this.loadSelect2( el );
            }
          }, this ) );

          $(".cst-homepage-mini-headlines-two").each( $.proxy( function( key, el ){
            this.loadSelect2( $( el ) );
          }, this ) );

          $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
              var el = widget.find(".cst-homepage-mini-headlines-three");
              if ( el.length ) {
                  this.loadSelect2( el );
              }
          }, this ) );

          $(".cst-homepage-mini-headlines-three").each( $.proxy( function( key, el ){
            this.loadSelect2( $( el ) );
          }, this ) );

          $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
            var el = widget.find(".cst-homepage-mini-headlines-four");
            if ( el.length ) {
              this.loadSelect2( el );
            }
          }, this ) );

          $(".cst-homepage-mini-headlines-four").each( $.proxy( function( key, el ){
            this.loadSelect2( $( el ) );
          }, this ) );

          $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
            var el = widget.find(".cst-homepage-mini-headlines-five");
            if ( el.length ) {
              this.loadSelect2( el );
            }
          }, this ) );

          $(".cst-homepage-mini-headlines-five").each( $.proxy( function( key, el ){
            this.loadSelect2( $( el ) );
          }, this ) );
          $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
            var el = widget.find(".cst-homepage-story-block-headlines-one");
            if ( el.length ) {
              this.loadSelect2( el );
            }
          }, this ) );

          $(".cst-homepage-story-block-headlines-one").each( $.proxy( function( key, el ){
            this.loadSelect2( $( el ) );
          }, this ) );

          $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
            var el = widget.find(".cst-homepage-story-block-headlines-two");
            if ( el.length ) {
              this.loadSelect2( el );
            }
          }, this ) );

          $(".cst-homepage-story-block-headlines-two").each( $.proxy( function( key, el ){
            this.loadSelect2( $( el ) );
          }, this ) );

          $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
            var el = widget.find(".cst-homepage-story-block-headlines-three");
            if ( el.length ) {
              this.loadSelect2( el );
            }
          }, this ) );

          $(".cst-homepage-story-block-headlines-three").each( $.proxy( function( key, el ){
            this.loadSelect2( $( el ) );
          }, this ) );

          $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
            var el = widget.find(".cst-homepage-story-block-headlines-four");
            if ( el.length ) {
              this.loadSelect2( el );
            }
          }, this ) );

          $(".cst-homepage-story-block-headlines-four").each( $.proxy( function( key, el ){
            this.loadSelect2( $( el ) );
          }, this ) );

          $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
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
                placeholder: CSTCategoryHeadlinesData.placeholder_text,
                minimumInputLength: 3,
                allowClear: true,
                ajax: {
                    quietMillis: 150,
                    url: ajaxurl,
                    dataType: "json",
                    data: function ( term ) {
                        return {
                            action: "cst_homepage_headlines_get_posts",
                            nonce: CSTCategoryHeadlinesData.nonce,
                            searchTerm: term
                        };
                    },
                    results: function( data ) {
                        return { results: data };
                    }
                },
                initSelection: function( el, callback ) {
                    callback( { id: el.val(), text: el.data("story-title" ) } );
                }
            });

        }
    };

    $(document).ready(function(){

        CSTHomepageHeadlinesWidget.init();

    });

}( jQuery ) );