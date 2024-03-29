<?php

// Create connection
$conn = new mysqli("localhost", "root", "", "project_web");


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$mylat=$_POST['lat'];
$mylong = $_POST['long'];
#$mylat=38.2501;
#$mylong = 21.7379;
$array_table = array();
$sql="SELECT name_store,latitude, longitude,store_add,store_id FROM store";
$result=mysqli_query($conn,$sql);

 while($row = mysqli_fetch_assoc($result))
 {
     $temp=array('name'=>$row['name_store'],'lat'=>$row['latitude'], 'lng'=>$row['longitude'],'address'=>$row['store_add'],'id'=>$row['store_id']);
     # echo $row['name_store']."\n ";
     //check distance (change the number according to exercise)
     if(computeDistance($mylat,$mylong,$row['latitude'],$row['longitude'])< 900)
     {
         array_push($array_table,$temp);
     }

 }
mysqli_close($conn);

echo json_encode($array_table);

#function calculate Euclidean distance between tow points

function distance(float $x1, float $y1,float $x2, float $y2) :float
{
     return sqrt(pow(($x1 - $x2),2) + pow($y1 - $y2,2));

}

#other function more  beautiful
function computeDistance($lat1, $lng1, $lat2, $lng2, $radius = 6378137)
{
    static $x = M_PI / 180;
    $lat1 *= $x; $lng1 *= $x;
    $lat2 *= $x; $lng2 *= $x;
    $distance = 2 * asin(sqrt(pow(sin(($lat1 - $lat2) / 2), 2) + cos($lat1) * cos($lat2) * pow(sin(($lng1 - $lng2) / 2), 2)));

    return $distance * $radius;
}