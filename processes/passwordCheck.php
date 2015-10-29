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
  $params = add_where('email', $email, $params = array());
  $response = select_from_table('person', 'idPerson', $params);
  $response = json_decode($response, true);
  if (!empty($response)) {
    $id = $response[0]['idPerson'];
  }
}

//If ID is not set, then exit with message
if (!isset($id)) {
  echo "E-Mail $email does not exist";
}

//Get current password
$params = add_where('idPerson', $id, $params = array());
$response = select_from_table('password', 'password', $params);
$response = json_decode($response, true);
if (!empty($response)) {
    $oldPassword = $response[0]['password'];
}
else {
  echo "Password was never set";
}
//Validate the password
$valid = validatePassword($oldPassword, $password, $id);
//echo 'The validation is: '.$valid;
return $valid;

?>