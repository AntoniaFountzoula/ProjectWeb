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
    <title>Covid-19Finder</title>
</head>
<body >
<nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container-fluid ps-0">
        <span class="px-0 mb-0 h2"><img class="navbar-brand" src="../icons/covid-19.png"  width="50;" alt="navigation-icon">Finder </span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span ><img src="../icons/menu.svg" alt="menu icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNavDropdown">
            <ul class="navbar-nav w-100 justify-content-start">
                <li class="nav-item">
                    <a class="nav-link "  href="UserMenu.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="CaseRegistration.php">Case Registration</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="Settings.php">Settings</a>
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



<div class="container ps-0 m-0">

<div  class="btn-group">
    <a class="btn btn-secondary" data-bs-toggle="collapse"  role="button" aria-expanded="false"href="#item-1">Username</a>
    <a class="btn btn-warning" data-bs-toggle="collapse"  role="button" aria-expanded="false" href="#item-2">Password</a>
    <a class="btn btn-info" data-bs-toggle="collapse" role="button" aria-expanded="false" href="#item-3">List of my visits</a>

</div>
    <div class="collapse" id="item-1">
        <div class="card card-body">
            <form method="post">
                <div class="mb-3 row">
                    <label for="staticUsername" class="col-sm-2 col-form-label">Current Username</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control-plaintext" id="staticUsername" value=<?php echo $_SESSION['user'] ?>>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="inputUsername" class="col-sm-2 col-form-label"> New Username</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputUsername">
                    </div>
                </div>
                <div class=" text-end mb-2">
                    <input type="submit"  name="newUsername" class="btn btn-primary"/>
                </div>
            </form>
        </div>
    </div>

    <div class="collapse pt-2" id="item-2">
        <div class="card card-body">
            <form method="post">

                <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label"> New Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="testpassword" class="col-sm-2 col-form-label"> Confirm password </label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="testpassword" id="testpassword" aria-describedby="passwordHelp" required>
                        <div id="tpasswordHelp" class="form-text">Write again the new password.</div>
                    </div>
                </div>
                <div class=" text-end mb-2">
                    <input type="submit"  name="newPassword" class="btn btn-primary"/>
                </div>
            </form>

        </div>
    </div>

    <div class="collapse pt-2" id="item-3">
        <div class="card card-body">
            A table with all the visits of the user.
            Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
        </div>
    </div>

</div>

</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>