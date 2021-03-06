(function(api, $) {
  "use strict";
  var cst_customizer_preview = function(e) {
    var window_width = $( window ).width();
    var sports_stories_section = $("#hp-sports-section-lead");
    var featured_stories_section = $("#featured-stories");
    var top_stories_section = $("#top-stories-section-lead");
    var podcast_stories_section = $("#hp-podcasts-section-lead");

    if (724 === window_width) {
      sports_stories_section.find('.prime-lead-story').addClass("preview-prime-lead-story");
      sports_stories_section.find('.single-mini-story').addClass("preview-single-mini-story");
      sports_stories_section.find('.remaining-stories').addClass("preview-remaining-stories");
      top_stories_section.find('.prime-lead-story').addClass("preview-prime-lead-story");
      top_stories_section.find('.single-mini-story').addClass("preview-single-mini-story");
      top_stories_section.find('.remaining-stories').addClass("preview-remaining-stories");
      podcast_stories_section.find('.prime-lead-story').addClass("preview-prime-lead-story");
      podcast_stories_section.find('.single-mini-story').addClass("preview-single-mini-story");
      podcast_stories_section.find('.remaining-stories').addClass("preview-remaining-stories");
      featured_stories_section.find('.single-mini-story').addClass("preview-single-mini-story");
    } else {
      sports_stories_section.find('.prime-lead-story').removeClass("preview-prime-lead-story");
      sports_stories_section.find('.single-mini-story').removeClass("preview-single-mini-story");
      sports_stories_section.find('.remaining-stories').removeClass("preview-remaining-stories");
      top_stories_section.find('.prime-lead-story').removeClass("preview-prime-lead-story");
      top_stories_section.find('.single-mini-story').removeClass("preview-single-mini-story");
      top_stories_section.find('.remaining-stories').removeClass("preview-remaining-stories");
      podcast_stories_section.find('.prime-lead-story').removeClass("preview-prime-lead-story");
      podcast_stories_section.find('.single-mini-story').removeClass("preview-single-mini-story");
      podcast_stories_section.find('.remaining-stories').removeClass("preview-remaining-stories");
      featured_stories_section.find('.single-mini-story').removeClass("preview-single-mini-story");
    }
  };

  api.bind( 'preview-ready',cst_customizer_preview);
  api.bind( 'change', cst_customizer_preview);
  api.bind( 'ready', cst_customizer_preview);
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
