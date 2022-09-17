<?php
$file_array=array();
array_push($file_array,'./b37e935e/generic.json');
array_push($file_array,'./b37e935e/generic_2.json');
array_push($file_array,'./b37e935e/generic_3.json');
array_push($file_array,'./b37e935e/generic_4.json');
array_push($file_array,'./b37e935e/generic_5.json');
array_push($file_array,'./b37e935e/specific_1.json');
array_push($file_array,'./b37e935e/specific_2.json');
array_push($file_array,'./b37e935e/specific_3.json');
array_push($file_array,'./b37e935e/specific_4.json');
array_push($file_array,'./b37e935e/specific_5.json');
array_push($file_array,'./StarterPack1/generic.json');
array_push($file_array,'./StarterPack1/starting_pois.json');
foreach ($file_array as $i)
{
    echo $i."\n";
   // bulk_insert_stores($i,true);
    bulk_insert_popular_times($i,true);
}
function bulk_insert_stores($filename,bool $use_path=false)
{
    // Create connection
    $conn = new mysqli("localhost", "root", "", "project_web");


    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // it will contain the names for existing stores
    $existing_stores = array();

    //Get the contents of the jsonfile
    $jsonfile = file_get_contents($filename, $use_path);
    $obj = json_decode($jsonfile);

    //Get the ids for existing stores from database
    $ids = mysqli_query($conn, "SELECT store_id,name_store FROM store");
    while ($row = mysqli_fetch_assoc($ids)) {
        //echo $row['name_store'];
        //echo " ";
       // echo $row['store_id'];
        //echo "\n\n";
        array_push($existing_stores, $row['name_store']);

    }

    echo "size of json:" . sizeof($obj) . "\n";

    $param_array = array();
    $params_query = "";

    // Convert json to array with the right format of arguments
    for ($i = 0; $i < sizeof($obj); $i++) {
        $name = ($obj[$i])->name;
        $lng = ($obj[$i])->coordinates->lng;
        $lat = ($obj[$i])->coordinates->lat;
        // remove commas for address
        $address = "'" . str_replace(",", " ", ($obj[$i])->address) . "'";
       // $id = "'" . ($obj[$i])->id . "'";
        //convert type (type is an array field)into a string
        $type_array = join(" ", ($obj[$i])->types);
        $type_array = "'" . $type_array . "'";


        //remove single quote(throw an error when we try to make query in database)
        $name = str_replace("'", '', $name);
        //check if the store already exists in our database
        $condition = array_search($name, $existing_stores);
        $name = "'" . $name . "'";
        $tspend = 0;

        /*
         * The array_search function it will return a boolean value(false)
         * if it does not find the current id in the existing_id array
        */
        if (gettype($condition) == 'boolean') {
            $temp = array('name' => $name, 'time_spend' => $tspend, 'address' => $address, 'lng' => $lng, 'lat' => $lat, 'type' => $type_array);
            array_push($param_array, $temp);
        }
    }

    // Check if there are duplicate rows in param_array
    echo "size of before unique: ".sizeof($param_array)."\n";
    $param_array = unique_multidim_array($param_array, 'name');

     echo "size of after unique: ".sizeof($param_array)."\n";

    foreach ($param_array as $i) {
        $params_query .= "(" . join(",", $i) . "),";
    }
    //Remove the last comma from query
    $params_query = rtrim($params_query, ",");

    $sql = "INSERT INTO  store (name_store,time_spent,store_add,longitude,latitude,type_store)VALUES $params_query";
    echo "\n \n";
    echo $sql;
    if ($params_query != "") {
        mysqli_query($conn, $sql);
    }
    else
    {
        echo "\n \n";
        echo "already existing stores";
    }

    mysqli_close($conn);

}
function bulk_insert_popular_times($filename, bool $use_path=false)
{
    // Create connection
    $conn = new mysqli("localhost", "root", "", "project_web");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $array_existing_id= array();
    $r=mysqli_query($conn,"SELECT id_of_store FROM popular_times");
    while ($row=mysqli_fetch_assoc($r))
    {
        array_push($array_existing_id,$row['id_of_store']);
    }

    //Get the contents of the jsonfile
    $jsonfile = file_get_contents($filename, $use_path);
    $obj = json_decode($jsonfile);
    $query_params="";
    for ($i = 0; $i < sizeof($obj); $i++)
    {
        //remove single quote(throw an error when we try to make query in database)
        $name = str_replace("'", '', ($obj[$i])->name);
        $popular_object=($obj[$i])->populartimes;
        $date=array_hours_per_day($popular_object);
        echo "\n";
        $result=mysqli_query($conn,"Select store_id from store where name_store like '%$name%' ");
        if(mysqli_num_rows($result)==1)
        {
            echo" I have result!\n";
            while($row=mysqli_fetch_assoc($result))
            {
                //search if already have data in populartimes for a given store
                $condition = array_search($row['store_id'], $array_existing_id);
                echo $condition;
                if (gettype($condition) == 'boolean')
                {
                    $query_params .= bulk_popular_times_sql($date, $row['store_id']);
                }
            }

        }

    }

    $query_params=rtrim($query_params,",");
    echo $query_params;

    $sql="INSERT INTO popular_times(date, id_of_store, h1, h2, h3, h4, h5, h6, h7, h8, h9, h10, h11, h12, h13, h14, h15, h16, h17, h18, h19, h20, h21, h22, h23) VALUES $query_params";

    if($query_params!="")
    {
        mysqli_query($conn,$sql);
    }
    mysqli_close($conn);
}

//https://www.php.net/manual/en/function.array-unique.php#116302
function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

function array_hours_per_day($popular_times)
{
    $string_popular_encode=json_encode($popular_times);
    $decode_populatimes=json_decode($string_popular_encode);
    $dates= array();
    for($i=0;$i<7;$i++)
    {
        $array_hours= array();
        for($j=0;$j<23;$j++)
        {
            array_push($array_hours,($decode_populatimes[$i])->data[$j]);
        }
        array_push($dates,$array_hours);
    }


    return $dates;
}
function bulk_popular_times_sql($dates, $id)
{
    $temp='';
    for($i=0; $i<sizeof($dates); $i++)
    {

        $date=$i+1;
        $temp.="("."$date,"."$id,".join(",",$dates[$i])."),";

    }

    return $temp;
}