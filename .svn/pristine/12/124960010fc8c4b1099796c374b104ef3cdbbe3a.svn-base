(function( $, wp ){

	var l10n = wp.media.view.l10n = typeof _wpMediaViewsL10n === 'undefined' ? {} : _wpMediaViewsL10n;
	var isTouchDevice = ( 'ontouchend' in document );
	var CSTMerlin = {};

	/**
	 * Overloads the toolbar appearing at the bottom of the gallery to include our own button
	 */
	CSTMerlin.Toolbar = wp.media.view.Toolbar;
	wp.media.view.Toolbar = CSTMerlin.Toolbar.extend({

		/**
		 * Initialize the Toolbar that appears below the grid of images.
		 */
		initialize: function() {

			var controller = arguments[0].controller,
				state = false,
				options = this.options;

			if ( typeof controller.state == 'function' ) {
				state = controller.state();
			}

			if ( state && 'browse' == state.get('router') ) {
				options.items = _.defaults( options.items || {}, {
					import_merlin: {
						style:    'primary',
						text:     CSTMerlinData.import_label,
						classes:  'cst-import-merlin',
						priority: 80,
						click:    this.clickImportMerlin,
						requires: {
							selection: true
						}
					}
				});
			}

			// Firing the parent loads this business
			CSTMerlin.Toolbar.prototype.initialize.apply( this, arguments );

		},

		/**
		 * Import current selection into WordPress
		 */
		clickImportMerlin: function( view ) {

			var controller = this.controller;
			var state = controller.state(),
				selection = state.get('selection');

			var merlinIds = [];
			selection.each( function( attachment ){
				merlinIds.push( attachment.id );
			});

			var el = $(view.currentTarget);
			el.text( CSTMerlinData.importing_label );
			el.attr('disabled', 'disabled');
			$('#merlin-import-error').remove();

			var deferred = wp.ajax.send( 'cst_import_merlin', {
				type: 'GET',
				data: {
					nonce: CSTMerlinData.nonce,
					post_id: CSTMerlinData.post_id,
					merlin_ids: merlinIds
				}
			} );

			deferred.always( function() {
				selection.reset();
				el.removeAttr('disabled').text( CSTMerlinData.import_label );
			});

			deferred.done( function( response ){

				// @todo load the attachments view

			});

			deferred.fail( function( message ){

				var error = $('<div id="merlin-import-error" />');
				error.text( message );
				el.before( error );

				setTimeout( function(){
					$('#merlin-import-error').fadeOut().remove();
				}, 10000 );

			});

		}

	});

	/**
	 * Overloads wp.media.view.MediaFrame.Post to add our route and view
	 */
	CSTMerlin.postFrame = wp.media.view.MediaFrame.Post;
	wp.media.view.MediaFrame.Post = CSTMerlin.postFrame.extend({

		initialize: function(){

			/**
			 * call 'initialize' directly on the parent class
			 */
			CSTMerlin.postFrame.prototype.initialize.apply( this, arguments );

		},

		/**
		 * Override the parent's bindHandlers with our own options
		 */
		bindHandlers: function() {
			CSTMerlin.postFrame.prototype.bindHandlers.apply( this, arguments );
			this.on( 'content:create:merlin', this.browseMerlin, this );
			this.on( 'content:render:browse', this.hideMerlin, this );
			this.on( 'content:render:upload', this.hideMerlin, this );
		},

		/**
		 * Override the parent's router with our own options
		 */
		browseRouter: function( routerView ) {

			routerView.set({
				upload: {
					text:     l10n.uploadFilesTitle,
					priority: 20
				},
				browse: {
					text:     l10n.mediaLibraryTitle,
					priority: 40
				},
				merlin: {
					text:     "Merlin",
					priority: 60
				}
			});

		},

		/**
		 * Render callback for the content region of Merlin!
		 */
		browseMerlin: function( contentRegion ) {

			var state = this.state();

			this.$el.removeClass('hide-toolbar');

			contentRegion.view = new CSTMerlin.AssetBrowser({
				controller:       this,
				collection:       new wp.media.query({ type: 'merlin' }),
				selection:        state.get('selection'),
				model:            state,
				sortable:         false,
				filters:          false,
				search:           true,
				multiple:         true,
				sidebar:          false,

				AttachmentView:   wp.media.view.Attachment.Library
			});

		},

		/**
		 * When the Merlin tab is closed
		 */
		hideMerlin: function() {

			var toolbar = this.$el.find('.media-frame-toolbar');
			toolbar.find('a.media-button-gallery').show();
			toolbar.find('a.media-button-insert').show();
			toolbar.find('a.cst-import-merlin').hide();

		}

	});

	/**
	 * Overload AttachmentsBrowser to handle our own attachment display
	 */
	CSTMerlin.AssetBrowser = wp.media.view.AttachmentsBrowser.extend({

		initialize: function() {

			wp.media.view.AttachmentsBrowser.prototype.initialize.apply( this, arguments );

			_.defer(function(){

				var toolbar = $('.media-frame-toolbar');

				toolbar.find('a.media-button-gallery').hide();
				toolbar.find('a.media-button-insert').hide();
				toolbar.find('a.cst-import-merlin').show();

			});

		}

	});

	/**
	 * Overload Attachment.Library to ensure Merlin items are added with app index
	 */
	CSTMerlin.AttachmentsView = wp.media.view.Attachments.extend({

		initialize: function() {

			this.el.id = _.uniqueId('__attachments-view-');

			_.defaults( this.options, {
				refreshSensitivity: isTouchDevice ? 300 : 200,
				refreshThreshold:   3,
				AttachmentView:     media.view.Attachment,
				sortable:           false,
				resize:             true,
				idealColumnWidth:   $( window ).width() < 640 ? 135 : 150
			});

			this._viewsByCid = {};

			this.collection.on( 'add', function( attachment ) {
				// @todo figure out how the index of the collection can be zero
				var fixed_index = this.collection.indexOf( attachment );
				if ( fixed_index === 0 ) {
					fixed_index = this.collection.length;
				}
				this.views.add( this.createAttachmentView( attachment ), {
					at: fixed_index
				});
			}, this );

			this.collection.on( 'remove', function( attachment ) {
				var view = this._viewsByCid[ attachment.cid ];
				delete this._viewsByCid[ attachment.cid ];

				if ( view ) {
					view.remove();
				}
			}, this );

			this.collection.on( 'reset', this.render, this );

			// Throttle the scroll handler and bind this.
			this.scroll = _.chain( this.scroll ).bind( this ).throttle( this.options.refreshSensitivity ).value();

			this.options.scrollElement = this.options.scrollElement || this.el;
			$( this.options.scrollElement ).on( 'scroll', this.scroll );

			this.initSortable();

			_.bindAll( this, 'setColumns' );

			if ( this.options.resize ) {
				$( window ).on( 'resize.media-modal-columns', this.setColumns );
				this.controller.on( 'open', this.setColumns );
			}

			// Call this.setColumns() after this view has been rendered in the DOM so
			// attachments get proper width applied.
			_.defer( this.setColumns, this );

		}

	});
	wp.media.view.Attachments = CSTMerlin.AttachmentsView;

}( jQuery, wp ) );
