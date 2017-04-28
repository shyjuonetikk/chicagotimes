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