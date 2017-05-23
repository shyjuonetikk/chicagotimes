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
        var el = $('.'+this.id);
        var selectedValue, markupId;
        var temp = this.id.replace(/_/gi,'-');
        console.info('CSTCustomizerControl init field: '+ this.id + ' -> ' + temp);
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
  wp.customize.bind( 'ready', function() {
    var customize = this;
    var showRelated = function () {
      customize.section( 'hp_lead_related_stories' ).activate({ duration: 1000 });
    };
    var hideRelated = function () {
      customize.section( 'hp_lead_related_stories' ).deactivate({ duration: 1000 });
    };
    customize( 'hero_related_posts' ).get() ? showRelated() : hideRelated();
  });

  // Handle custom input/settings and refresh
  wp.customize( 'hero_related_posts', function( setting ) {
    var showRelated = function () {
      wp.customize.section( 'hp_lead_related_stories' ).activate({ duration: 1000 });
      wp.customize.section( 'hp_lead_related_stories' ).focus();
    };
    var hideRelated = function () {
      wp.customize.section( 'hp_lead_related_stories' ).deactivate({ duration: 1000 });
      wp.customize.section( 'hp_lead_stories' ).focus();
    };
    setting.bind( function( to ) {
      ( true === to ) ? showRelated() : hideRelated();
    })
  });
  wp.customize( 'upper_section_section_title', function( setting ) {
    setting.bind( function( to ) {
      var updateMe = function(newval) {
        setting.set(newval)
      };
      updateMe(to);
    })
  })
} )( jQuery );

