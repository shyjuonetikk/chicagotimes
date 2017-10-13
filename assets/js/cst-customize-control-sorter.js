/* global jQuery */
(function(api, $) {
  "use strict";
  api.controlConstructor.cst_sf_sorter_control = api.Control.extend({
    ready: function() {
      var control = this;
      var list;
      var element = $("#" + control.id);
      var collection = $("#" + control.id + '-collection');
      api.Control.prototype.ready.call(control);
      element.sortable({
        change: function (event, ui) {
          console.log( ui.item[0].innerText + ' changed' )
          list = element.find('.cst-item')
          var inputValues = list.map(function() {
            return $(this).data('key');
          }).toArray();
          collection.val(inputValues);
          collection.trigger('change')
        }
      });
      console.log( 'Sorter ready ' + element );
    }
  });

})(wp.customize, jQuery);
