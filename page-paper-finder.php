<?php
  /* 
   * Template Name: Paper Finder
   */
?>
<?php get_header(); ?>
  <section id="subscribe">
  <p>Choose your publication:</p>
  <div class="cst-checkbox">
    <input type="checkbox" checked="checked" name="publication" id="pub1" value="5300">
    <label>
      <img style="display:block; margin-left: 50px; margin-top: -25px;width:120px;" src="http://wssp.suntimes.com/wp-content/themes/market-cst/map/cst-masthead.jpg" alt="Chicago Sun-Times">
      <img src="http://wssp.suntimes.com/wp-content/themes/market-cst/map/cst-marker.jpg" style="margin-top:-25px;margin-left:15px;float:left;" />
    </label>
  </div>
  <div class="reader-checkbox">
    <input type="checkbox" name="publication" id="pub2" value="5400">
    <label>
      <img style="display:block; margin-left: 50px; margin-top: -30px;" src="http://live-market-cst.pantheon.io/wp-content/uploads/2014/12/reader.png" alt="Reader">
      <img src="http://wssp.suntimes.com/wp-content/themes/market-cst/map/reader-marker.jpg" style="margin-top:-30px;margin-left:15px;float:left;" />
    </label>
  </div>

  <div style="clear:both;"></div>
  <small><em>Disclaimer: Not all locations carry the paper seven days a week.</em></small>
  <input id="pac-input" class="controls" type="text" placeholder="Search Box" />
  <div id="map"></div>  
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkPQ9BLBwW_xCk4Wrh55UjZvyVqPc_5FU&libraries=places&callback=initAutocomplete" async defer></script>
  </section>
<?php get_footer();
