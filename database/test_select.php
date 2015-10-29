<?php
require_once('..\utilities\functions.php');
header('Access-Control-Allow-Origin: *');
$where = $_get();
// List fields or define field as NULL
$fields = array("namelast", "namefirst", "email");
//$fields = null;

$response = select_from_table('person', $fields, $where);

echo ($response);
?>