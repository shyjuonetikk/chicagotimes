<?php
  /* 
   * Template Name: Paper Finder
   */
?>
<?php get_header(); ?>
    <section id="subscribe">

<div>
  <p>Choose your publications:</p>
  <div class="cst-checkbox">
    <input type="checkbox" checked="checked" name="publication"
    id="pub1" value="5300">
    <label>
      <img style="display:block; margin-left: 50px; margin-top: -25px;width:120px;" src="http://wssp.suntimes.com/wp-content/themes/market-cst/map/cst-masthead.jpg" alt="Chicago Sun-Times">
      <img src="http://wssp.suntimes.com/wp-content/themes/market-cst/map/cst-marker.jpg" style="margin-top:-25px;margin-left:15px;float:left;" />
    </label>
  </div>
  <div class="reader-checkbox">
    <input type="checkbox" name="publication"
    id="pub2" value="5400">
    <label>
      <img style="display:block; margin-left: 50px; margin-top: -30px;" src="http://live-market-cst.pantheon.io/wp-content/uploads/2014/12/reader.png" alt="Reader">
      <img src="http://wssp.suntimes.com/wp-content/themes/market-cst/map/reader-marker.jpg" style="margin-top:-30px;margin-left:15px;float:left;" />
    </label>
  </div>
</div>
<div style="clear:both;"></div>
<small><em>Disclaimer: Not all locations carry the paper seven days a week.</em></small>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box" />
    <div id="map"></div>
    <script>
      // This example adds a search box to a map, using the Google Place Autocomplete
      // feature. People can enter geographical searches. The search box will return a
      // pick list containing a mix of places and predicted search terms.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var tableId = '1X9tEIKv2kykHg8VloTBFFfytSaiPnxOzVxTVrOg';
      var defaultZoom = 10;
      
      function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 41.850033, lng: -88.1851912},
          zoom: 10,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var geocoder  = new google.maps.Geocoder();

        var layer = new google.maps.FusionTablesLayer({
          styles: [{
            polygonOptions: {
              fillColor: '#00FF00',
              fillOpacity: 0.3
            }
          }, {
            where: 'PubCode = 5400',
            polygonOptions: {
              fillColor: '#0000FF'
            }
          }, {
            where: 'PubCode = 5300',
            polygonOptions: {
              fillOpacity: 1.0,
              fillColor: '#FFFFFF'
            }
          }]
        });
        filterMap(layer, tableId, map);

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.

        google.maps.event.addDomListener(document.getElementById('pub1'),
          'click', function() {
            filterMap(layer, tableId, map);
          });

        google.maps.event.addDomListener(document.getElementById('pub2'),
          'click', function() {
            filterMap(layer, tableId, map);
          });

        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }

      function filterMap(layer, tableId, map) {
        var where = generateWhere();

        if (where) {
          if (!layer.getMap()) {
            layer.setMap(map);
          }
          layer.setOptions({
            query: {
              select: 'col9',
              from: tableId,
              where: where
            },
            styles: [{
            polygonOptions: {
              fillColor: '#00FF00',
              fillOpacity: 0.3
            }
          }, {
            where: 'PubCode = 5400',
            polygonOptions: {
              fillColor: '#0000FF'
            }
          }, {
            where: 'PubCode = 5300',
            polygonOptions: {
              fillOpacity: 1.0,
              fillColor: '#FFFFFF'
            }
          }]
          });
        } else {
          layer.setMap(null);
        }
      }

      function generateWhere() {
        var filter = [];
        var publications = document.getElementsByName('publication');
        console.log(publications);
        for (var i = 0, publication; publication = publications[i]; i++) {
          if (publication.checked) {
            var publicationName = publication.value.replace(/'/g, '\\\'');
            filter.push("'" + publicationName + "'");
          }
        }
        var where = '';
        if (filter.length) {
          where = "'PubCode' IN (" + filter.join(',') + ')';
        }
        return where;
      }


    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkPQ9BLBwW_xCk4Wrh55UjZvyVqPc_5FU&libraries=places&callback=initAutocomplete"
         async defer></script>


    </section>
</div>
<?php get_footer(); ?>