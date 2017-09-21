(function( $ ){

	var CSTWireCurator = {

		/**
		 * Initialize the Wire Curator
		 */
		init: function() {

			this.refreshButton = $('#cst-refresh-wire-items');
			this.deleteButton = $('#cst-delete-wire-items');
			this.resetButton = $('#cst-reset-wire-items');
			this.previewItemLink = $('a.wire-item-preview');
			this.closePreviewLink = $('#cst-wire-curator-close-preview-item-modal');

			this.wrap = $( '#cst-wire-curator-preview-item-modal-wrap' );
			this.backdrop = $( '#cst-wire-curator-preview-item-modal-backdrop' );
			this.previewHeadline = $('#cst-wire-curator-preview-item-headline h2');
			this.previewContent = $('#cst-wire-curator-preview-item-content');

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
		 * Refresh Wire Items
		 */
		refreshWireItems: function( e ) {

			e.preventDefault();

			var data = {
				action: 'cst_refresh_wire_items',
				nonce: this.refreshButton.data('nonce')
			};

			this.refreshButton.val( this.refreshButton.data( 'in-progress-text' ) );

			$.get( ajaxurl, data, $.proxy( function(){

				location.reload( true );

			}, this ) );

		},
    /**
     * Delete multiple Wire Items
     */
    deleteWireItems: function( e ) {

      e.preventDefault();

      var data = {
        action: 'cst_delete_wire_items',
        nonce: this.deleteButton.data('nonce')
      };

      this.deleteButton.val( 'Delete All' );

      $.get( ajaxurl, data, $.proxy( function(){

        location.reload( true );

      }, this ) );

    },
    /**
     * Reset Items Timer
     */
    resetWireItemsTimer: function( e ) {

      e.preventDefault();

      var data = {
        action: 'cst_reset_items_timer',
        nonce: this.resetButton.data('nonce')
      };

      this.resetButton.val('Resetting...');

      $.get( ajaxurl, data, $.proxy( function() {

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

		}

	};

	$(document).ready(function(){

		CSTWireCurator.init();

	});

}( jQuery ) );
