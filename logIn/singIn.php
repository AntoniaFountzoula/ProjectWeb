<?php

// Create connection
$conn = new mysqli("localhost", "root", "","project_web");


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
$username= "";
$password="";
$errors = array();

/*--------------------------- Log in Start------------------------------- */
if (isset($_POST['Login'])) {

    $Username = $_REQUEST['username'];
    $Password = $_REQUEST['password'];
    $query = "SELECT * FROM user WHERE username='$Username' AND password='$Password' LIMIT 1";
    $results = mysqli_query($conn, $query);
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    if (mysqli_num_rows($results) == 1) {
        // check if user is admin or user
        $logged_in_user = mysqli_fetch_assoc($results);
        switch ($logged_in_user['user_type']) {
            case 'admin':
                if (strpos($user_agent, 'Mobi') == false) {
                    $_SESSION['user'] = $logged_in_user['username'];
                    $_SESSION['Id'] = $logged_in_user['user_id'];
                    header('Location: ../AdminMenu/index.php');
                } else {
                    echo "<script>                 
                    alert('Please connect from desktop!');
                    window.location.href='logIn.html';
                    </script>";
                    mysqli_close($conn);
                }
                break;
            case 'user':
                $_SESSION['user'] = $logged_in_user['username'];
                $_SESSION['Id'] = $logged_in_user['user_id'];
                header('Location:../UserMenu/UserMenu.php');
                break;
        }
    } else {
        echo "Something is wrong. Check your password and your username";
        mysqli_close($conn);
        header("Location:logIn.html");
    }
}
 /*--------------------------- Log in End------------------------------- */






