---
---
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>MSMSAA: The Alumni Map</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<meta name="description" content="A map of the zipcodes that MSMS alumni call home">
<meta name="keywords" content="alumni, maps">

   <!-- Our Google Map Script -->
   <script src="https://maps.googleapis.com/maps/api/js"></script>    
   <script>
   var data = <?php require 'genjson.php';
                 echo gendata(); ?>; 
   </script>
   <!-- Our Google Map Clusterer Script -->
   <script src="../js/markerclusterer.js"></script>
   <script>
    var map;
    var geocoder;

    //A single info window for the entire map.
    var infowindow = new google.maps.InfoWindow({
      size: new google.maps.Size(150.50)
     });

    function attachInfo(marker, info) {
      marker.addListener('click', function() {
        infowindow.setContent(info);
        infowindow.open(marker.get('map'), marker);
      });
    }

    function initialize() {
      var center = new google.maps.LatLng(33.4916, -88.4181);
      geocoder = new google.maps.Geocoder();
      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12, 
        center: center,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });
     
      google.maps.event.addListener(map, 'click', function() {
        infowindow.close();
      });


      var school = new google.maps.Marker({
        map: map,
        icon: "../pics/bluemarker.png",
        position: center
      });

      var contentString = "<b><a href=http://www.msms.k12.ms.us>MSMS:</a></b> "
        + "The Mississippi School for Mathematics and Science";
      
      attachInfo(school, contentString);
 
      var markers = [];
       for (var i = 0; i < data.length; i++) {
        if (data[i].lat) {
          var latLng = new google.maps.LatLng(data[i].lat,
              data[i].lon);
          var marker = new google.maps.Marker({
            position: latLng
          });
          
          var info;
          
          if (data[i].count > 1) 
            info = data[i].count + " alumni live in " + data[i].zip; 
          else
           info = data[i].count + " alumnus lives in " + data[i].zip;

          attachInfo(marker,info); 
          markers.push(marker);
        }
       }
      var markerCluster = new MarkerClusterer(map, markers);
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    
    //Centers the map around the address in the address field.
    function findAddress(address) {
       if (address) { 
         geocoder.geocode( { 'address' : address}, function(results, status) {
           if (status == google.maps.GeocoderStatus.OK) {
             map.setCenter(results[0].geometry.location);
            } else {
              alert("Geocode was not successful because " + status);
            }
          } 
        );
       }
    }
  </script>
  </head>
  <body>
  <div class="container-fluid">
    <h1 class="text-center">MSMS Alumni Association</h1>
  </div>
  <div class="container">
    <div class="row">
       {% include top_menu.html %}
    </div>
    <div class="row">
      <div class="col-sm-3">
        {% include side_menu.html %} 
      </div>
      <div class="col-sm-9">
          <form class="form-horizontal" 
                action="#" onsubmit="findAddress(this.address.value); return false">
           <div class="form-inline"> 
               <label class="sr-only" for="inputAddress">Address</label>
               <input type="text" class="form-control" id="inputAddress"
                name="address" 
                placeholder="Columbus, MS"/>
               <input type="submit" value="Enter  Address">
           </div>
          </form>
          <div id="map" style="width: 100%; height: 500px; float: left "></div>
      </div>
    </div>
  </body>
</html>
