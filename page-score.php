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

  jQuery(function($){
    var url = new URL(window.location.href);
    var search = url.searchParams;
    if(search.get('refresh')) {
      setTimeout(function(){
        window.location.href = url.href;
      }, (1 * 60000));
    }
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
        <h6><?=$item->xpath('hl2')[0]->__toString()?></h6>
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
<!--
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
          <div>Scores Refresh:
          </div>
        </div>
        <span>
          <div id="DayNav">

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

      <input type="hidden" name="ScoreboardTypeId" id="ScoreboardTypeId" value="2">

      <div class="s_team-clear"></div>

      <div id="Scoreboard_5">
        <div id="Scoreboard_5_National_League">
          <div class="s_team-divScoreColumn_1-2">
            <div class="s_team-title-page-section">National League</div>
            <div id="_ctl6_GameHolder">
              <div id="Game_5_552021" class="s_team-so">
                <div class="s_team-so-title" id="Title_5_552021">Cincinnati at St. Louis</div>
                <div class="s_team-spacerquarter"></div>
                <table class="s_team-data-wide" cellspacing="1" bgcolor="#999999">
                  <tbody>
                    <tr>
                      <td class="s_team-datahead-sub" id="Status_5_552021" width="17%">Final</td>
                      <td class="s_team-datahead-sub" width="5%">1</td>
                      <td class="s_team-datahead-sub" width="5%">2</td>
                      <td class="s_team-datahead-sub" width="5%">3</td>
                      <td class="s_team-datahead-sub" width="5%">4</td>
                      <td class="s_team-datahead-sub" width="5%">5</td>
                      <td class="s_team-datahead-sub" width="5%">6</td>
                      <td class="s_team-datahead-sub" width="5%">7</td>
                      <td class="s_team-datahead-sub" width="5%">8</td>
                      <td class="s_team-datahead-sub" width="5%">9</td>
                      <td class="s_team-datahead-sub" width="5%">R</td>
                      <td class="s_team-datahead-sub" width="4%">H</td>
                      <td class="s_team-datahead-sub" width="5%">E</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">CIN                 </a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell" id="VisitScore_5_552021">2</td>
                      <td class="s_team-datacell">6</td>
                      <td class="s_team-datacell">1</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">STL                 </a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">2</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">2</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">-</td>
                      <td class="s_team-datacell" id="HomeScore_5_552021">5</td>
                      <td class="s_team-datacell">6</td>
                      <td class="s_team-datacell">1</td>
                    </tr>
                  </tbody>
                </table>
                <div class="s_team-spacerquarter"></div>
                <div class="onoff"><a target="_parent" href="#">Boxscore</a>&nbsp;|&nbsp;
                  <a target="_parent" href="#">Recap</a>&nbsp;</div>
                <div class="s_team-spacerquarter"></div>
              </div>
            </div>
            <div id="_ctl6_GameHolder">
              <div id="Game_5_552016" class="s_team-so">
                <div class="s_team-so-title" id="Title_5_552016">Colorado at Arizona</div>
                <div class="s_team-spacerquarter"></div>
                <table class="s_team-data-wide" cellspacing="1" bgcolor="#999999">
                  <tbody>
                    <tr>
                      <td class="s_team-datahead-sub" id="Status_5_552016" width="17%">Final</td>
                      <td class="s_team-datahead-sub" width="5%">1</td>
                      <td class="s_team-datahead-sub" width="5%">2</td>
                      <td class="s_team-datahead-sub" width="5%">3</td>
                      <td class="s_team-datahead-sub" width="5%">4</td>
                      <td class="s_team-datahead-sub" width="5%">5</td>
                      <td class="s_team-datahead-sub" width="5%">6</td>
                      <td class="s_team-datahead-sub" width="5%">7</td>
                      <td class="s_team-datahead-sub" width="5%">8</td>
                      <td class="s_team-datahead-sub" width="5%">9</td>
                      <td class="s_team-datahead-sub" width="5%">R</td>
                      <td class="s_team-datahead-sub" width="4%">H</td>
                      <td class="s_team-datahead-sub" width="5%">E</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">COL                 </a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell" id="VisitScore_5_552016">0</td>
                      <td class="s_team-datacell">5</td>
                      <td class="s_team-datacell">0</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">ARI                 </a>
                      </td>
                      <td class="s_team-datacell">5</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">-</td>
                      <td class="s_team-datacell" id="HomeScore_5_552016">7</td>
                      <td class="s_team-datacell">9</td>
                      <td class="s_team-datacell">0</td>
                    </tr>
                  </tbody>
                </table>
                <div class="s_team-spacerquarter"></div>
                <div class="onoff"><a target="_parent" href="#">Boxscore</a>|
                  <a target="_parent" href="#">Recap</a>&nbsp;</div>
                <div class="s_team-spacerquarter"></div>
              </div>
            </div>
            <div id="_ctl6_GameHolder">
              <div id="Game_5_552014" class="s_team-so">
                <div class="s_team-so-title" id="Title_5_552014">Atlanta at Washington</div>
                <div class="s_team-spacerquarter"></div>
                <table class="s_team-data-wide" cellspacing="1" bgcolor="#999999">
                  <tbody>
                    <tr>
                      <td class="s_team-datahead-sub" id="Status_5_552014" width="17%">Final</td>
                      <td class="s_team-datahead-sub" width="5%">1</td>
                      <td class="s_team-datahead-sub" width="5%">2</td>
                      <td class="s_team-datahead-sub" width="5%">3</td>
                      <td class="s_team-datahead-sub" width="5%">4</td>
                      <td class="s_team-datahead-sub" width="5%">5</td>
                      <td class="s_team-datahead-sub" width="5%">6</td>
                      <td class="s_team-datahead-sub" width="5%">7</td>
                      <td class="s_team-datahead-sub" width="5%">8</td>
                      <td class="s_team-datahead-sub" width="5%">9</td>
                      <td class="s_team-datahead-sub" width="5%">R</td>
                      <td class="s_team-datahead-sub" width="4%">H</td>
                      <td class="s_team-datahead-sub" width="5%">E</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">ATL                 </a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">2</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell" id="VisitScore_5_552014">2</td>
                      <td class="s_team-datacell">6</td>
                      <td class="s_team-datacell">1</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">WAS                 </a>
                      </td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">2</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">2</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">-</td>
                      <td class="s_team-datacell" id="HomeScore_5_552014">5</td>
                      <td class="s_team-datacell">8</td>
                      <td class="s_team-datacell">0</td>
                    </tr>
                  </tbody>
                </table>
                <div class="s_team-spacerquarter"></div>
                <div class="onoff"><a target="_parent" href="#">Boxscore</a>|
                  <a target="_parent" href="#">Recap</a>
                </div>
                <div class="s_team-spacerquarter"></div>
              </div>
            </div>
            <div id="_ctl6_GameHolder">
              <div id="Game_5_552022" class="s_team-so">
                <div class="s_team-so-title" id="Title_5_552022">Miami at Philadelphia</div>
                <div class="s_team-spacerquarter"></div>
                <table class="s_team-data-wide" cellspacing="1" bgcolor="#999999">
                  <tbody>
                    <tr>
                      <td class="s_team-datahead-sub" id="Status_5_552022" width="17%">Final</td>
                      <td class="s_team-datahead-sub" width="5%">1</td>
                      <td class="s_team-datahead-sub" width="5%">2</td>
                      <td class="s_team-datahead-sub" width="5%">3</td>
                      <td class="s_team-datahead-sub" width="5%">4</td>
                      <td class="s_team-datahead-sub" width="5%">5</td>
                      <td class="s_team-datahead-sub" width="5%">6</td>
                      <td class="s_team-datahead-sub" width="5%">7</td>
                      <td class="s_team-datahead-sub" width="5%">8</td>
                      <td class="s_team-datahead-sub" width="5%">9</td>
                      <td class="s_team-datahead-sub" width="5%">R</td>
                      <td class="s_team-datahead-sub" width="4%">H</td>
                      <td class="s_team-datahead-sub" width="5%">E</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">MIA                 </a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell" id="VisitScore_5_552022">0</td>
                      <td class="s_team-datacell">8</td>
                      <td class="s_team-datacell">0</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">PHI                 </a>
                      </td>
                      <td class="s_team-datacell">2</td>
                      <td class="s_team-datacell">7</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">-</td>
                      <td class="s_team-datacell" id="HomeScore_5_552022">10</td>
                      <td class="s_team-datacell">14</td>
                      <td class="s_team-datacell">0</td>
                    </tr>
                  </tbody>
                </table>
                <div class="s_team-spacerquarter"></div>
                <div class="onoff"><a target="_parent" href="#">Boxscore</a>|
                  <a target="_parent" href="#">Recap</a>
                </div>
                <div class="s_team-spacerquarter"></div>
              </div>
            </div>
            <div id="_ctl6_GameHolder">
              <div id="Game_5_552308" class="s_team-so">
                <div class="s_team-so-title" id="Title_5_552308">NY Mets at Chi. Cubs</div>
                <div class="s_team-spacerquarter"></div>
                <table class="s_team-data-wide" cellspacing="1" bgcolor="#999999">
                  <tbody>
                    <tr>
                      <td class="s_team-datahead-sub" id="Status_5_552308" width="17%">Final</td>
                      <td class="s_team-datahead-sub" width="5%">1</td>
                      <td class="s_team-datahead-sub" width="5%">2</td>
                      <td class="s_team-datahead-sub" width="5%">3</td>
                      <td class="s_team-datahead-sub" width="5%">4</td>
                      <td class="s_team-datahead-sub" width="5%">5</td>
                      <td class="s_team-datahead-sub" width="5%">6</td>
                      <td class="s_team-datahead-sub" width="5%">7</td>
                      <td class="s_team-datahead-sub" width="5%">8</td>
                      <td class="s_team-datahead-sub" width="5%">9</td>
                      <td class="s_team-datahead-sub" width="5%">R</td>
                      <td class="s_team-datahead-sub" width="4%">H</td>
                      <td class="s_team-datahead-sub" width="5%">E</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">NYM                 </a>
                      </td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">2</td>
                      <td class="s_team-datacell">2</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell" id="VisitScore_5_552308">6</td>
                      <td class="s_team-datacell">11</td>
                      <td class="s_team-datacell">3</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">CHC                 </a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">3</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">5</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">5</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">-</td>
                      <td class="s_team-datacell" id="HomeScore_5_552308">14</td>
                      <td class="s_team-datacell">14</td>
                      <td class="s_team-datacell">1</td>
                    </tr>
                  </tbody>
                </table>
                <div class="s_team-spacerquarter"></div>
                <div class="onoff"><a target="_parent" href="#">Boxscore</a>|
                  <a target="_parent" href="#">Recap</a>&nbsp;</div>
                <div class="s_team-spacerquarter"></div>
              </div>
            </div>
          </div>
          <input name="_ctl6:_ctl1" type="hidden" id="EventID" value="552308">
        </div>
        <div id="Scoreboard_5_American_League">
          <div class="s_team-divScoreColumn_2-2">
            <div class="s_team-title-page-section">American League</div>
            <div id="_ctl7_GameHolder">
              <div id="Game_5_552017" class="s_team-so">
                <div class="s_team-so-title" id="Title_5_552017">Houston at LA Angels</div>
                <div class="s_team-spacerquarter"></div>
                <table class="s_team-data-wide" cellspacing="1" bgcolor="#999999">
                  <tbody>
                    <tr>
                      <td class="s_team-datahead-sub" id="Status_5_552017" width="17%">Top 8</td>
                      <td class="s_team-datahead-sub" width="5%">1</td>
                      <td class="s_team-datahead-sub" width="5%">2</td>
                      <td class="s_team-datahead-sub" width="5%">3</td>
                      <td class="s_team-datahead-sub" width="5%">4</td>
                      <td class="s_team-datahead-sub" width="5%">5</td>
                      <td class="s_team-datahead-sub" width="5%">6</td>
                      <td class="s_team-datahead-sub" width="5%">7</td>
                      <td class="s_team-datahead-sub" width="5%">8</td>
                      <td class="s_team-datahead-sub" width="5%">9</td>
                      <td class="s_team-datahead-sub" width="5%">R</td>
                      <td class="s_team-datahead-sub" width="4%">H</td>
                      <td class="s_team-datahead-sub" width="5%">E</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">HOU                 </a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">2</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">-</td>
                      <td class="s_team-datacell" id="VisitScore_5_552017">2</td>
                      <td class="s_team-datacell">7</td>
                      <td class="s_team-datacell">0</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">LAA                 </a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">-</td>
                      <td class="s_team-datacell">-</td>
                      <td class="s_team-datacell" id="HomeScore_5_552017">1</td>
                      <td class="s_team-datacell">3</td>
                      <td class="s_team-datacell">0</td>
                    </tr>
                  </tbody>
                </table>
                <div class="s_team-spacerquarter"></div>
                <div class="bases-hold">
                  <table class="mlb_bso">
                    <tbody>
                      <tr width="100%">
                        <td width="170px" class="mlb_bso"><strong>Pitching: </strong><a target="_parent" href="#">Noe Ramirez</a>
                          <div class="s_team-spacerquarter"></div><strong>At Bat: </strong><a target="_parent" href="#">Carlos Correa</a>
                        </td>
                        <td></td>
                        <td class="mlb_bso" width="50px">B <img src="http://images.sports_teamrectinc.com/scores/baseball/2b.gif"
                          alt="2" balls="">
                          <br>S <img src="http://images.sports_teamrectinc.com/scores/baseball/2s.gif"
                          alt="2" strikes="">
                          <br>O <img src="http://images.sports_teamrectinc.com/scores/baseball/0s.gif"
                          alt="0" outs="">
                        </td>
                        <td width="30px"><img src="http://images.sports_teamrectinc.com/scores/baseball/3.gif">
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="onoff"><a target="_parent" href="#">Matchup</a>&nbsp;|&nbsp;
                  <a target="_parent" href="#">Preview</a>&nbsp;|&nbsp;
                  <a target="_parent" href="#">Boxscore</a>&nbsp;</div>
                <div class="s_team-spacerquarter"></div>
              </div>
            </div>
            <div id="_ctl7_GameHolder">
              <div id="Game_5_552307" class="s_team-so">
                <div class="s_team-so-title" id="Title_5_552307">Chi. White Sox at Detroit</div>
                <div class="s_team-spacerquarter"></div>
                <table class="s_team-data-wide" cellspacing="1" bgcolor="#999999">
                  <tbody>
                    <tr>
                      <td class="s_team-datahead-sub" id="Status_5_552307" width="17%">Final</td>
                      <td class="s_team-datahead-sub" width="5%">1</td>
                      <td class="s_team-datahead-sub" width="5%">2</td>
                      <td class="s_team-datahead-sub" width="5%">3</td>
                      <td class="s_team-datahead-sub" width="5%">4</td>
                      <td class="s_team-datahead-sub" width="5%">5</td>
                      <td class="s_team-datahead-sub" width="5%">6</td>
                      <td class="s_team-datahead-sub" width="5%">7</td>
                      <td class="s_team-datahead-sub" width="5%">8</td>
                      <td class="s_team-datahead-sub" width="5%">9</td>
                      <td class="s_team-datahead-sub" width="5%">R</td>
                      <td class="s_team-datahead-sub" width="4%">H</td>
                      <td class="s_team-datahead-sub" width="5%">E</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">CHW                 </a>
                      </td>
                      <td class="s_team-datacell">2</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">4</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">4</td>
                      <td class="s_team-datacell">3</td>
                      <td class="s_team-datacell">3</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell" id="VisitScore_5_552307">17</td>
                      <td class="s_team-datacell">25</td>
                      <td class="s_team-datacell">1</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">DET                 </a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">2</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">2</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">2</td>
                      <td class="s_team-datacell" id="HomeScore_5_552307">7</td>
                      <td class="s_team-datacell">12</td>
                      <td class="s_team-datacell">0</td>
                    </tr>
                  </tbody>
                </table>
                <div class="s_team-spacerquarter"></div>
                <div class="onoff"><a target="_parent" href="#">Boxscore</a>&nbsp;|&nbsp;
                  <a target="_parent" href="#">Recap</a>&nbsp;</div>
                <div class="s_team-spacerquarter"></div>
              </div>
            </div>
            <div id="_ctl7_GameHolder">
              <div id="Game_5_552019" class="s_team-so">
                <div class="s_team-so-title" id="Title_5_552019">Oakland at Boston</div>
                <div class="s_team-spacerquarter"></div>
                <table class="s_team-data-wide" cellspacing="1" bgcolor="#999999">
                  <tbody>
                    <tr>
                      <td class="s_team-datahead-sub" id="Status_5_552019" width="17%">Final</td>
                      <td class="s_team-datahead-sub" width="5%">1</td>
                      <td class="s_team-datahead-sub" width="5%">2</td>
                      <td class="s_team-datahead-sub" width="5%">3</td>
                      <td class="s_team-datahead-sub" width="5%">4</td>
                      <td class="s_team-datahead-sub" width="5%">5</td>
                      <td class="s_team-datahead-sub" width="5%">6</td>
                      <td class="s_team-datahead-sub" width="5%">7</td>
                      <td class="s_team-datahead-sub" width="5%">8</td>
                      <td class="s_team-datahead-sub" width="5%">9</td>
                      <td class="s_team-datahead-sub" width="5%">R</td>
                      <td class="s_team-datahead-sub" width="4%">H</td>
                      <td class="s_team-datahead-sub" width="5%">E</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">OAK                 </a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell" id="VisitScore_5_552019">2</td>
                      <td class="s_team-datacell">8</td>
                      <td class="s_team-datacell">1</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">BOS                 </a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">2</td>
                      <td class="s_team-datacell">3</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">-</td>
                      <td class="s_team-datacell" id="HomeScore_5_552019">6</td>
                      <td class="s_team-datacell">8</td>
                      <td class="s_team-datacell">1</td>
                    </tr>
                  </tbody>
                </table>
                <div class="s_team-spacerquarter"></div>
                <div class="onoff"><a target="_parent" href="#">Boxscore</a>&nbsp;|&nbsp;
                  <a target="_parent" href="#">Recap</a>&nbsp;</div>
                <div class="s_team-spacerquarter"></div>
              </div>
            </div>
            <div id="_ctl7_GameHolder">
              <div id="Game_5_552015" class="s_team-so">
                <div class="s_team-so-title" id="Title_5_552015">Baltimore at NY Yankees</div>
                <div class="s_team-spacerquarter"></div>
                <table class="s_team-data-wide" cellspacing="1" bgcolor="#999999">
                  <tbody>
                    <tr>
                      <td class="s_team-datahead-sub" id="Status_5_552015" width="17%">Final</td>
                      <td class="s_team-datahead-sub" width="5%">1</td>
                      <td class="s_team-datahead-sub" width="5%">2</td>
                      <td class="s_team-datahead-sub" width="5%">3</td>
                      <td class="s_team-datahead-sub" width="5%">4</td>
                      <td class="s_team-datahead-sub" width="5%">5</td>
                      <td class="s_team-datahead-sub" width="5%">6</td>
                      <td class="s_team-datahead-sub" width="5%">7</td>
                      <td class="s_team-datahead-sub" width="5%">8</td>
                      <td class="s_team-datahead-sub" width="5%">9</td>
                      <td class="s_team-datahead-sub" width="5%">R</td>
                      <td class="s_team-datahead-sub" width="4%">H</td>
                      <td class="s_team-datahead-sub" width="5%">E</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">BAL</a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">2</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell" id="VisitScore_5_552015">5</td>
                      <td class="s_team-datacell">12</td>
                      <td class="s_team-datacell">2</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">NYY</a>
                      </td>
                      <td class="s_team-datacell">6</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">3</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">4</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">-</td>
                      <td class="s_team-datacell" id="HomeScore_5_552015">13</td>
                      <td class="s_team-datacell">14</td>
                      <td class="s_team-datacell">1</td>
                    </tr>
                  </tbody>
                </table>
                <div class="s_team-spacerquarter"></div>
                <div class="onoff"><a target="_parent" href="#">Boxscore</a>&nbsp;|&nbsp;
                  <a target="_parent" href="#">Recap</a>&nbsp;</div>
                <div class="s_team-spacerquarter"></div>
              </div>
            </div>
            <div id="_ctl7_GameHolder">
              <div id="Game_5_552018" class="s_team-so">
                <div class="s_team-so-title" id="Title_5_552018">Kansas City at Cleveland</div>
                <div class="s_team-spacerquarter"></div>
                <table class="s_team-data-wide" cellspacing="1" bgcolor="#999999">
                  <tbody>
                    <tr>
                      <td class="s_team-datahead-sub" id="Status_5_552018" width="17%">Final(10)</td>
                      <td class="s_team-datahead-sub" width="5%">1</td>
                      <td class="s_team-datahead-sub" width="5%">2</td>
                      <td class="s_team-datahead-sub" width="5%">3</td>
                      <td class="s_team-datahead-sub" width="5%">4</td>
                      <td class="s_team-datahead-sub" width="5%">5</td>
                      <td class="s_team-datahead-sub" width="5%">6</td>
                      <td class="s_team-datahead-sub" width="5%">7</td>
                      <td class="s_team-datahead-sub" width="5%">8</td>
                      <td class="s_team-datahead-sub" width="5%">9</td>
                      <td class="s_team-datahead-sub" width="5%">X</td>
                      <td class="s_team-datahead-sub" width="5%">R</td>
                      <td class="s_team-datahead-sub" width="4%">H</td>
                      <td class="s_team-datahead-sub" width="5%">E</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">KC                  </a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell" id="VisitScore_5_552018">2</td>
                      <td class="s_team-datacell">9</td>
                      <td class="s_team-datacell">0</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">CLE                 </a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell" id="HomeScore_5_552018">3</td>
                      <td class="s_team-datacell">12</td>
                      <td class="s_team-datacell">0</td>
                    </tr>
                  </tbody>
                </table>
                <div class="s_team-spacerquarter"></div>
                <div class="onoff"><a target="_parent" href="#">Boxscore</a>|
                  <a target="_parent" href="#">Recap</a>&nbsp;</div>
                <div class="s_team-spacerquarter"></div>
              </div>
            </div>
            <div id="_ctl7_GameHolder">
              <div id="Game_5_552020" class="s_team-so">
                <div class="s_team-so-title" id="Title_5_552020">Seattle at Texas</div>
                <div class="s_team-spacerquarter"></div>
                <table class="s_team-data-wide" cellspacing="1" bgcolor="#999999">
                  <tbody>
                    <tr>
                      <td class="s_team-datahead-sub" id="Status_5_552020" width="17%">Final</td>
                      <td class="s_team-datahead-sub" width="5%">1</td>
                      <td class="s_team-datahead-sub" width="5%">2</td>
                      <td class="s_team-datahead-sub" width="5%">3</td>
                      <td class="s_team-datahead-sub" width="5%">4</td>
                      <td class="s_team-datahead-sub" width="5%">5</td>
                      <td class="s_team-datahead-sub" width="5%">6</td>
                      <td class="s_team-datahead-sub" width="5%">7</td>
                      <td class="s_team-datahead-sub" width="5%">8</td>
                      <td class="s_team-datahead-sub" width="5%">9</td>
                      <td class="s_team-datahead-sub" width="5%">R</td>
                      <td class="s_team-datahead-sub" width="4%">H</td>
                      <td class="s_team-datahead-sub" width="5%">E</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">SEA                 </a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">2</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">3</td>
                      <td class="s_team-datacell">4</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell" id="VisitScore_5_552020">10</td>
                      <td class="s_team-datacell">11</td>
                      <td class="s_team-datacell">0</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">TEX                 </a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">3</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell" id="HomeScore_5_552020">4</td>
                      <td class="s_team-datacell">6</td>
                      <td class="s_team-datacell">0</td>
                    </tr>
                  </tbody>
                </table>
                <div class="s_team-spacerquarter"></div>
                <div class="onoff"><a target="_parent" href="#">Boxscore</a>|
                  <a target="_parent" href="#">Recap</a>&nbsp;</div>
                <div class="s_team-spacerquarter"></div>
              </div>
            </div>
            <div id="_ctl7_GameHolder">
              <div id="Game_5_552023" class="s_team-so">
                <div class="s_team-so-title" id="Title_5_552023">Toronto at Minnesota</div>
                <div class="s_team-spacerquarter"></div>
                <table class="s_team-data-wide" cellspacing="1" bgcolor="#999999">
                  <tbody>
                    <tr>
                      <td class="s_team-datahead-sub" id="Status_5_552023" width="17%">Final(10)</td>
                      <td class="s_team-datahead-sub" width="5%">1</td>
                      <td class="s_team-datahead-sub" width="5%">2</td>
                      <td class="s_team-datahead-sub" width="5%">3</td>
                      <td class="s_team-datahead-sub" width="5%">4</td>
                      <td class="s_team-datahead-sub" width="5%">5</td>
                      <td class="s_team-datahead-sub" width="5%">6</td>
                      <td class="s_team-datahead-sub" width="5%">7</td>
                      <td class="s_team-datahead-sub" width="5%">8</td>
                      <td class="s_team-datahead-sub" width="5%">9</td>
                      <td class="s_team-datahead-sub" width="5%">X</td>
                      <td class="s_team-datahead-sub" width="5%">R</td>
                      <td class="s_team-datahead-sub" width="4%">H</td>
                      <td class="s_team-datahead-sub" width="5%">E</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">TOR                 </a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell" id="VisitScore_5_552023">2</td>
                      <td class="s_team-datacell">8</td>
                      <td class="s_team-datacell">1</td>
                    </tr>
                    <tr>
                      <td class="s_team-datacell"><a target="_parent" href="#">MIN                 </a>
                      </td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">2</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">0</td>
                      <td class="s_team-datacell">1</td>
                      <td class="s_team-datacell" id="HomeScore_5_552023">3</td>
                      <td class="s_team-datacell">7</td>
                      <td class="s_team-datacell">0</td>
                    </tr>
                  </tbody>
                </table>
                <div class="s_team-spacerquarter"></div>
                <div class="onoff"><a target="_parent" href="#">Boxscore</a>&nbsp;|&nbsp;
                  <a target="_parent" href="#">Recap</a>&nbsp;</div>
                <div class="s_team-spacerquarter"></div>
              </div>
            </div>
          </div>
          <input name="_ctl7:_ctl1" type="hidden" id="EventID" value="552023">
        </div>
      </div>
      <div class="s_team-clear"></div>
      <input name="_ctl8" type="hidden" id="gamedatetime" value="09-14-2017">
      <input name="_ctl9" type="hidden" id="ScoreboardColumns" value="1">
      <input name="_ctl10" type="hidden" id="ControlType" value="HSTGameMlbControl">
      <input name="_ctl11" type="hidden" id="LeagueID" value="5">
      <input name="_ctl12" type="hidden" id="conferenceSelect" value="mlb">

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

</div> -->
