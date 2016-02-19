(function( $ ){

    var CSTBreakingNewsWidget = {

        init: function() {

            this.bindEvents();

        },

        bindEvents: function() {

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-breaking-news-story-id");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-breaking-news-story-id").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

        },

        /**
         * Load select2 for the element
         */
        loadSelect2: function( el ) {

            el.select2({
                placeholder: CSTBreakingNewsWidgetData.placeholder_text,
                minimumInputLength: 0,
                allowClear: true,
                ajax: {
                    quietMillis: 150,
                    url: ajaxurl,
                    dataType: 'json',
                    data: function ( term ) {
                        return {
                            action: 'cst_breaking_news_get_posts',
                            nonce: CSTBreakingNewsWidgetData.nonce,
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

        }

    };

    $(document).ready(function(){

        CSTBreakingNewsWidget.init();

    });

    jQuery(document).ajaxSuccess(function(e, xhr, settings) {

        if ( settings.dataType == 'json' ) {
            return;
        }
        if ( settings.data.match(/add_new=multi/) ) {
            return;
        }
        if ( settings.data.match(/action=save-widget/) && settings.data.match(/widget-cst_breaking_news/) ) {
            CSTBreakingNewsWidget.init();
        }
    });

}( jQuery ) );