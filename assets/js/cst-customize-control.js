(function( $ ) {
  "use strict";
  var CSTCustomizerControl = {

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
        console.info('CSTCustomizerControl init customizer field: '+ this.id);

          var el = $('.'+this.id);
          var selectedValue, markupId;
          var temp = this.id.replace(/_/gi,'-');
          markupId = '#js-'+ temp;
            CSTCustomizerControl.loadSelect2( el );

            el.on("change", function (e) {
              selectedValue = e.val;
              wp.customize( this.id, function( value ) {
                var updateMe = function(newval) {
                  value.set(newval)
                };
                updateMe(selectedValue);
                value.bind( function( to ) {
                  $(markupId).html(to);
                } );
              } );
            });
      }
    } );

} )( jQuery );

