function initMap() {
    const myLatlng = { lat: -25.363, lng: 131.044 };
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 4,
      center: myLatlng,
    });
    // Create the initial InfoWindow.
    let infoWindow = new google.maps.InfoWindow({
      content: "Click the map to get Lat/Lng!",
      position: myLatlng,
    });
    infoWindow.open(map);
    // Configure the click listener.
    map.addListener("click", (mapsMouseEvent) => {
      // Close the current InfoWindow.
      infoWindow.close();
      // Create a new InfoWindow.
      infoWindow = new google.maps.InfoWindow({
        position: mapsMouseEvent.latLng,
      });
      infoWindow.setContent(
        JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
      );
      infoWindow.open(map);
      current_latLng = mapsMouseEvent.latLng.toJSON();
      lat = current_latLng.lat;
      lng = current_latLng.lng;
      //console.log(lat)
      //console.log(lng)
      
      $('#longitude').html('<input type="text" class="form-control" name="longitude" value="' + lng+ '">');
      $('#latitude').html('<input type="text" class="form-control" name="latitude" value="' + lat+ '">');
    });
   
  }