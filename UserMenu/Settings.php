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



<div class="row">
    <div class="col-md-4">
        <ul class="nav flex-column nav-tabs" id="setTab" role="tablist" aria-orientation="vertical" >
            <li class="nav-item">
                <a class="nav-link active" id="password-tab" data-bs-toggle="tab" href="#nav-pass" role="tabpanel" aria-controls="nav-pass"  aria-selected="true">Change my password</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="username-tab" data-bs-toggle="tab" href="#nav-user" role="tabpanel" aria-controls="nav-user" aria-selected="false">Change my Username</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="check-tab" data-bs-toggle="tab" href="#nav-check" role="tabpanel" aria-controls="nav-check" aria-selected="false">Check my visits</a>
            </li>
        </ul>
    </div>

    <div class="col-md-4">
        <div class="tab-content">
            <div class="tab-pane  active" id="nav-pass" role="tabpanel" aria-labelledby="password-tab" tabindex="0">
                <form method="post" action="Settings.php">
                    <div class="form-group">
                        <input type="password" id="formControlDefault" class="form-control" name="ConfirmPassword"  placeholder="Type Current password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" />
                        <label class="form-label" for="formControlDefault"></label>
                    </div>
                    <div class="form-group">
                        <input type="password" id="formControlDefault" class="form-control" name="newPassword"  placeholder="Type new password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" />
                        <label class="form-label" for="formControlDefault"></label>
                    </div>
                    <div class="form-group">
                        <input type="password" id="formControlDefault" class="form-control" name="repeatNewPassword"  placeholder="Confirm new password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" />
                        <label class="form-label" for="formControlDefault"></label>
                    </div>
                    <input type="submit"  name="pasSup" class="btn btn-primary" value="Submit">
            </div>
            <div class="tab-pane"  id="nav-user" role="tabpanel" aria-labelledby="username-tab" tabindex="0">
                <div class="form-group">
                    <input type="username" id="formControlDefault" class="form-control" name="CurrentUsername"  placeholder="Type Current username">
                    <label class="form-label" for="formControlDefault"></label>
                </div>
                <div class="form-group">
                    <input type="username" id="formControlDefault" class="form-control" name="newUsername"  placeholder="Enter new username" >
                    <label class="form-label" for="formControlDefault"></label>
                </div>
                <input type="submit"  name="passup" class="btn btn-primary" value="Submit">
            </div>
            <div class="tab-pane"  id="nav-check" role="tabpanel" aria-labelledby="check-tab" tabindex="0">
                <table class="table align-middle mb-0 bg-white">
                    <thead class="bg-light">
                    <tr>
                        <th>Last Visit</th>
                        <th>Location</th>
                        <th>Last registered positive test </th>
            </div>
        </div>
    </div>
    </form>
    <script>
        const triggerTabList = document.querySelectorAll('#setTab button')
        triggerTabList.forEach(triggerEl => {
            const tabTrigger = new bootstrap.Tab(triggerEl)

            triggerEl.addEventListener('click', event => {
                event.preventDefault()
                tabTrigger.show()
            })
        })
    </script>
</div>
</body>

</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>