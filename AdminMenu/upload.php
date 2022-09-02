<?php

if (file_exists("uploads/".$_FILES["file"]["name"]))
{
	echo "<script> window.alert('The file already exists.' ); window.location.href='index.php';</script>" ;
}
else
{
	move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/".$_FILES["file"]["name"]);
	echo "<script> window.alert('Stored'); window.location.href='index.php';</script>" ;

}

//var_dump($_FILES);


?> 