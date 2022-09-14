<?php

    $conn = new mysqli("localhost", "root", "", "project_web");

    $current_day= $_POST['test_date'];
    $id = $_POST['id'];
    $sql1 = "INSERT INTO covidcase( test_date, case_id) VALUES ('$current_day',$id )";

    if(validDte($id,$current_day))
    {
        if(mysqli_query($conn,$sql1))
        {
            echo json_encode(array("response"=>'OK'));

        }
        /*
         * Update the status of the user visit
         * that there are register at most 7 day
         * before the registration of covid-case
        */
        $date_condition=date_sub((new DateTime($current_day)),date_interval_create_from_date_string("7 days"))->format('Y-m-d H:i:s');
        $sql_update="UPDATE visit SET status=1 WHERE id_user=$id AND date_of>='$date_condition'";
        mysqli_query($conn,$sql_update);
    }
    else
    {
        echo json_encode(array("response"=>'NOT'));
    }

    mysqli_close($conn);

    function validDte($id,$current_day):bool
    {
        $conn = new mysqli("localhost", "root", "", "project_web");

        $sql2 ="SELECT test_date FROM covidcase WHERE case_id = $id ";
        $resu = mysqli_query($conn,$sql2);
        $ans= true;
        if(mysqli_num_rows($resu) > 0)
        {

            while ($row = mysqli_fetch_assoc($resu))
            {
                $date2= ($row['test_date']);
                $diff = abs(strtotime($date2) - strtotime($current_day));
                $diff_days= $diff/(24*60*60);
                if($diff_days <= 14)
                {
                    $ans=false;
                    break;

                }
            }
        }
        mysqli_close($conn);
        return $ans;
    }





