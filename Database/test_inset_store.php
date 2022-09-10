<?php
function bulk_insert_stores($filename,bool $use_path=false)
{
    // Create connection
    $conn = new mysqli("localhost", "root", "", "project_web");


    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // it will contain the ids for existing stores
    $existing_id = array();

    //Get the contents of the jsonfile
    $jsonfile = file_get_contents($filename, $use_path);
    $obj = json_decode($jsonfile);

    //Get the ids for existing stores from database
    $ids = mysqli_query($conn, "SELECT store_id,name_store FROM store");
    while ($row = mysqli_fetch_assoc($ids)) {
        echo $row['name_store'];
        echo " ";
        echo $row['store_id'];
        echo "\n\n";
        array_push($existing_id, $row['store_id']);

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
        $id = "'" . ($obj[$i])->id . "'";
        //convert type (type is an array field)into a string
        $type_array = join(" ", ($obj[$i])->types);
        $type_array = "'" . $type_array . "'";


        //remove single quote(throw an error when we try to make query in database)
        $name = str_replace("'", '', $name);
        $name = "'" . $name . "'";
        $tspend = 0;
        //check if the store already exists in our database
        $condition = array_search(($obj[$i])->id, $existing_id);
        /*
         * The array_search function it will return a boolean value(false)
         * if it does not find the current id in the existing_id array
        */
        if (gettype($condition) == 'boolean') {
            $temp = array('id' => $id, 'name' => $name, 'time_spend' => $tspend, 'address' => $address, 'lng' => $lng, 'lat' => $lat, 'type' => $type_array);
            array_push($param_array, $temp);
        }
    }

    // Check if there are duplicate rows in param_array
    #echo "size of before unique: ".sizeof($param_array)."\n";
    $param_array = unique_multidim_array($param_array, 'id');

    # echo "size of after unique: ".sizeof($param_array)."\n";

    foreach ($param_array as $i) {
        $params_query .= "(" . join(",", $i) . "),";
    }
    //Remove the last comma from query
    $params_query = rtrim($params_query, ",");

    $sql = "INSERT INTO store VALUES $params_query";
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