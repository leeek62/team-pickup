<?php
require_once('..\utilities\functions.php');
header('Access-Control-Allow-Origin: *');
//these are the input parameters needed
//$email = 'david.smith@me.com';
//$password = 'mypassword';

$email = $_POST["email"];
$namefirst = $_POST["namefirst"];
$namelast = $_POST["namelast"];
$sex = $_POST["sex"];

//First, check if user already exists
$table = 'person';
$where = add_where("email", $email, $where = array());
$fields = array("namelast", "namefirst");
$response = select_from_table($table, $fields, $where);

// Then add the user to the person table with only the e-mail address
if (!empty($response)) {
  $record  = array();
  $records = array();
  $record  = add_field("email", $email, $record);
  $record  = add_field("nameFirst", $namefirst, $record);
  $record  = add_field("nameLast", $namelast, $record);
  $record  = add_field("sex", $sex, $record);
  array_push($records, $record);
  insert_into_table($table, $records);
  // Then select the unique ID that was created in previous step
  unset($where);
  unset($fields);
  unset($response);
  $where = add_where("email", $email, $where = array());
  $fields = array("namelast", "namefirst");
  $response = select_from_table($table, $fields, $where);
  // Now add the password to the password table with unique ID assigned

}
else {    //only update password
  echo 'user exists'.json_encode($response);
}


?>