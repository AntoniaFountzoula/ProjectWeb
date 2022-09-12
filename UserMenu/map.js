navigator.geolocation.getCurrentPosition(function (location) {
        // Initialize the map
        const map = L.map('map');
        var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
        var pos={'lat':location.coords.latitude, 'long':location.coords.longitude};

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
        // L.circle(latlng, {radius: 5000}).addTo(map);
     L.circle(latlng,{radius: 20, color: 'green', fillColor: '#00ff33', fillOpacity: 0.5}).addTo(map);

        let markerArray = Array();


        $("#show_poi").click(function () {
            if (markerArray.length !== 0) {
                deleteitem(markerArray, map);
            } else {
                $.ajax({
                    type: 'post',
                   // async: false,
                    url: '../UserMenu/actions/caseEntry.php',
                    dataType: 'json',
                    data: pos,
                    success: function (response) {
                        if (response.length !== 0) {
                            for (var i = 0; i < response.length; i++) {
                                var xy = new L.LatLng(response[i].lat, response[i].lng)
                                let marker = new L.marker(xy).addTo(map).bindPopup("<strong>Name:</strong> " + response[i].name + "</br> <strong>Address: </strong>" + response[i].address + " </br></br> <button type=\"button\" class=\"btn btn-secondary btn-sm\" data-bs-toggle=\"modal\"  onclick='submit_visit()'  data-bs-target=\"#staticBackdrop\" ><div class='v_button' value="+response[i].id+">Submit Visit</div></button> ");
                                markerArray.push(marker);
                            }
                        }
                        else{
                            alert('There are not PIO close to you!');
                        }

                        console.log(markerArray);

                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }


        });




    });


function closure(marker,map){
    if(map.hasLayer(marker))
    {
        map.removeLayer(marker)
    }

}
function submit_visit(){
    var element=document.getElementsByClassName('v_button');
    let id =element[0].getAttribute('value');
    console.log(id);
    $("#visit_button").click(function (){
        let approximation= document.getElementById('approximation_value').value;
        $.ajax({
            url:'../UserMenu/actions/submit_visit.php',
            type:'post',
            dataType: 'json',
            data:{'id_store':id,'approximation':approximation},
            success:function (response) {
                 //console.log(response.Status);
                 if(response.Status=='Success'){
                     alert("Your visit submitted  successfully ");
                 }else{
                     alert("Your visit did not submit. \n Please try again! ");
                 }
                window.location.href ='UserMenu.php';
            },
            error:function (error) {
                alert(error.statusText);
                window.location.href ='UserMenu.php';
            },

        });

    });

}
function deleteitem(markerArray ,map) {

    for (let m = 0; m < markerArray.length; m++) {
        closure(markerArray[m], map);
    }
    markerArray.splice(0, markerArray.length);
}




