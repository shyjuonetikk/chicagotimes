(function( $, CSTAdminData ){

	var CSTAdmin = {

		/**
		 * Initialize admin customizations
		 */
		init: function() {

			this.cacheElements();

			this.addPrintFeedLabels();

			this.renderBulkActions();

			if ( $(this.excerptTextArea).length ) {
				this.changeExcerptDescription();
				this.limitTheField( this.excerptTextArea, 150 );
				this.appendPostStickyHTML();
			}

			$('.fm-featured_media_type select').on('change', $.proxy( function(){
				this.toggleVisibleFeaturedMedia();
			}, this ) );

			if ( $('.fm-featured_media_type select').length ) {
				this.toggleVisibleFeaturedMedia();
			}

			if ( $(this.cstSectionBox).length ) {
				this.addSectionWarning();
			}

			if ( $(this.titleContent).length ) {
				this.limitTheField( this.titleContent, 65 );
			}

		},

		cacheElements: function() {

			this.excerptTextArea = $('#postexcerpt .inside textarea');
			this.description = $('#postexcerpt .inside p');

			this.attachmentCaption = $('#attachment_caption');

			this.cstSectionBox = $('#cst_section-adder');

			this.titleContent = $('#titlewrap #title');
		},

		/**
		 * Add labels to article titles that are in the print feed
		 */
		addPrintFeedLabels: function() {

			$('tr.cst-is-in-print-feed .post-title strong').each( function( key, value ){
				$(this).append('<i class="dashicons dashicons-welcome-widgets-menus"></i>').attr('title', CSTAdminData.included_in_print_feed_label);
			});

		},

		/**
		 * Add / remove elements from Bulk Actions, because there's no proper API
		 */
		renderBulkActions: function() {

			var bulkActions = $('.bulkactions select');
			if ( CSTAdminData.current_user_can_edit_print_feed && $('body.post-type-cst_article').length && bulkActions.length ) {

				bulkActions.find('option[value="edit"]').after( '<option value="cst-add-print-feed"></option><option value="cst-remove-print-feed"></option>' );
				bulkActions.find('option[value="cst-add-print-feed"]').text( CSTAdminData.add_to_print_feed_label );
				bulkActions.find('option[value="cst-remove-print-feed"]').text( CSTAdminData.remove_from_print_feed_label );

			}

		},

		changeExcerptDescription: function() {
			this.description.html('Excerpts are a short summary of your post. In most cases, your lede will be fine.');
			this.description.css('visibility', 'visible');
		},

		addSectionWarning: function() {
			this.cstSectionBox.prepend('<p class="howto">Either choose News or Sports as your main section.  Do not choose both.</p>');
		},

		limitTheField: function( theField, maxCharacters ) {
			theField.attr('maxlength', maxCharacters);
			theField.after('<p id="character-limit"><span id="remaining-characters"></span> characters remaining.</p>');
			var remainingCharacters = $('#remaining-characters');
			remainingCharacters.html(maxCharacters - theField.val().length);
			theField.on('keyup', function(e) {
				var textRemaining = maxCharacters - $(this).val().length;
				remainingCharacters.html(textRemaining);
				if ( textRemaining < 11 ) {
					remainingCharacters.css('color', 'red');
				} else{
					remainingCharacters.css('color', '#444');
				}
			});
		},

		/**
		 * Toggle the visible "Featured Media" element
		 */
		toggleVisibleFeaturedMedia: function() {
			$('.fm-featured_video-wrapper').hide();
			$('.fm-featured_gallery-wrapper').hide();
			var selected = $('.fm-featured_media_type select option:selected').val();
			$('.fm-featured_' + selected + '-wrapper').show();
			$(document).trigger( 'fm_added_element' );
		},

		/**
		 * Append HTML used to make a custom post type sticky
		 *
		 * @see https://core.trac.wordpress.org/ticket/12702
		 */
		appendPostStickyHTML: function() {

			$('#hidden-post-visibility').before( CSTAdminData.post_sticky_hidden_html );
			$('#visibility-radio-password').before( CSTAdminData.post_sticky_visible_html );
			if ( CSTAdminData.post_is_sticky ) {
				$('#post-visibility-display').append( ', Sticky' );
			}

		}

	};

	if ( typeof wp != 'undefined' && typeof wp.media != 'undefined' ) {

		/**
		 * Bind the caption handler
		 */
		var WPViewAttachmentDetails = wp.media.view.Attachment.Details;
		var CSTViewAttachmentDetails = wp.media.view.Attachment.Details.extend({

			render: function() {
				WPViewAttachmentDetails.prototype.render.apply( this, arguments );
				setTimeout( function(){
					var caption = $('.media-frame-content label[data-setting="caption"] textarea');
					if ( caption.length ) {
						CSTAdmin.limitTheField( caption, 500 );
					}
				}, 1 );
			}

		});

		wp.media.view.Attachment.Details = CSTViewAttachmentDetails;

	}

	/**
	 * Wait until the document is ready before initializing the admin
	 */
	$(document).ready(function(){

		CSTAdmin.init();

	});

}( jQuery, CSTAdminData ) );
