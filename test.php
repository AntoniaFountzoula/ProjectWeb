<?php

// Create connection
$conn = new mysqli("localhost", "root", "", "project_web");


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$jsonfile = file_get_contents('./Database/b37e935e/generic.json', true);
$obj = json_decode($jsonfile,true);
$test_day=array();

echo $obj['0']['populartimes']['0' ]['name'];
/*for ($i=0; $i < sizeof($obj); $i++) {
    echo$i;
    for($j=0; $j<7; $j++){
        echo $j;
        $obj["'$i'"]['populartimes']["'$j'"]['data']['0'];

    }

}
*/

$obj1_not_associative = json_decode($jsonfile);
$temp_populartimes_array=($obj1_not_associative[0])->populartimes;
$string1_popular_encode=json_encode($temp_populartimes_array);
echo $string1_popular_encode."\n";
$decode1_populatimes=json_decode($string1_popular_encode);
$names= array();

for($i=0; $i<7; $i++)
{
    array_push($names,($decode1_populatimes[$i])->name);

}
echo join(", ",$names)."\n";

$obj_not_associative = json_decode($jsonfile);
$temp1_populartimes_array=($obj_not_associative[0])->populartimes;
$string_popular_encode=json_encode($temp1_populartimes_array);
echo $string_popular_encode."\n";
$decode_populatimes=json_decode($string_popular_encode);
$name= array();
for($i=0;$i<7;$i++)
{
    for($j=0;$j<23;$j++){
    array_push($name,($decode_populatimes[$i])->data[$j]);}

}

echo join(", ",$name)."\n";



