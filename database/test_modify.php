<?php
require_once('..\utilities\functions.php');
header('Access-Control-Allow-Origin: *');

//  Define Table
$table = 'person';

//Build Fields and Values to insert
$update  = array();
$where   = array();

//Fields with new values
$update = add_field("address1", "1220 Topeka Ice Cream Lane", $update);
//Table selection for the record(s) to be updated
$where = add_where("nameLast", "Lee", $where);

//echo json_encode($update). "<br>";
modify_record($table, $update, $where);

?>