(function( $ ){

    var CSTCategoryHeadlinesWidget = {

        init: function() {

            this.bindEvents();

        },

        bindEvents: function() {

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-category-headlines-one");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-category-headlines-one").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-category-headlines-two");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-category-headlines-two").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-category-headlines-three");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-category-headlines-three").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-category-headlines-four");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-category-headlines-four").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-category-headlines-five");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-category-headlines-five").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-category-headlines-six");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-category-headlines-six").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-category-headlines-seven");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-category-headlines-seven").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

            $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
                var el = widget.find(".cst-category-headlines-eight");
                if ( el.length ) {
                    this.loadSelect2( el );
                }
            }, this ) );

            $(".cst-category-headlines-eight").each( $.proxy( function( key, el ){
                this.loadSelect2( $( el ) );
            }, this ) );

        },

        /**
         * Load select2 for the element
         */
        loadSelect2: function( el ) {

            el.select2({
                placeholder: CSTCategoryHeadlinesData.placeholder_text,
                minimumInputLength: 0,
                allowClear: true,
                ajax: {
                    quietMillis: 150,
                    url: ajaxurl,
                    dataType: 'json',
                    data: function ( term ) {
                        return {
                            action: 'cst_category_headlines_get_posts',
                            nonce: CSTCategoryHeadlinesData.nonce,
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

        CSTCategoryHeadlinesWidget.init();

    });

    jQuery(document).ajaxSuccess(function(e, xhr, settings) {

        if ( settings.dataType == 'json' ) {
            return;
        }
        if ( settings.data.match(/add_new=multi/) ) {
            return;
        }
        if ( settings.data.match(/action=save-widget/) && settings.data.match(/widget-cst_category_headlines/) ) {
            CSTCategoryHeadlinesWidget.init();
        }
    });

}( jQuery ) );