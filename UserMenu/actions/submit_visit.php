<?php
include('../../logIn/singIn.php');

$conn = new mysqli("localhost", "root", "", "project_web");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_user = $_SESSION['Id'];
//$id_user=1;
$id_store = $_POST['id_store'];
//$id_store='ChIJQzflOrBJXhMRP_0TfKrg-t8';
/*
 * Set time zone ,so we can have the correct time
*/
date_default_timezone_set('Europe/Athens');
$date =  (new DateTime(''))->format('Y-m-d H:i:s');
echo $date;
$apro = $_POST['approximation'];

$sql="INSERT INTO visit(date_of, id_user, id_store) VALUES ('$date','$id_user','$id_store')";
echo $sql;
//it also needed a query for approximation
if(mysqli_query($conn,$sql)){
    echo json_encode(array("Status"=>'Success'));
}
else{
    echo json_encode(array("Status"=>'Failed!'));
}
mysqli_close($conn);