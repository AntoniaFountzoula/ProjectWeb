<?php
// Create connection
$conn = new mysqli("localhost", "root", "","project_web");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$email_input= $_POST['email'];
$Username= $_POST['username'];
$Password=$_POST['password'];
//Check if the user already exist
$query1="SELECT email FROM user where email= '$email_input'";
$results = mysqli_query($conn, $query1);

if(mysqli_num_rows($results) == 0)
{
    $sql = " INSERT INTO user (user_type,username,email,password) VALUES ('user','$Username','$email_input','$Password') ";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(array("Status"=>"success"));

    }
    else
    {
        echo json_encode(array("Status"=>mysqli_error($conn)));
    }
    die();
}
else{
    echo json_encode(array("Status"=>"You already have an account with this email!"));
    die();
}

