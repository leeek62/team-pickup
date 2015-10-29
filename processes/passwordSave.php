<?php
require_once('..\utilities\functions.php');
include('..\utilities\mysqli_connect.php');
header('Access-Control-Allow-Origin: *');

// Get User ID.  Either passed as the ID or pass as email
//If email, then get ID

$id       = get_variable('idPerson', $_GET);
$email    = get_variable('email', $_GET);
$password = get_variable('password', $_GET);

//If no password provided, then exit
if (!isset($password)) {
  echo "No Password";
  return("No Password provided for $email try again");
}


//If ID is not set and e-mail is set then get ID
if (!isset($id) and isset($email)) {
  //echo $email;
  $params = add_where('email', $email, $params = array());
  $response = select_from_table('person', 'idPerson', $params);
  //echo $response;
  $response = json_decode($response, true);
  if (!empty($response)) {
    $id = $response[0]['idPerson'];
  }
}

//If ID is not set, then exit with message
if (!isset($id)) {
  echo "E-Mail $email does not exist";
}
//echo $id;
//Hash the password provided
$hash = encryptPassword($password);

//Save new password for user
//If already exists, then update password and if not insert record
$params = array();
$response = null;
$params = add_where('idPerson', $id, $params);
$response = select_from_table('password', 'idPerson', $params);
//echo $response;
if (empty(json_decode($response, true))) {
  //Insert
  $record = array();
  $records = array();
  $record = add_field('idPerson', $id, $record);
  $record = add_field('password', $hash, $record);
  $record = add_field('misses', "0", $record);
  $record = add_field('locked', "0", $record);
  array_push($records, $record);
  insert_into_table('password', $records);
}
else {
  //Modify
  $update  = array();
  $where   = array();
  $update  = add_field("password", $hash, $update);
  $update  = add_field("misses", "0", $update);
  $update  = add_field("locked", "0", $update);
  $where   = add_where("idPerson", $id, $where);
  modify_record('password', $update, $where);
}
?>