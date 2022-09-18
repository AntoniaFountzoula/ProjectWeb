<?php

// Create connection
$conn = new mysqli("localhost", "root", "", "project_web");


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$store_id = 214;


date_default_timezone_set('Europe/Athens');
$today =( new DateTime('')) ->format('Y-m-d H:i:s');
echo $today;
echo user_approximation($conn,$today,$store_id);
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