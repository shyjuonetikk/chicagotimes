(function( $ ){

    var CSTUSATodayWireCurator = {

        /**
         * Initialize the Wire Curator
         */
        init: function() {

            this.refreshButton = $('#cst-refresh-usa-today-wire-items');
            this.deleteButton = $('#cst-delete-usa-today-wire-items');
            this.previewItemLink = $('a.usa-today-wire-item-preview');
            this.closePreviewLink = $('#cst-usa-today-wire-curator-close-preview-item-modal');
            this.resetButton = $('#cst-reset-usa-today-items-timer');
            this.pageForm = $('#posts-filter');
            this.pageForm.before('<span>Only <strong>text type</strong> items will be fetched until support for <strong>video type</strong> is implemented.</span>');

            this.wrap = $( '#cst-usa-today-wire-curator-preview-item-modal-wrap' );
            this.backdrop = $( '#cst-usa-today-wire-curator-preview-item-modal-backdrop' );
            this.previewHeadline = $('#cst-usa-today-wire-curator-preview-item-headline h2');
            this.previewContent = $('#cst-usa-today-wire-curator-preview-item-content');

            this.bindEvents();

        },

        /**
         * Bind events relevant to the Wire Curator
         */
        bindEvents: function() {

            this.refreshButton.on( 'click', $.proxy( this.refreshWireItems, this ) );
            this.previewItemLink.on( 'click', $.proxy( this.showItemPreview, this ) );
            this.closePreviewLink.on( 'click', $.proxy( this.closeItemPreview, this ) );
            this.deleteButton.on( 'click', $.proxy( this.deleteWireItems, this ) );
            this.resetButton.on( 'click', $.proxy( this.resetWireItemsTimer, this ) );

            // Use `esc` key to get out of the preview
            $(document).keyup( $.proxy( function( e ){

                if ( 27 == e.keyCode && this.wrap.is(':visible') ) {
                    this.wrap.hide();
                    this.backdrop.hide();
                }

            }, this ) );

        },

        /**
         * Refresh USA Today Wire Items
         */
        refreshWireItems: function( e ) {

            e.preventDefault();

            var data = {
                action: 'cst_refresh_usa_today_wire_items',
                nonce: this.refreshButton.data('nonce')
            };

            this.refreshButton.val( this.refreshButton.data( 'in-progress-text' ) );

            $.get( ajaxurl, data, $.proxy( function(){

                location.reload( true );

            }, this ) );

        },

        /**
         * Delete All USA Today Wire Items
         */
        deleteWireItems: function( e ) {

            e.preventDefault();

            var data = {
                action: 'cst_delete_usa_today_wire_items',
                nonce: this.deleteButton.data('nonce')
            };

            this.deleteButton.val( 'Delete All' );

            $.get( ajaxurl, data, $.proxy( function(){

                location.reload( true );

            }, this ) );

        },

        /**
         * Show the preview of a wire item
         */
        showItemPreview: function( e ) {

            e.preventDefault();

            var el = $(e.currentTarget);

            this.wrap.show();
            this.backdrop.show();

            var previewData = el.closest('tr').find('.cst-preview-data');

            this.previewHeadline.text( previewData.find('.preview-headline').text() );
            this.previewContent.html( previewData.find('.preview-content').html() );

        },

        /**
         * Hide the preview for the wire item
         */
        closeItemPreview: function( e ) {

            e.preventDefault();

            this.wrap.hide();
            this.backdrop.hide();

        },

        /**
         * Reset USA Today Items Timer
         */
         resetWireItemsTimer: function( e ) {

            e.preventDefault();

            var data = {
                action: 'cst_reset_usa_today_items_timer',
                nonce: this.resetButton.data('nonce')
            };

            this.resetButton.val('Resetting...');

            $.get( ajaxurl, data, $.proxy( function() {

                location.reload( true );

            }, this ) );

         }

    };

    $(document).ready(function(){

        CSTUSATodayWireCurator.init();

    });

}( jQuery ) );
