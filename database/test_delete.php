<?php
require_once('..\utilities\functions.php');

//  Define Table
$table = 'person';
$email = $_POST['email'];

//Build Fields and Values to insert
$record  = array();
$record = add_where("email", $email, $record);

delete_from_table($table, $record);

?>