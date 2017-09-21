/* global CSTMoreHeadlinesData,jQuery */
(function( $ ){

    var CSTHomepageMoreHeadlinesWidget = {

        init: function() {

            this.bindEvents();
          this.setSort();

        },

        bindEvents: function() {

            $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-1");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

          $(".cst-homepage-more-headlines-1").each($.proxy(function (key, el) {
            this.loadSelect2($(el));
          }, this));

            $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-2");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

          $(".cst-homepage-more-headlines-2").each($.proxy(function (key, el) {
            this.loadSelect2($(el));
          }, this));

            $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-3");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

          $(".cst-homepage-more-headlines-3").each($.proxy(function (key, el) {
            this.loadSelect2($(el));
          }, this));

            $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-4");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

          $(".cst-homepage-more-headlines-4").each($.proxy(function (key, el) {
            this.loadSelect2($(el));
          }, this));

            $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-5");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

          $(".cst-homepage-more-headlines-five").each($.proxy(function (key, el) {
            this.loadSelect2($(el));
          }, this));

            $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-6");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

          $(".cst-homepage-more-headlines-6").each($.proxy(function (key, el) {
            this.loadSelect2($(el));
          }, this));

            $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-7");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

          $(".cst-homepage-more-headlines-7").each($.proxy(function (key, el) {
            this.loadSelect2($(el));
          }, this));

            $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-8");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

          $(".cst-homepage-more-headlines-8").each($.proxy(function (key, el) {
            this.loadSelect2($(el));
          }, this));

            $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-9");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

          $(".cst-homepage-more-headlines-9").each($.proxy(function (key, el) {
            this.loadSelect2($(el));
          }, this));

            $( document ).on( "widget-updated widget-added", $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-more-headlines-10");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

          $(".cst-homepage-more-headlines-10").each($.proxy(function (key, el) {
            this.loadSelect2($(el));
          }, this));
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
                    dataType: "json",
                    data: function ( term ) {
                        return {
                            action: "cst_homepage_more_headlines_get_posts",
                            nonce: CSTMoreHeadlinesData.nonce,
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

        },
      setSort: function () {
          if ( jQuery(".cst-headline-sort").length ) {
            jQuery(".cst-headline-sort").sortable({

              revert: true,
              cursor: "move"

            });
          }
      }

    };

    $(document).ready(function(){

        CSTHomepageMoreHeadlinesWidget.init();

    });

}( jQuery ) );