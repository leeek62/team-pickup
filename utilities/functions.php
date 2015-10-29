<?php
header('Access-Control-Allow-Origin: *');
//add to your file for these functions require_once('..\utilities\functions.php');

function to_boolian($num)
{
    if ($num = 0) { 
      $bool = 'true';
  	}
    else {;
      $bool = 'false';
    };
}

function from_boolian($bool)
{
    if ($bool = 'true') { 
      $num = 0;
  	}
    else {;
      $num = 1;
    };
}

function encryptPassword($password) {
  // A higher "cost" is more secure but consumes more processing power
  $cost = 10;

  // Create a random salt
  $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
  
  // Prefix information about the hash so PHP knows how to verify it later.
  // "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
  $salt = sprintf("$2a$%02d$", $cost) . $salt;

// Hash the password with the salt
  $hash = crypt($password, $salt);
  return $hash;
}

function validatePassword($encOldPassword, $newPassword, $id) {
  //First check if user is locked
  $params = add_where('idPerson', $id, $params = array());
  $params = add_where('locked', '1', $params;
  $response = select_from_table('password', 'password', $params);
  $response = json_decode($response, true);
  if (!empty($response)) {
      return false;
  }
  
  // Hashing the password with its hash as the salt returns the same hash
  $hashOld = $encOldPassword;
  $hashNew = crypt($newPassword, $encOldPassword);
  if(strlen($hashOld) != strlen($hashNew)) {
      $check = false;
  } 
  else {
    $res = $hashOld ^ $hashNew;
    $ret = 0;
    for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
    $check = !$ret;
  }
  if ($check == false) {
  //increment the misses variable
    include('..\utilities\mysqli_connect.php');
    $query = "UPDATE password SET misses = misses + 1 WHERE idPerson = $id";
    //echo $query;
    if ($con->query($query) === TRUE) {
      echo "Added failed attempt count";
    } 
    else {
      echo "Error: " . $query . "<br>" . $con->error;
    }
// Update locked if 5 or more failed attempts
    $query = "UPDATE password SET misses = '0', locked = '1' WHERE idPerson = $id and misses > '4'"; 
    if ($con->query($query) === TRUE) {
    //  echo "Locked User";
    } 
    else {
      echo "Error: " . $query . "<br>" . $con->error;
    }
  }
  return $check;
}  

function get_variable($field, $get = array()) {
  while($value = current($get)) {
    if (key($get) == $field) {
      return $value;
      break;
    }
    next($get);
  }
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function add_where($field, $value, $where = array()) {
  $row = array('field' => $field, 'value' => $value);
  array_push($where, $row);
  return $where;
}

function add_field($field, $value, $fields = array()) {
  $row = array('field' => $field, 'value' => $value);
  array_push($fields, $row);
  return $fields;
}

function build_where($params = array()) {
  $where = null;
  $keys = array_keys($params);
  for($i = 0; $i < count($params); $i++) {
    $param = array($params[$i]);
    if (isset($where)) {
      $where .= ' and ';
    }
    $field = $params[$i]["field"];
    $value = $params[$i]["value"];
    $pos = strpos($value, "%");
    if ($pos === false) {
      $cond = ' = ';
    }
    else {
      $cond = ' like ';
    }
    $value = '"'.$value.'"';

    if (isset($where)) {
      $where .= $field.$cond.$value;
    }
    else {
      $where = $field.$cond.$value;
    }
  }
  return $where;
}

function build_update_fields($params = array()) {
  $list = null;
  $keys = array_keys($params);
  for($i = 0; $i < count($params); $i++) {
    $param = array($params[$i]);
    if (isset($list)) {
      $list .= ', ';
    }
    $field = $params[$i]["field"];
    $value = $params[$i]["value"];
    $pos = strpos($value, "%");
    if ($pos === false) {
      $cond = ' = ';
    }
    else {
      $cond = ' like ';
    }
    $value = '"'.$value.'"';

    if (isset($list)) {
      $list .= $field.$cond.$value;
    }
    else {
      $list = $field.$cond.$value;
    }
  }
  return $list;
}
function select_from_table($table = '', $fields, $params = array()) {
  include('..\utilities\mysqli_connect.php');
// build list of fields into a string
  unset($field_list);
  if ($fields == "all") {
    $field_list = '*';
  }
  else {
    $field_list = $fields;
  }
// build parameters into where statement
  $where = build_where($params);
// Execute Selection
  if(isset($where)) {
    $query = "SELECT $field_list FROM $table WHERE $where";
  }
  else {
    $query = "SELECT $field_list FROM $table";
  }
  $response = @mysqli_query($con, $query);
//Convert to JSON
  $temparray = array();
  //echo json_encode($response). "<br>";
  //echo $query. "<br>";
  if($response){
    while($row = mysqli_fetch_assoc($response)){
      $temparray[] = $row;
    }
    $response = json_encode($temparray);
    return $response;
  }
  else {
//Failed
    echo ("Could not issue database query");
    echo mysqli_error($con);
  }
  //$con->close();
}

function insert_into_table($table, $records = array()) {
  include('..\utilities\mysqli_connect.php');
// Build Field list and value list and insert 1 record at a time
//  $keys = array_keys($records);
  //echo json_encode($records);
  for($i = 0; $i < count($records); $i++) {
    $fields = null;
    $values = null;
    for($a = 0; $a < count($records[$i]); $a++) {
      $field = $records[$i][$a]["field"];
      $value = $records[$i][$a]["value"];
      if (isset($fields)) {
        $fields .= ", ". $field;
        $values .= ', "'. $value. '"';
      }
      else {
        $fields = $records[$i][$a]["field"];
        $values = '"'. $records[$i][$a]["value"]. '"';
      }
    }
// Build Insert single record statement
    $insert = "INSERT INTO $table ($fields) VALUES ($values)";
    //echo $insert;
    if ($con->query($insert) === TRUE) {
      echo "New record created successfully";
    } 
    else {
      echo "Error: " . $insert . "<br>" . $con->error;
    }
  }
  //$con->close();
}

function delete_from_table($table, $params = array()) {
  include('..\utilities\mysqli_connect.php');
// build parameters into where statement
  $where = build_where($params);
  // Only execute if where is populated...do not every delete whole table content
  if(isset($where)) {
    $delete = "DELETE FROM $table WHERE $where";
    //echo $delete;
    if ($con->query($delete) === TRUE) {
      echo "Records Deleted";
    } 
    else {
      echo "Error: " . $delete . "<br>" . $con->error;
    }
  }
  $con->close();
}

function modify_record($table, $update = array(), $params = array()) {
  include('..\utilities\mysqli_connect.php');
// This funciton assumes only 1 record (or set of parameters) is modified at a time  
  $where = build_where($params);
  $fields = null;
  $values = null;
  // Only execute if where is populated...do not every delete whole table content
  if(isset($where)) {
    // Build field and value list in the "Set" section
    $fields = build_update_fields($update);
    //echo json_encode($update). "<br>";
    //Build mySql Query for modify
    $modify = "UPDATE $table SET $fields WHERE $where";
    //echo $modify;
    if ($con->query($modify) === TRUE) {
      echo "Records Modified";
    } 
    else {
      echo "Error: " . $modify . "<br>" . $con->error;
    }
  }
  $con->close();
}
?>