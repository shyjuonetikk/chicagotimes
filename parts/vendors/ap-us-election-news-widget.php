<script type="text/javascript">
(function(d, s) {
  var wid = 'web_widgets_inline_async_e92dd71b35bd9ae5d69cd9895b463e95',
  js, load = function(url, id) {
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.src = url; js.id = id;
    d.getElementsByTagName('head')[0].appendChild(js);
  };
  var old = function(){};
  if (typeof window.onload == 'function') {
    old = window.onload;
  }
  window.onload = function(e) { old(e); load('http://elections.ap.org/suntimes/ap_widgets/widget/data/new/latest_news', 'script_'+ wid); };
}(document, 'script'));
</script>
<div class="ap_widget ap_widget-latest_news table-widget-wrapper" type-class="list-news" data-type="list-widget" id="web_widgets_inline_async_e92dd71b35bd9ae5d69cd9895b463e95"></div><link type="text/css" rel="stylesheet" href="http://elections.ap.org/profiles/ap/themes/ap_elections_theme/widgets/ap_widgets.css" media="all"><script type="text/javascript" src="http://elections.ap.org/profiles/ap/modules/custom/core/ap_widgets/misc/v2.js"></script><script type="text/javascript">var element = document.getElementsByClassName("table-widget-wrapper");var length = element.length;var position = length - 1;var id = element[position].id;var div = document.getElementById(id);var off = document.getElementById(id).offsetWidth;if (off < 620) {div.setAttribute("class", "table-widget-wrapper verticle gallery");}</script>