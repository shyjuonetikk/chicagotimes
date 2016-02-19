(function( $ ){

	var CSTFeaturedContentWidget = {

		init: function() {

			this.bindEvents();

		},

		bindEvents: function() {

			$( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
				var el = widget.find(".cst-featured-story-id");
				if ( el.length ) {
					this.loadSelect2( el );
				}
			}, this ) );

			$(".single-sidebar .cst-featured-story-id").each( $.proxy( function( key, el ){
				this.loadSelect2( $( el ) );
			}, this ) );

		},

		/**
		 * Load select2 for the element
		 */
		loadSelect2: function( el ) {

			el.select2({
				placeholder: CSTFeaturedContentWidgetData.placeholder_text,
				minimumInputLength: 0,
				allowClear: true,
				ajax: {
					quietMillis: 150,
					url: ajaxurl,
					dataType: 'json',
					data: function ( term ) {
						return {
							action: 'cst_featured_content_get_posts',
							nonce: CSTFeaturedContentWidgetData.nonce,
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

		CSTFeaturedContentWidget.init();

	});

}( jQuery ) );