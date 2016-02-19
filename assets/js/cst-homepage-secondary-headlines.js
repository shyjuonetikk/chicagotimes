/* global CSTSecondaryHeadlinesData */
(function( $ ){

    var CSTHomepageSecondaryHeadlinesWidget = {

        init: function() {

            this.bindEvents();
            this.setSort();

        },

        bindEvents: function() {

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-secondary-headlines-one");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-homepage-secondary-headlines-one").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-secondary-headlines-two");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-homepage-secondary-headlines-two").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-secondary-headlines-three");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-homepage-secondary-headlines-three").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-homepage-secondary-headlines-four");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-homepage-secondary-headlines-four").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

        },

        /**
         * Load select2 for the element
         */
        loadSelect2: function( el ) {

            el.select2({
                placeholder: CSTSecondaryHeadlinesData.placeholder_text,
                minimumInputLength: 0,
                allowClear: true,
                ajax: {
                    quietMillis: 150,
                    url: ajaxurl,
                    dataType: 'json',
                    data: function ( term ) {
                        return {
                            action: 'cst_homepage_secondary_headlines_get_posts',
                            nonce: CSTSecondaryHeadlinesData.nonce,
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

        CSTHomepageSecondaryHeadlinesWidget.init();

    });

    jQuery(document).ajaxSuccess(function(e, xhr, settings) {

        if ( settings.dataType == 'json' ) {
            return;
        }
        if ( settings.data.match(/add_new=multi/) ) {
            return;
        }
        if ( settings.data.match(/action=save-widget/) && settings.data.match(/widget-cst_homepage_secondary_headlines/) ) {
            CSTHomepageSecondaryHeadlinesWidget.init();
        }
    });

}( jQuery ) );