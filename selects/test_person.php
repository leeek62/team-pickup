<?php
require_once('..\utilities\functions.php');

//Build where statement.  This is an AND
$where = add_where("sex", "M", $where = array());
$where = add_where("namelast", "Smith", $where = array());

// List fields or define field as NULL
$fields = array("namelast", "namefirst", "birthdate");
//$fields = null;

$response = select_from_table('person', $fields, $where);

echo ($response);
?>