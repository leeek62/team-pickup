<?php
header('Access-Control-Allow-Origin: *');
if (!isset($con)) {
  $host="localhost";
  $port=3306;
  $socket="";
  $user="root";
  $password="";
  $dbname="teampickup";
  $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
	     or die ('Could not connect to the database server' . mysqli_connect_error());    
}
?>







