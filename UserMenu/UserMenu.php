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
<html lang="en" xmlns="http://www.w3.org/1999/html">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
    <div class="w-75">
        <div class="input-group input-group-md p-3  ">
            <label  class="form-label col-1" for="category"> <h5 >Search:</h5></label>

            <select class="form-select " id="category">
                <option>store</option>
                <option value="shoe_store">Shoe store</option>
                <option value="clothing_store">Clothing store</option>
                <option>pharmacy</option>
                <option>food</option>
                <option>cafe</option>
                <option>bakery</option>
                <option>restaurant</option>
                <option>bar</option>
                <option>supermarket</option>
                <option value="electronics_store">Electronic store</option>
                <option value="meal_takeaway"> take away</option>
                <option value="night_club"> night club</option>
                <option value="post_office">post office</option>
                <option value="car_rental"> Car rental</option>
            </select>
            <button class="btn btn-outline-secondary"  id="search" type="button"><img src="../icons/search.svg"></button>
        </div>

    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-9">
        <div class=" w-75 p-2">
            <div id="map"  style="width: 960px; height: 650px; "></div>
        </div>
    </div>
        <div class="col-md-3">
            <div class="position-relative">
                <div class="position-absolute top-0 start-50 translate-middle-x">
                <button type="button" class="btn btn-dark" id="show_poi">Show markers</button>
                </div>
            </div>
        </div>

    </div>
</div>
    <form  method="post">
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Complete visitation entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="approximation_valueς" class="form-label">Entry of visitation in this poi.Please insert approximate people who visited this exact location.</label>
                        <input type="text" class="form-control" id="approximation_value" placeholder="number of approximation">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit"  name="case_entry" class="btn btn-primary" id="visit_button" value="Submit"/>
                </div>
            </div>
        </div>
    </div>
    </form>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script type="text/javascript" src="map.js"></script>
<script>

</script>