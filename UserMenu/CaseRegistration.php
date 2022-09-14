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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

<div class="container pt-3">
    <div class="accordion col-10 " id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    Case Registration
                </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    <form  method="post" >
                        <div class="mb-3 col-6">
                            <label for="datetest" class="form-label"> Date tested</label>
                            <input type="datetime-local" class="form-control"  name="datetest" id="datetest" aria-describedby="datelHelp">
                            <div id="datelHelp" class="form-text">Please, choose the date that you tested positive.</div>
                            <div class=" text-end mb-2">
                                <button type="button"  name="covidcase" id="covidcase" class="btn btn-primary" onclick="check_day()"> Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    Possible contact with covid-19 case
                </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">
                    <p class="fst-italic"> The below table shows the if you have come in contact with covid-19 cases in the last 7 days</p>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-info">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Stores(PIOs)</th>
                                <th scope="col">Date of covid-case</th>
                            </tr>
                            </thead>
                            <tbody id="possible-contact">

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>


</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
    show_table();
function check_day() {
    let day = document.getElementById('datetest').value;

    $.ajax({
        type: "post",
        dataType: "json",
        url: '../UserMenu/actions/checkday.php',
        data: {'test_date': day, 'id': '<?=$_SESSION['Id']?>'},
        success: function (data) {

            if (data.response === 'OK')
            {
              alert('You have submit your diagnosis.');
            }
            else
            {
               alert('14 days must transpire until you submit your next Covid-19 diagnosis!');
            }
            window.location.href ='CaseRegistration.php';
        },
        error: function (error) {
            alert(error.statusText);
            window.location.href ='CaseRegistration.php';
        }
    });

}
function show_table()
{
    var html;


    $.ajax({
        type: "post",
        dataType: "json",
        url: '../UserMenu/actions/possible_contact.php',
        success: function (data) {
            for(let i=0; i<data.length; i++)
            {
                html+='<tr> <th scope="row">'+(i+1)+'</th>';
                html+='<td>'+data[i].name +'</td> ';
                html+='<td>'+data[i].date +'</td> </tr>';


            }
            if(data.length === 0) {html+='<tr> <th scope="row">1</th> <td> We did not find possible contacts with covid-case for you</td> <td></td></tr>'; }
            $("#possible-contact").append(html);

        },

    });


}
</script>