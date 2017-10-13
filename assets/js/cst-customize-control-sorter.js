/* global jQuery */
(function(api, $) {
  "use strict";
  api.controlConstructor.cst_sf_sorter_control = api.Control.extend({
    ready: function() {
      var control = this;
      var element = $("#" + control.id);
      api.Control.prototype.ready.call(control);
      element.sortable();
      console.log( 'Sorter ready ' + element );
    }
  });

})(wp.customize, jQuery);
