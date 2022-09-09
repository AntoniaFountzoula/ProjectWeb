<?php

    $conn = new mysqli("localhost", "root", "", "project_web");

    $current_day= $_POST['test_date'];
    $id = $_POST['id'];


    $sql1 = "INSERT INTO covidcase(CASE_ID, TEST_DATE ) VALUES ('$id' , '$current_day')";

    if(validDte($id,$current_day))
    {
        if(mysqli_query($conn,$sql1))
        {
            echo json_encode(array("response"=>'OK'));

        }
    }
    else
    {
        echo json_encode(array("response"=>'NOT'));
    }

    mysqli_close($conn);

    function validDte($id,$current_day):bool
    {
        $conn = new mysqli("localhost", "root", "", "project_web");

        $sql2 ="SELECT test_date FROM covidcase WHERE case_id ='$id' ";
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





