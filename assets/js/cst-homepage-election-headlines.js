/* global CSTElectionHeadlinesData */
(function( $ ){

  var CSTHomepageElectionHeadlinesWidget = {

    init: function() {

      this.bindEvents();
      this.setSort();

    },

    bindEvents: function() {

      $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
        var el = widget.find(".cst-election-2016-more-headlines-one");
        if ( el.length ) {
          this.loadSelect2( el );
        }
      }, this ) );

      $(".cst-election-2016-more-headlines-one").each( $.proxy( function( key, el ){
        this.loadSelect2( $( el ) );
      }, this ) );

      $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
        var el = widget.find(".cst-election-2016-more-headlines-two");
        if ( el.length ) {
          this.loadSelect2( el );
        }
      }, this ) );

      $(".cst-election-2016-more-headlines-two").each( $.proxy( function( key, el ){
        this.loadSelect2( $( el ) );
      }, this ) );

      $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
        var el = widget.find(".cst-election-2016-more-headlines-three");
        if ( el.length ) {
          this.loadSelect2( el );
        }
      }, this ) );

      $(".cst-election-2016-more-headlines-three").each( $.proxy( function( key, el ){
        this.loadSelect2( $( el ) );
      }, this ) );

      $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
        var el = widget.find(".cst-election-2016-more-headlines-four");
        if ( el.length ) {
          this.loadSelect2( el );
        }
      }, this ) );

      $(".cst-election-2016-more-headlines-four").each( $.proxy( function( key, el ){
        this.loadSelect2( $( el ) );
      }, this ) );

      $( document ).on( 'widget-updated widget-added', $.proxy( function( event, widget ){
        var el = widget.find(".cst-election-2016-more-headlines-five");
        if ( el.length ) {
          this.loadSelect2( el );
        }
      }, this ) );

      $(".cst-election-2016-more-headlines-five").each( $.proxy( function( key, el ){
        this.loadSelect2( $( el ) );
      }, this ) );

    },

    /**
     * Load select2 for the element
     */
    loadSelect2: function( el ) {

      el.select2({
        placeholder: CSTElectionHeadlinesData.placeholder_text,
        minimumInputLength: 0,
        allowClear: true,
        ajax: {
          quietMillis: 150,
          url: ajaxurl,
          dataType: 'json',
          data: function ( term ) {
            return {
              action: 'cst_election_2016_more_headlines_get_posts',
              nonce: CSTElectionHeadlinesData.nonce,
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
      jQuery('.cst-election-2016-headline-sort').sortable({

        revert: true,
        cursor: 'move'

      });
    }

  };

  $(document).ready(function(){

    CSTHomepageElectionHeadlinesWidget.init();

  });

}( jQuery ) );