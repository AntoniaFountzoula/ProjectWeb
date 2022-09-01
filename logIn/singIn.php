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

if (isset($_POST['Login'])) {

    $Username = $_REQUEST['username'];
    $Password = $_REQUEST['password'];
    $query = "SELECT * FROM user WHERE username='$Username' AND password='$Password' LIMIT 1";
    $results = mysqli_query($conn, $query);

    if (mysqli_num_rows($results) == 1)
    {
        // check if user is admin or user
        $logged_in_user = mysqli_fetch_assoc($results);

        switch ($logged_in_user['user_type'])
        {
            case 'Admin':
                $_SESSION['user'] = $logged_in_user['username'];
                $_SESSION['Id']=$logged_in_user['user_id'];
                header('Location:../AdminMenu/index.html');
               // echo "<script>window.location.href='../AdminMenu/index.html';</script>";
                break;
            case 'user':
                $_SESSION['user'] = $logged_in_user['username'];
                $_SESSION['Id']=$logged_in_user['user_id'];
                header('Location:../UserMenu/UserMenu.php');
                //echo "<script>window.location.href='../UserMenu/UserMenu.php';</script>";
                break;
        }
    }
    else
    {
        echo "Something is wrong. Check your password and your username";
        mysqli_close($conn);
        header("Location:logIn.html" );
    }
}


