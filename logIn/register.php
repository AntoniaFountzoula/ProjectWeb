<?php
$servername ="localhost";
$username = "root";
$password ="";
$dbname ="project_web";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$email_input= $_REQUEST['email'];
$Username= $_REQUEST['username'];
$Password=$_REQUEST['password'];

//Check if the user already exist
$query1="SELECT email FROM user where email= '$email_input'";
$results = mysqli_query($conn, $query1);

if(mysqli_num_rows($results) == 0)
{
    $sql = " INSERT INTO user (user_type,username,email,password) VALUES ('user','$Username','$email_input','$Password') ";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Welcome to Covid-19 Finder! You have been register successful!');
            window.location.href='logIn.html';
            </script>";


    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    die();
}
else{
    echo "<script>alert('You already have an account with this email!');
            window.location.href='register.html';
            </script>";
    die();
}

