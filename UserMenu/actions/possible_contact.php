<?php
include('../../logIn/singIn.php');
 $id=$_SESSION['Id'];

// Create connection
$conn = new mysqli("localhost", "root", "", "project_web");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
/*
 * Take the id of stores that user haven been visited
 * the last 7 days
 */
date_default_timezone_set('Europe/Athens');
$date_condition=date_sub((new DateTime('now')),date_interval_create_from_date_string("7 days"))->format('Y-m-d H:i:s');
$my_visit_last_7days=array();
$result=mysqli_query($conn,"SELECT id_store,date_of from visit where date_of>'$date_condition' and id_user=$id");
while($row=mysqli_fetch_assoc($result))
{
    array_push($my_visit_last_7days,array('id_store'=>$row['id_store'],'date'=>$row['date_of']));
}

/*
 * Select the stores that they have registered covid-case
 * and  the current user have been visited 2 hours later or after
 * the covid-case
 */
$my_possible_contact=array();
foreach ($my_visit_last_7days as $i)
{
    $temp_id=$i['id_store'];
    $temp_date=$i['date'];
   // $date_earlier=date_sub($temp_date,date_interval_create_from_date_string("2 hours"))->format('Y-m-d H:i:s');
    //$date_latester= date_add($temp_date,date_interval_create_from_date_string("2 hours"))->format('Y-m-d H:i:s');
    $sql2="SELECT name_store ,date_of,TIMESTAMPDIFF(MINUTE,visit.date_of,'$temp_date')as diff
         FROM visit
        left join  store on store.store_id=visit.id_store
        where visit.id_store=$temp_id and visit.id_user!=$id and visit.status=1 ";
    if($result2=mysqli_query($conn,$sql2))
    {
        if(mysqli_num_rows($result2)>0)
        {
            while($row=mysqli_fetch_assoc($result2))
            {
                if(abs($row['diff'])<= 120)
                {
                    array_push($my_possible_contact,array('name'=>$row['name_store'],'date'=>$row['date_of']));
                }

            }
        }
    }
}
mysqli_close($conn);

echo json_encode($my_possible_contact);

