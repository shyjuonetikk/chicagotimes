(function() {
  var ARTICLE_URL = window.location.href;
  var CONTENT_ID = "everything";
  document.write('<scr'+'ipt '+
    'src="//survey.g.doubleclick.net/survey?site=_ahs3cbydcxzogxxll3gdjbxese'+
    '&amp;url='+encodeURIComponent(ARTICLE_URL)+
    (CONTENT_ID ? '&amp;cid='+encodeURIComponent(CONTENT_ID) : "")+
    '&amp;random='+(new Date).getTime()+
    '" type="text/javascript">'+'\x3C/scr'+'ipt>'
  );
})()

document.addEventListener("DOMContentLoaded", function(){
  window.GoogleSurvey && GoogleSurvey.inject()
})