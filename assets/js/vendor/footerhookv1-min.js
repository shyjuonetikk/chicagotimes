jQuery( document ).ready(function( $ ) {
  var consoleParentContainer = $(".nc-console-container").parent(), consoleParentContainerWidth = consoleParentContainer.width(), widthVar46 = "";
  consoleParentContainerWidth >= 835 ? (widthVar46 = "835+", $("#stylesheet-dimensions").attr("href", "//media.newjobs.com/cms/OpenTemplate/Newspaper/2016/css/main_835x165_fluid.css")) : 835 > consoleParentContainerWidth && consoleParentContainerWidth >= 640 ? (widthVar46 = "835", $("#stylesheet-dimensions").attr("href", "//media.newjobs.com/cms/OpenTemplate/Newspaper/2016/css/main_640x360_fluid.css")) : 640 > consoleParentContainerWidth && consoleParentContainerWidth >= 475 ? (widthVar46 = "640", $("#stylesheet-dimensions").attr("href", "//media.newjobs.com/cms/OpenTemplate/Newspaper/2016/css/main_475x520_fluid.css")) : 475 > consoleParentContainerWidth && (widthVar46 = "475-", $("#stylesheet-dimensions").attr("href", "//media.newjobs.com/cms/OpenTemplate/Newspaper/2016/css/main_300x520_fluid.css"));
  var ATMchRES = "desktop|" + monsNppCh + "|console", DYNAMIC_S_ACCOUNT = "newjobsProdNP", DYNAMIC_S_CURRENCYCODE = "USD", amc = amc || {};
  amc.on || (amc.on = amc.call = function () {
  }), _m.ATM.properties = {
    eVar2: "unrecognized",
    channel: "58",
    eVar1: "D=g",
    prop1: "D=g",
    eVar4: "0",
    eVar74: widthVar46,
    "events.event101": "true"
  }, _m.ATM.pageName = ATMchRES, _m.ATM.version = 20130502, _m.ATM.appID = "newspaperconsole", _m.ATM.channelID = 58, _m.ATM.countryID = 164, _m.ATM.appConfig = {
    version: "20130502",
    appID: "js20",
    channelID: "58",
    countryID: "164"
  }, _m.ATM.runOnLoad = !0, function () {
    "undefined" != typeof addMonsterReady ? addMonsterReady(_m.ATM.initFromOnReady) : $(document).ready(_m.ATM.initFromOnReady)
  }();
  var resizeTimer;
  $(window).resize(function () {
    clearTimeout(resizeTimer), resizeTimer = setTimeout(function () {
      consoleParentContainerWidth = $(consoleParentContainer).width(), console.log(consoleParentContainerWidth), consoleParentContainerWidth >= 835 ? $("#stylesheet-dimensions").attr("href", "//media.newjobs.com/cms/OpenTemplate/Newspaper/2016/css/main_835x165_fluid.css") : 835 > consoleParentContainerWidth && consoleParentContainerWidth >= 640 ? $("#stylesheet-dimensions").attr("href", "//media.newjobs.com/cms/OpenTemplate/Newspaper/2016/css/main_640x360_fluid.css") : 640 > consoleParentContainerWidth && consoleParentContainerWidth >= 475 ? $("#stylesheet-dimensions").attr("href", "//media.newjobs.com/cms/OpenTemplate/Newspaper/2016/css/main_475x520_fluid.css") : 475 > consoleParentContainerWidth && $("#stylesheet-dimensions").attr("href", "//media.newjobs.com/cms/OpenTemplate/Newspaper/2016/css/main_300x520_fluid.css")
    }, 200)
  });
  var mnstJs = {
    searchParams: {
      q: {fieldID: "", mFieldID: "", parameterName: "q", value: "", type: "textbox"},
      tjt: {fieldID: "", mFieldID: "", parameterName: "tjt", value: "", type: "textbox"},
      where: {fieldID: "", mFieldID: "", parameterName: "where", value: "", type: "textbox"},
      cn: {fieldID: "", mFieldID: "", parameterName: "cn", value: "", type: "textbox"},
      rad: {fieldID: "", mFieldID: "", parameterName: "rad", value: "", type: "textbox"},
      sort: {fieldID: "", parameterName: "sort", type: "sortButton", value: "", dt: {fieldID: "btnSortByDate", mFieldID: "", value: "dt.rv.di"}, rv: {fieldID: "btnSortByRel", mFieldID: "", value: "rv.dt.di"}},
      lv: {fieldID: "", mFieldID: "", parameterName: "lv", value: "", type: "checkbox"},
      jt: {fieldID: "", mFieldID: "", parameterName: "jt", value: "", type: "checkbox"},
      occ: {fieldID: "", mFieldID: "", parameterName: "occ", value: "", type: "checkbox"}
    }, button: {name: ""}, form: {name: "", searchEndPoint: ""}, enableToggleSortButton: !1, searchQS: [], doSetProperties: function () {
      var e, t;
      mnstJs.searchQS = [];
      for (var n in mnstJs.searchParams)t = mnstJs.searchParams[n], e = t.mFieldID && $("#" + t.mFieldID).val() ? t.mFieldID : t.fieldID, t.value ? mnstJs.searchQS.push(t.parameterName + "=" + encodeURIComponent(t.value)) : e && ("checkbox" == t.type ? $("input[id^=" + e + "]:checked").each(function (e) {
        mnstJs.searchQS.push(t.parameterName + "=" + encodeURIComponent($(this).val()))
      }) : $("#" + e).val() && mnstJs.searchQS.push(t.parameterName + "=" + encodeURIComponent($("#" + e).val())))
    }, doCalculateSearch: function () {
      var e = mnstJs.form.searchEndPoint ? mnstJs.form.searchEndPoint : $(mnstJs.form.name).attr("action");
      return mnstJs.searchQS.length > 0 && (e += (e.indexOf("?") > 0 ? "&" : "?") + mnstJs.searchQS.join("&")), "_blank" == $(mnstJs.form.name).attr("target") ? window.open(e) : window.location.href = e, !1
    }, doOnClickTracking: function () {
      s.eVar74 = widthVar46, s.events = "event102", s.tl()
    }, doParseQsInput: function () {
      monsNppDefaultlocation && $("#" + mnstJs.searchParams.where.fieldID).val(monsNppDefaultlocation), monsNppDefaultradius && (mnstJs.searchParams.rad.value = monsNppDefaultradius)
    }, doAttachSubmitEvent: function () {
      mnstJs.button.name && $(mnstJs.button.name).on("click", function () {
        return mnstJs.doSetProperties(), mnstJs.doCalculateSearch(), mnstJs.doOnClickTracking(), !1
      })
    }, init: function () {
      mnstJs.doParseQsInput(), mnstJs.doAttachSubmitEvent()
    }
  };
  mnstJs.searchParams.q.fieldID = "MNSwdgSkillsKeywords", mnstJs.searchParams.where.fieldID = "MNSwdgLocation", mnstJs.form.searchEndPoint = "http://jobsearch.local-jobs.monster.com/jobs?wt.mc_n=hjnpsearch&ch=" + monsNppCh, mnstJs.button.name = "#MNSwdgFormAction", mnstJs.form.name = "#MNSwdgQuickJobSearch", mnstJs.init(), $(".monstLink").attr("href", function (e, t) {
    return t + "&ch=" + monsNppCh
  });
});