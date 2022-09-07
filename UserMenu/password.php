<?php
// Create connection
$conn = new mysqli("localhost", "root", "", "project_web");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


//change password

    $id = $_POST['id'];
    $new_password =$_POST['newPassword'];
    $confirm_password=$_POST['repeatNewPassword'];
    $current_password= $_POST['ConfirmPassword'];
    $sql = "UPDATE user SET password = '$new_password' WHERE user_id = '$id' ";
    $sql_confirm = "SELECT password FROM user WHERE user_id = '$id'";
    $result_confirm = mysqli_query($conn,$sql_confirm);
    $cp = mysqli_fetch_assoc($result_confirm);

    if ($cp['password']!= $current_password){

        echo json_encode(array('response' => 'NO'));
    }
    else
    {
        if(!mysqli_query($conn, $sql))
        {
            echo json_encode(array('response' => 'OK'));
        }

    }

mysqli_close($conn);

