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
$now =$today->format('Y-m-d H:i:s');
$date = $today->format('N');
$hour = $today->format('G');


while($row = mysqli_fetch_assoc($result))
{
    $user_approx= user_approximation($conn,$now,$row['store_id']);
    $ava=approximation($conn,$row['store_id'],$date,$hour);
    $percentage=percentage_approximation($conn,$row['store_id'],$date,$hour,($ava*3));
    $temp=array('name'=>$row['name_store'],'lat'=>$row['latitude'], 'lng'=>$row['longitude'],'id'=>$row['store_id'],'address'=>$row['store_add'],'percentage'=>$percentage,'approximation'=>$ava,'user_approx'=>$user_approx);
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
            $hour=0;
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

function user_approximation($conn,$today,$store_id)
{
    echo "\n";
    $result = mysqli_query($conn, "SELECT approximation,TIMESTAMPDIFF(MINUTE,date_approximation,'$today')as diff
FROM user_aprox WHERE aprox_store_id=$store_id AND  date_approximation<'$today'");
    $sum = 0;
    $count_row = 0;
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $sum += ($row['diff'] < 120) ? $row['approximation'] : 0;
            $count_row += ($row['diff'] < 120) ? 1 : 0;
        }

        return ($count_row>0)?$sum / $count_row:" no_data";
    } else {
        return "no_data";
    }
}

function percentage_approximation($conn,$id,$date,$hour,$average)
{

    $column_now="h$hour";
    $columns_of_table = "";
    for ($i =0; $i <24 ; $i++) {
        $columns_of_table .= "h$i,";
    }
    $columns_of_table = rtrim($columns_of_table, ",");
    $sql = "SELECT $columns_of_table FROM popular_times WHERE date='$date' and id_of_store=$id";
    $sql_now="SELECT $column_now FROM popular_times WHERE date='$date' and id_of_store=$id";
    $sum=0;
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_row($result)) {
        $sum += ($row[0]+$row[1]+$row[2]+$row[3]+$row[4]+ $row[5]+ $row[6]+ $row[7]+ $row[8]+ $row[9]+ $row[10]+ $row[11]+ $row[12]+ $row[13]+ $row[14]+ $row[15] + $row[16]+ $row[17]+ $row[18]+ $row[19]+ $row[20]+ $row[21]+$row[22]+$row[23]);
    }
    $result2=mysqli_query($conn,$sql_now);
    $per=0;
    while ($row=mysqli_fetch_row($result2))
    {
        $per=($sum!=0)?$average/$sum: 0;
    }

    return ($per*100);
}