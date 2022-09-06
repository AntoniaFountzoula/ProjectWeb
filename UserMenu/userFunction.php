<?php
// Create connection
$conn = new mysqli("localhost", "root", "", "project_web");


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
include('../logIn/singIn.php');
$userid = $_SESSION['Id'];
//change password
if (isset($_POST['pasSup']))
{
    $id = $_SESSION['Id'];
    $new_password =$_POST['newPassword'];
    $confirm_password=$_POST['repeatNewPassword'];
    $current_password= $_POST['ConfirmPassword'];
    $sql = "UPDATE user SET password = '$new_password' WHERE user_id = $userid ";
    $sql_confirm = "SELECT password FROM user WHERE user_id=$id";
    $result_confirm = mysqli_query($conn,$sql_confirm);
    $cp = mysqli_fetch_assoc($result_confirm);

    if($new_password!= $confirm_password)
    {
        echo "<script>                 
                    alert('Passwords do not match. Try again!');
                    window.location.href='Settings.php';
                    </script>";
    }elseif ($cp['password']!= $current_password){

        echo "<script>                 
                    alert('Incorrect current password. Try again!');
                    window.location.href='Settings.php';
                    </script>";

    }
    else
    {
        if(!mysqli_query($conn, $sql))
        {
            echo $sql;
        }

    }

}

// change username
if (isset($_POST['usernamesup']))
{
    $new_username =$_POST['newUsername'];
    $sql = "UPDATE user SET username = '$new_username' WHERE user_id = $userid";
    $sql_exist_user ="SELECT username FROM user WHERE username = '$new_username' ";
    $result_exist = mysqli_query($conn,$sql_exist_user);

    if(mysqli_num_rows($result_exist) > 0)
    {
        echo "<script>                 
                    alert('Username taken, enter a new one!');
                    window.location.href='Settings.php';
                    </script>";
    }
    else
    {
        if(mysqli_query($conn, $sql))
        {
            $_SESSION['user'] =$new_username;
            header('Location: Settings.php');
        }
    }

}


/*--------------------------- Case Registration--------------------------- */


/*if (isset($_POST['covidcase']))
{
    $date1 = $_REQUEST['datetest'];
    $case_id = $_SESSION['Id'];
    $sql1 = "INSERT INTO covidcase(CASE_ID, TEST_DATE ) VALUES ('$case_id' , '$date1')";


        if(mysqli_query($conn,$sql1))
        {
            header("Location: CaseRegistration.php");
        }

}*/


