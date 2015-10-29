<?php
require_once('..\utilities\functions.php');
header('Access-Control-Allow-Origin: *');

$where = array();
$table = null;
$fields = "all";


while($value = current($_GET)) {
  $key = key($_GET);
  switch ($key) {
  	case 'table':
  	  $table = $value;
  	  break;
  	case 'fields':
  	  $fields = $value;
  	  break;
  	default:
	  $where = add_where($key, $value, $where); 	
	  break; 
  }  
  next($_GET);
}
$response = select_from_table($table, $fields, $where);
echo ($response);
?>