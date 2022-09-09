<?php
include('../../logIn/singIn.php');

$conn = new mysqli("localhost", "root", "", "project_web");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id = $_SESSION['Id'];
#$id= 30;
$sql="SELECT date_of,name_store FROM user
LEFT JOIN visit ON visit.id_user=user.user_id
LEFT JOIN store ON store.store_id=visit.id_store WHERE user_id='$id'";

$result_sql = mysqli_query($conn,$sql);
$array_table = array();

if(mysqli_num_rows($result_sql)>0)
{
    while ($row = mysqli_fetch_assoc($result_sql))
    {
        $temp = array('date_of' => $row['date_of'],'name_store'=>$row['name_store']);
        array_push($array_table,$temp);
    }
}
echo json_encode($array_table);