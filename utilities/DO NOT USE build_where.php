<?php

if ($where <> '') {
  $where .= ' and ';
	}

$pos = strpos($var, "%");
 if ($pos === false) {
     $cond = ' = ';
  	}
 else {
      $cond = ' like ';
     }
$var = "'{$var}'"; 
$where .= $field.$cond.$var;

?>