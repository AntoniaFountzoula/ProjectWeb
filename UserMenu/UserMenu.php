<?php
include('../logIn/singIn.php');
// If the user is not logged in and tries to access this page, they are automatically redirected to the login page.
if (!isset($_SESSION['user']))
{
    $_SESSION['msg'] = "You must log in first";
    header('Location: ../logIn/logIn.html');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--  Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
          integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
          crossorigin=""/>

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
            integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
            crossorigin="">
    </script>




    <title>Covid-19FinDer</title>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container-fluid">
        <span class="px-5 mb-0 h2"><img class="navbar-brand" src="../icons/covid-19.png"  width="50;" alt="navigation-icon">Finder </span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span ><img src="../icons/menu.svg" alt="menu icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNavDropdown">
            <ul class="navbar-nav w-100 justify-content-start">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="UserMenu.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="CaseRegistration.php">Case Registration</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Settings.php">Settings</a>
                </li>
            </ul>
             <ul class="nav navbar-nav ml-auto w-100 justify-content-end">
                    <li class="nav-item ">
                        <a class="btn btn-sm btn-outline-secondary" href="../logIn/logout.php" >Log out</a>
                    </li>
             </ul>

        </div>
    </div>
</nav>

<div class="container" id="UserMenu">

        <div class="text-center col-12 mb-3">
             Welcome <?php echo $_SESSION['user'] ?>
        </div>

        <div class="input-group mb-3 w-75 p-2">
            <input type="text" class="form-control border-end-0 border" placeholder="Search..." aria-label="Search" aria-describedby="Search">
            <span class="input-group-append">
                 <button class="btn btn-outline-secondary " type="button" id="Search">
                <img src="../icons/search.svg" alt="search-icon">
            </button>
            </span>
        </div>


        <div class=" w-75 p-3">
            <div id="map"  style="width: 960px; height: 650px; "></div>
        </div>

</div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
navigator.geolocation.getCurrentPosition(function (location){
    // Initialize the map
    const map = L.map('map');
    var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);


    // Get the tile layer from OpenStreetMaps
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            zoom:13,
            // Set the attribution for OpenStreetMaps
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }
    ).addTo(map);

    // Set the view of the map
    // with the latitude, longitude and the zoom value
    map.setView(latlng, 13);

    // Show a market at the position
    let myposition  = L.marker(latlng).addTo(map);

    // Bind popup to the marker with a popup
    myposition.bindPopup("Here I am");
    L.circle(latlng,{radius: 5000}).addTo(map);
    L.circle(latlng,{radius: 20, color: 'green', fillColor: '#00ff33', fillOpacity: 0.5}).addTo(map);

    }

);



</script>