/* global ajaxurl,CSTCustomizerControlData,CSTCustomizerControl,jQuery */
(function(api, $) {
    "use strict";
    var CSTCustomizerControl = {

        loadSelect2: function (el) {

            el.select2({
                placeholder: CSTCustomizerControlData.placeholder_text,
                minimumInputLength: 3,
                allowClear: true,
                ajax: {
                    quietMillis: 150,
                    url: ajaxurl,
                    dataType: "json",
                    data: function (term) {
                      /* Retrieve relevant section term id from closest dropdown and pass in cst_section */
                      var t = term;
                        return {
                            action: "cst_customizer_control_homepage_headlines",
                            nonce: CSTCustomizerControlData.nonce,
                            cst_section: CSTCustomizerControlData.cst_section,
                            searchTerm: term
                        };
                    },
                    results: function (data) {
                        return {results: data};
                    }
                },
                initSelection: function (el, callback) {
                    callback({id: el.val(), text: el.data("story-title")});
                }
            });
        }
    };

    api.controlConstructor.cst_select_control = api.Control.extend({
        ready: function () {
            var control = this;
            var element = $("." + control.id);
            var selectedValue;
            api.Control.prototype.ready.call( control );
            CSTCustomizerControl.loadSelect2(element);
            element.on("change", function (e) {
                selectedValue = e.val;
                api(control.id, function(value) {
                    var updateMe = function(newval) {
                       value.set(newval);
                    };
                    updateMe(selectedValue);
                });
            });
        }
    });

})( wp.customize,jQuery);

