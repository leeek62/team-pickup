<?php
require_once('..\utilities\functions.php');

//  Define Table
$table = 'person';

//Build Fields and Values to insert
$record  = array();
$records = array();
$record = add_field("nameLast", "Lee", $record);
$record = add_field("nameFirst", "Susan", $record);
$record = add_field("nameNick", "Sue", $record);
$record = add_field("email", "swl@lovegodwithall.net", $record);
$record = add_field("address1", "1224 Topeka Drive", $record);
$record = add_field("zip", "76131", $record);
$record = add_field("phone", "8176920840", $record);
$record = add_field("sex", "F", $record);
$record = add_field("birthdate", "19620311", $record);
$record = add_field("mileRange", "25", $record);
array_push($records, $record);
$record = array(); //clear array for record
$record = add_field("nameLast", "Lee", $record);
$record = add_field("nameFirst", "Aaron", $record);
$record = add_field("nameNick", "Fluffy", $record);
$record = add_field("email", "aarontlee@yahoo.com", $record);
$record = add_field("address1", "1224 Topeka Drive", $record);
$record = add_field("zip", "76131", $record);
$record = add_field("phone", "8176920000", $record);
$record = add_field("sex", "M", $record);
$record = add_field("birthdate", "19960101", $record);
$record = add_field("mileRange", "15", $record);
array_push($records, $record);

//echo json_encode($records). "<br>";
insert_into_table($table, $records);

//$response = select_from_table('person', $fields, $where);

//echo ($response);
?>