<?php
include('../logIn/singIn.php');
// Create connection
$conn = new mysqli("localhost", "root", "", "project_web");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userid = $_POST['id'];
$new_username =$_POST['newUsername'];
$sql = "UPDATE user SET username = '$new_username' WHERE user_id = $userid";
$sql_exist_user ="SELECT username FROM user WHERE username = '$new_username'";
$result_exist = mysqli_query($conn,$sql_exist_user);

if(mysqli_num_rows($result_exist) > 0)
{
    echo json_encode(array('response' => 'NO'));
}
else
{
    if(mysqli_query($conn, $sql))
    {
        $_SESSION['user'] =$new_username;
        echo json_encode(array('response' => 'OK','name'=>$new_username));
    }
}

mysqli_close($conn);