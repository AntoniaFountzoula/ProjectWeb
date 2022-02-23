<?php
$servername = "localHost";
$db_username = "root";
$db_password = "";
$dbname = "project_web";
// Create connection
$conn = new mysqli($servername, $db_username, $db_password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//session_start();
$username= "";
$password="";
$errors = array();

if (isset($_POST['login'])) {

    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $query = "SELECT * FROM user WHERE username='$username' AND password='$password' LIMIT 1";
    $results = mysqli_query($conn, $query);

    if (mysqli_num_rows($results) == 1) {
        // check if user is admin or user
        $logged_in_user = mysqli_fetch_assoc($results);
        if ($logged_in_user['user_type'] == 'Admin') {
            //$_SESSION['user'] = $logged_in_user;
            //$_SESSION['success']  = "You are now logged in";
            //header('location: admin/home.php');

        }else

            if ($logged_in_user['user_type'] == 'user'){
                //$_SESSION['user'] = $logged_in_user;
               // $_SESSION['success']  = "You are now logged in";
                file_get_contents("UserMenu/UserMenu.html");
                //header('location: C:\Users\Τόνια\php_html_cssJC\project22\UserMenu\UserMenu.html');
            }
    }else
    {
        echo "Something is wrong ";
        mysqli_close($conn);
        header("logIn.html" );
    }
}


