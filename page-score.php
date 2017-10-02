<?php /** Template name: Chicago-score */
get_header();
$cur_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$minDate = date("Y-m-d\TH:i:s\Z", strtotime($cur_date . ' 00:00:01'));
$maxDate = date("Y-m-d\TH:i:s\Z", strtotime($cur_date . ' 11:59:59'));
$url = "http://syndication.ap.org/AP.Distro.Feed/GetFeed.aspx?idList=30957&idListType=products&maxitems=25&fullContent=true";
$url .= "&minDateTime={$minDate}&maxDateTime={$maxDate}";
$xml = getData($url);
$date_range = [];
for($i = -1; $i <= 1; $i++) {
  $date_range[] = date("Y-m-d",strtotime("$i day", date(strtotime($cur_date))));
}
?>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/prototype.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/calendarview.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/s_team_suntimes.css">
<script>
  function setupCalendars()
  {
    // Embedded Calendar
    Calendar.setup(
    {
      dateField: 'ap_date_field',
      parentElement: 'embeddedCalendar'
    });
  }
  Event.observe(window, 'load', function()
  {
    setupCalendars()
  });

  function loadData(date) {
    // var minDate = new Date(date + ' 00:00:01');
    // var maxDate = new Date(date + ' 11:59:59');
    // var url = new URL("http://syndication.ap.org/AP.Distro.Feed/GetFeed.aspx?idList=30957&idListType=products&fullContent=true");
    // var search = new URLSearchParams(url.search);
    // search.set('maxitems', 25);
    // search.set('minDateTime', minDate.toUTCString());
    // search.set('maxDateTime', maxDate.toUTCString());
    // var newURL = url.href.split('?')[0] + '?' + search.toString();
    // var x = new XMLHttpRequest();
    // x.open("POST", newURL, true);
    // x.setRequestHeader("Authorization", "Basic " + btoa("ILCHS_webfeeds:ap116"));
    // x.onreadystatechange = function () {
    //   if (x.readyState == 4 && x.status == 200)
    //   {
    //     var doc = x.responseXML;
    //     console.log('doc', doc);
    //   }
    // };
    // x.send(null);
    // console.log('newURL', newURL);

    var url = new URL(window.location.href);
    var search = new URLSearchParams(url.search);
    search.set('date', date);
    var newURL = url.href.split('?')[0] + '?' + search.toString();
    window.location.href = newURL;
  }
</script>
<div id="s_team-midsection" class="s_team-mid">
  <form method="post" action="" id="">
    <input type="hidden" name="date" id="ap_date_field" value="<?=date('Y-m-d')?>" onchange="loadData(this.value)"/>
    <div id="s_team-rail-content-sm">
      <div class="s_team-title-main-id">
        <div class="s_team-title-main-id-text">Major League Baseball</div>
      </div>
      <div class="s_team-calendar-holder">
        <div style="float: left;">
          <div id="embeddedExample" style="">
            <div id="embeddedCalendar" style="margin-left: auto; margin-right: auto">
            </div>
          </div>
        </div>
      </div>
      <div class="s_team-title-page-type">SCOREBOARD</div>
      <div class="s_team-scores-note" style="float:left;">
        <div id="scores-note">
          <div>Scores Refresh: <?php
            $get = $_GET;
            if(isset($get['refresh']) && $get['refresh']==true) {
              unset($get['refresh']);
              echo "<a href=\"?".http_build_query($get)."\">Off</a> | <strong>On</strong>";
            } else {
              $get['refresh'] = true;
              echo "<strong>Off</strong> | <a href=\"?".http_build_query($get)."\">On</a>";
            }
          ?>
          </div>
        </div>
        <span>
          <div id="DayNav">
            <? foreach ($date_range as $key=>$date): ?>
            <? $display_date = ($date === date("Y-m-d")) ? "Today" : date("D, M d", strtotime($date)); ?>
            <? $_GET['date']= $date ?>
            <a href="?<?=http_build_query($_GET)?>"><?=$display_date?></a>
            <?=((count($date_range) - 1) > $key) ? "-" : "" ?>
            <? endforeach; ?>
            <? $_GET['date'] = date('Y-m-d') ?>
            <?=!in_array(date("Y-m-d"), $date_range) ? "- <a href=\"?".http_build_query($_GET)."\"/>Today</a>" : ""; ?>
          </div>
        </span>
        <a href="#">See full schedule</a>
      </div>
      <div id="s_teamRoundupLinks" class="s_team-roundup-links">
        Read Today's Roundups:
        <a id="previewRoundupsLink" href="#">Previews</a>
        <span id="roundupLinkSeparator"> | </span>
        <a id="recapRoundupsLink" href="#">Recaps</a>
      </div>
      <div class="s_team-clear"></div>
      <? foreach ($xml as $node): ?>
      <?php
        $row = simplexml_load_string($node->asXML());
        $block = $row->xpath("//body/body.content/block");
      ?>
      <? foreach($block as $item): ?>
        <? foreach($item->children() as $tag => $child): ?>
          <? if($tag == "h12"): ?>
          <h6><?print_r($child)?></h6>
          <? endif;?>
        <? endforeach; ?>
      <? endforeach; ?>
      <div id="Scoreboard_5">
        <div id="Scoreboard_5_National_League">
          <div class="s_team-divScoreColumn_1-2">

          </div>
        </div>
        <div id="Scoreboard_5_American_League">
          <div class="s_team-divScoreColumn_2-2">

          </div>
        </div>
      </div>
      <div class="s_team-clear"></div>
    <?php endforeach; ?>
      <p>
        <br>
      </p>
      <div class="s_team-clear"></div>
      <div class="s_team-notice">Portions of this website may operate under United States Patent Number 5,526,479</div>
    </div>
    <div id="s_team-rail-third-sm">
      <div class="s_team-ad-insidewrapper"></div>
    </div>
  </form>
</div>
<?php get_footer(); ?>
