<?php

require_once('mysqli_connect.php');

if (is_null($fields) === 'true') {
	$fields = "*";
}

if(is_null($where) === 'false') {
$query = "SELECT $fields FROM $table WHERE $where";
}
else {
$query = "SELECT $fields FROM $table";
}
$response = @mysqli_query($con, $query);

$emparray[] = array();
if($response){
	while($row = mysqli_fetch_array($response)){
		$emparray[] = $row;
	}
	$response = json_encode($emparray);
}
else {
echo ("Could not issue database query");

echo mysqli_error($con);
}

// Close connection to the database
mysqli_close($con);

?>