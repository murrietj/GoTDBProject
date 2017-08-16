<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
if(!$_POST['FName'] == ""){
  $mysqli = new mysqli("oniddb.cws.oregonstate.edu","fatehie-db","IuBhtRIUUdodcvXy","fatehie-db");
  if(!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
  }

  if(!($stmt = $mysqli->prepare("UPDATE characters SET first_name=?, last_name=?, gender=?, house=? WHERE id=?"))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }

  if($_POST['LName'] == "")
    $_POST['LName'] = NULL;
  if($_POST['House'] == -1)
    $_POST['House'] = NULL;

  if(!($stmt->bind_param("sssii",$_POST['FName'],$_POST['LName'],$_POST['Gender'],$_POST['House'],$_POST['Character']))){
    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!$stmt->execute()){
    echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
  } else {
    echo "Updated " . $stmt->affected_rows . " rows from characters.";
  }
}
else {
  echo "First name cannot be empty";
}
?>
