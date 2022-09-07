<?php
include('../logIn/singIn.php');

    $conn = new mysqli("localhost", "root", "", "project_web");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $id = $_SESSION['Id'];
    #$id= 30;
    $sql ="SELECT test_date FROM covidcase WHERE case_id ='$id' ";
    $result_sql = mysqli_query($conn,$sql);
    $array_table = array();
    if(mysqli_num_rows($result_sql)>0)
    {
        while ($row = mysqli_fetch_assoc($result_sql))
        {
            $temp = array('test_date' => $row['test_date']);
            array_push($array_table,$temp);
        }
    }
    echo json_encode($array_table);

    mysqli_close($conn);