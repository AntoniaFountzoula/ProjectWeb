<?php
// Create connection
$conn = new mysqli("localhost", "root", "", "project_web");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$category=$_POST['category'];
$array_marker= array();
$sql= "SELECT name_store,latitude, longitude,store_add,store_id FROM store where type_store like '%$category%'";
$result=mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result))
{
    $temp=array('name'=>$row['name_store'],'lat'=>$row['latitude'], 'lng'=>$row['longitude'],'address'=>$row['store_add'],'id'=>$row['store_id']);
    # echo $row['name_store']."\n ";

    array_push($array_marker,$temp);
}
echo json_encode($array_marker);
mysqli_close($conn);