(function( $ ) {
  "use strict";
  var CSTCustomizerControl = {

    input_elements : [
      "js-cst-homepage-headlines-one",
      "js-cst-homepage-headlines-two",
      "js-cst-homepage-headlines-three"
    ],

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


    wp.customize.controlConstructor.cst_select_control = wp.customize.Control.extend( {
      ready: function() {
        var control = this;
        wp.customize.Control.prototype.ready.call( control );
        // Set up select2 control in this.container...
        console.log('The CSTCustomizerControl init.');

          var el = $('.'+this.id);
            CSTCustomizerControl.loadSelect2( el );
            wp.customize( this.id, function( value ) {
              value.bind( function( to ) {
                console.log(value+' : value.');
              } );
            } );
            el.on("change", function (e) {
              console.log("change: "+JSON.stringify({val:e.val}))
            })
              .on("select2-focus", function(e) { console.log ("focus");})
      }
    } );

} )( jQuery );

