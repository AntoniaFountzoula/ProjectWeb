<?php
// Create connection
$conn = new mysqli("localhost", "root", "", "project_web");


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$jsonfile=file_get_contents('specific.json');
$obj=json_decode($jsonfile);
echo sizeof($obj);

for($i=0; $i<sizeof($obj); $i++) {
    $par1 = ($obj[$i])->name;
    $par2 = ($obj[$i])->coordinates->lng;
    $par3 = ($obj[$i])->coordinates->lat;
    $par =($obj[$i])->address;

    $sql="INSERT INTO store (store_id,name_store,longitude,latitude,time_spent,store_add)VALUES($i,'$par1',$par2,$par3,30,'$par')";

    mysqli_query($conn,$sql);
}