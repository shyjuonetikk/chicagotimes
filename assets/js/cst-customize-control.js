(function( $ ) {
  "use strict";
  var CSTCustomizerControl = {

    input_elements : [
      "js-cst-homepage-headlines-one",
      "js-cst-homepage-headlines-two",
      "js-cst-homepage-headlines-three"
    ],
    init: function() {
      console.log('CSTCustomizerControl init.')
    },

    loadSelect2: function( el ) {

      el.select2({
        placeholder: CSTCustomizerControlData.placeholder_text,
        minimumInputLength: 3,
        allowClear: true,
        ajax: {
          quietMillis: 150,
          url: ajaxurl,
          dataType: 'json',
          data: function ( term ) {
            return {
              action: 'cst_customizer_control_homepage_headlines',
              nonce: CSTCustomizerControlData.nonce,
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

    console.log('The CSTCustomizerControl init.')
    CSTCustomizerControl.input_elements.map(function(element) {
      var el = $('.'+element);
      if ( el.length ) {
        CSTCustomizerControl.loadSelect2( el );
      }
    });
    wp.customize.bind( 'preview-ready', function() {
      console.log( 'The CST Customizer Control preview ready' );
    } );
  });
} )( jQuery );

