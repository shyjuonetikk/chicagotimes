(function( $ ) {
  "use strict";
  // Handle custom input/settings and refresh
  wp.customize( 'hero_related_posts', function( setting ) {
    var showRelated = function () {
      wp.customize.selectiveRefresh.partial( 'hp_lead_related_stories' );
    };
    var hideRelated = function () {
      wp.customize.selectiveRefresh.partial( 'hp_lead_related_stories' );
    };
    setting.bind( function( to ) {
      ( true === to ) ? showRelated() : hideRelated();
    })
  });
  wp.customize.bind( 'ready', function() {
    var customize = this;
    var showRelated = function () {
      customize.section( 'hp_lead_related_stories' ).activate({ duration: 1000 });
      console.log('ready hp_lead_activate' );
    };
    var hideRelated = function () {
      customize.section( 'hp_lead_related_stories' ).deactivate({ duration: 1000 });
      console.log('ready hp_lead_deactivate' );
    };
    customize( 'hero_related_posts' ).get() ? showRelated() : hideRelated();
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

