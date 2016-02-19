(function( $ ){

    var CSTColumnistsContentWidget = {

        init: function() {

            this.bindEvents();

        },

        bindEvents: function() {

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-columnists-story-id");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-columnists-story-id").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

        },

        /**
         * Load select2 for the element
         */
        loadSelect2: function( el ) {

            el.select2({
                placeholder: CSTColumnistsContentWidgetData.placeholder_text,
                minimumInputLength: 0,
                allowClear: true,
                ajax: {
                    quietMillis: 150,
                    url: ajaxurl,
                    dataType: 'json',
                    data: function ( term ) {
                        return {
                            action: 'cst_columnists_content_get_posts',
                            nonce: CSTColumnistsContentWidgetData.nonce,
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

        CSTColumnistsContentWidget.init();

    });

    jQuery(document).ajaxSuccess(function(e, xhr, settings) {

        if ( settings.dataType == 'json' ) {
            return;
        }
        if ( settings.data.match(/add_new=multi/) ) {
            return;
        }
        if ( settings.data.match(/action=save-widget/) && settings.data.match(/widget-cst_columnists_content/) ) {
            CSTColumnistsContentWidget.init();
        }
    });

}( jQuery ) );