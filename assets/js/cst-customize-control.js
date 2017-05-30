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
                        return {
                            action: "cst_customizer_control_homepage_headlines",
                            nonce: CSTCustomizerControlData.nonce,
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
            var el = $("." + control.id);
            var selectedValue, markupId;
            var temp = control.id.replace(/_/gi, "-");
            api.Control.prototype.ready.call( control );
            markupId = "#js-" + temp;
            CSTCustomizerControl.loadSelect2(el);
            el.on("change", function (e) {
                selectedValue = e.val;
                api(control.id, function(value) {
                    var updateMe = function(newval) {
                       value.set(newval);
                    };
                    updateMe(selectedValue);
                    value.bind(function (to) {
                      jQuery(markupId).html(to);
                    });
                });
            });
        }
    });

})( wp.customize,jQuery);

