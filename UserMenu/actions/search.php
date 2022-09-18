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


date_default_timezone_set('Europe/Athens');
$today = new DateTime('');
$date = $today->format('N');
$hour = $today->format('G');


while($row = mysqli_fetch_assoc($result))
{
    $ava=approximation($conn,$row['store_id'],$date,$hour);
    $percentage=percentage_approximation($conn,$row['store_id'],$date,$hour,($ava*3));
    $temp=array('name'=>$row['name_store'],'lat'=>$row['latitude'], 'lng'=>$row['longitude'],'id'=>$row['store_id'],'address'=>$row['store_add'],'percentage'=>$percentage,'approximation'=>$ava);
    # echo $row['name_store']."\n ";

    array_push($array_marker,$temp);
}
echo json_encode($array_marker);
mysqli_close($conn);

function approximation($conn,$id,$date,$hour)
{
    $columns_of_table = "";

    for ($i = 0; $i <3; $i++)
    {
        if($hour>23)
        {
            $hour=1;
        }
        $columns_of_table .= "h$hour,";
        $hour+=1;
    }

    $columns_of_table = rtrim($columns_of_table, ",");
    $sql = "SELECT $columns_of_table FROM popular_times WHERE date='$date' and id_of_store=$id";
    $result = mysqli_query($conn, $sql);
    $average_approximation = 0;
    while ($row = mysqli_fetch_row($result)) {
        $average_approximation += ($row[0] + $row[1] + $row[2]);

    }
    return $average_approximation/3;
}

function percentage_approximation($conn,$id,$date,$hour,$average)
{

    $column_now="h$hour";
    $columns_of_table = "";
    for ($i =1; $i <24 ; $i++) {
        $columns_of_table .= "h$i,";
    }
    $columns_of_table = rtrim($columns_of_table, ",");
    $sql = "SELECT $columns_of_table FROM popular_times WHERE date='$date' and id_of_store=$id";
    $sql_now="SELECT $column_now FROM popular_times WHERE date='$date' and id_of_store=$id";
    $sum=0;
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_row($result)) {
        $sum += ($row[0]+$row[1]+$row[2]+$row[3]+$row[4]+ $row[5]+ $row[6]+ $row[7]+ $row[8]+ $row[9]+ $row[10]+ $row[11]+ $row[12]+ $row[13]+ $row[14]+ $row[15] + $row[16]+ $row[17]+ $row[18]+ $row[19]+ $row[20]+ $row[21]+$row[22] );
    }
    $result2=mysqli_query($conn,$sql_now);
    $per=0;
    while ($row=mysqli_fetch_row($result2))
    {
        $per=($sum!=0)?$average/$sum: 0;
    }

    return ($per*100);
}