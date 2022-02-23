<?php
$servername ="localHost";
$username = "root";
$password ="";
$dbname ="project_web";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$email= $_REQUEST['email'];
$username= $_REQUEST['username'];
$password=$_REQUEST['password'];

$sql = " INSERT INTO USER (user_type,username,email,password) 
 VALUES ('user','$username','$email','$password') ";

if (mysqli_query($conn, $sql)) {
    echo "Welcome to Covid-19 Finder! You have been register successful. ";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
//mysqli_close($conn);
 file_get_contents("UserMenu/UserMenu.html");

