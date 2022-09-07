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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Covid-19Finder</title>
</head>
<body >
<nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container-fluid ps-0">
        <span class="px-5 mb-0 h2"><img class="navbar-brand" src="../icons/covid-19.png"  width="50;" alt="navigation-icon">Finder </span>
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
                <form method="post" >
                    <div class="form-group">
                        <input type="password" id="ConfirmPassword" class="form-control" name="ConfirmPassword"  placeholder="Type Current password" />
                        <label class="form-label" for="ConfirmPassword"></label>
                    </div>
                    <div class="form-group">
                        <input type="password" id="newPassword" class="form-control" name="newPassword"  placeholder="Type new password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" />
                        <label class="form-label" for="newPassword"></label>
                    </div>
                    <div class="form-group">
                        <input type="password" id="repeatNewPassword" class="form-control" name="repeatNewPassword"  placeholder="Confirm new password"/>
                        <label class="form-label" for="repeatNewPassword"></label>
                    </div>
                    <button type="submit"  name="pasSup" class="btn btn-primary" onclick="changePassword()" > Submit</button>
                </form>
            </div>
            <div class="tab-pane"  id="nav-user" role="tabpanel" aria-labelledby="username-tab" tabindex="0">
              <form>
                  <div class="form-group pb-3">
                      <label class="form-label" for="formControlDefault"> Current Usename</label>
                      <input type="text" id="formControlDefault" class="form-control"  value="<?php echo $_SESSION['user']; ?>" >
                  </div>
                  <div class="form-group">
                      <input type="text" id="newUsername" class="form-control"   placeholder="Enter new username" >
                      <label class="form-label" for="newUsername"></label>
                  </div>
                  <button type="submit"  name="usernamesup" class="btn btn-primary" onclick="changeUsername()"> Submit</button>
              </form>
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

</div>
</body>
</html>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    const triggerTabList = document.querySelectorAll('#setTab button')
    triggerTabList.forEach(triggerEl => {
        const tabTrigger = new bootstrap.Tab(triggerEl)

        triggerEl.addEventListener('click', event => {
            event.preventDefault()
            tabTrigger.show()
        })
    })


function changePassword()
{
    let current = document.getElementById('ConfirmPassword').value;
    let newpassword = document.getElementById('newPassword').value;
    let repeat = document.getElementById('repeatNewPassword').value;
    var obj = {
        'ConfirmPassword': current,
        'newPassword': newpassword,
        'repeatNewPassword': repeat,
        'id': '<?=$_SESSION['Id']?>'
    };

    var showmessage = true;

    if (repeat != newpassword) {
        alert('Passwords do not match. Try again!');
        window.location.href = 'Settings.php';
    }
    if (repeat == newpassword)
    {
        $.ajax({
            type: "post",
            dataType: "json",
            url: 'password.php',
            data: obj,
            success: function (data) {
                showmessage = (data.response == 'OK');
                if (showmessage)
                {
                    alert('Password changes successfully!');
                }
                else
                {
                    alert('The current password is incorrect!');
                }
            },
            error: function (error) {
            }
        });
    }

}
  function  changeUsername()
  {
      let newname = document.getElementById('newUsername').value ;
      $.ajax({
          type: "post",
          dataType: "json",
          url: 'username.php',
          data: {'newUsername': newname,'id' : '<?=$_SESSION['Id']?>'},
          success: function (data) {

              if(data.response=='OK')
              {

                  alert('Username change successfully!');
              }
              else{
                  alert('Username taken, enter a new one!');
                  window.location.href='Settings.php';
              }
          },
          error: function (error) {
          }
      });

  }
</script>