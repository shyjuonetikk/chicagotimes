(function (api, $) {
  "use strict";

  api("upper_section_section_title", function (setting) {
    setting.bind(function (to) {
      var updateMe = function (newval) {
        setting.set(newval);
      };
      updateMe(to);
    });
  });
  /*
  * Sports section select auto update
  * Pull this value when Select2 fires and pass with query request for section constraints
  */
  var section_select = [
    "sport_section_lead", "sport_other_section_1", "sport_other_section_2", "sport_other_section_3", "sport_other_section_4"
  ];
  _.each(section_select, function (setting) {
    api.bind(setting, function (to) {
      var updateMe = function (newval) {
        setting.set(newval);
      };
      updateMe(to);
    });
  });

})(wp.customize, jQuery);

