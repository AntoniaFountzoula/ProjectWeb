<?php

// Create connection
$conn = new mysqli("localhost", "root", "", "project_web");


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$array_table = array();
$sql="SELECT name_store,latitude, longitude FROM store";
$result=mysqli_query($conn,$sql);

 while($row = mysqli_fetch_assoc($result))
 {
     $temp=array('name'=>$row['name_store'],'lat'=>$row['latitude'], 'lng'=>$row['longitude']);
     array_push($array_table,$temp);
 }
mysqli_close($conn);

echo json_encode($array_table);

