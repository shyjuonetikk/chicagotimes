(function (api,$) {
    "use strict";

    api("upper_section_section_title", function (setting) {
        setting.bind(function(to) {
            var updateMe = function (newval) {
                setting.set(newval);
            };
          updateMe(to);
        });
    });
})(wp.customize,jQuery);

