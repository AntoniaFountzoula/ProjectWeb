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
    <title>Covid-19FinDer</title>
    <link  rel="stylesheet">
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
                    <a class="nav-link"  href="UserMenu.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  active" aria-current="page" href="CaseRegistration.php">Case Registration</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"  href="Settings.php">Settings</a>
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

<div class="container">
    <form  method="post" action="userFunction.php">
        <div class="mb-3 col-6">
            <label for="datetest" class="form-label"> Date tested</label>
            <input type="datetime-local" class="form-control"  name="datetest" id="datetest" aria-describedby="datelHelp">
            <div id="datelHelp" class="form-text">Please, choose the date that you tested positive.</div>
            <div class=" text-end mb-2">
                <input type="submit"  name="covidcase" class="btn btn-primary" value="Submit"/>
            </div>
        </div>
    </form>
</div>

</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>