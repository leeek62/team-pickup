<?php
header('Access-Control-Allow-Origin: *');
$table = "person";
$fields = "*";
$where = '';

if (isset($namelast)) {
  $var = $namelast;
  $field = 'namelast';
  include ('../utilities/build_where.php');	
}

if (isset($namefirst)) {
  $var = $namefirst;
  $field = 'namefirst';
  include ('../utilities/build_where.php');	
}

if (isset($namenick)) {
  $var = $namenick;
  $field = 'namenick';
  include ('../utilities/build_where.php');		
}

if (isset($email)) {
  $var = $email;
  $field = 'email';
  include ('../utilities/build_where.php');		
}

if (isset($sex)) {
  $var = $sex;
  $field = 'sex';
  include ('../utilities/build_where.php');		
}
include ('../utilities/select.php');
$person = $response;
echo $response;

?>