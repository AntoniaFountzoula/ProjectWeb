navigator.geolocation.getCurrentPosition(function (location) {
    // Initialize the map
    const map = L.map('map');
    var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);


    // Get the tile layer from OpenStreetMaps
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            MaxZoom: 13,
            // Set the attribution for OpenStreetMaps
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'

        }).addTo(map);

    // Set the view of the map
    // with the latitude, longitude and the zoom value
    map.setView(latlng, 13);

    // Show a market at the position
    let myposition = L.marker(latlng).addTo(map);

    // Bind popup to the marker with a popup
    myposition.bindPopup("Here I am");
    L.circle(latlng, {radius: 5000}).addTo(map);
    // L.circle(latlng,{radius: 20, color: 'green', fillColor: '#00ff33', fillOpacity: 0.5}).addTo(map);

    $.ajax({
        type: 'post',
        url:'caseEntry.php',
        dataType: 'json',
        success: function (response){
            //var response =arr.responseText;
            console.log(response.length)
            for(var i = 0 ; i < response.length; i++)
            {
                var xy= new L.LatLng(response[i].lat, response[i].lng);
                L.marker(xy).addTo(map);
            }
        },
        error:function (error){
            console.log(error);
        }
    });
});





