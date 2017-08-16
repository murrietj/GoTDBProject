<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","fatehie-db","IuBhtRIUUdodcvXy","fatehie-db");
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
if(!($stmt = $mysqli->prepare("INSERT INTO characters(first_name, last_name, gender, house) VALUES (?,?,?,?)"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if($_POST['FirstName'] == "")
  $_POST['FirstName'] = NULL;
if($_POST['LastName'] == "")
  $_POST['LastName'] = NULL;
if($_POST['House'] == -1)
  $_POST['House'] = NULL;

if(!($stmt->bind_param("sssi",$_POST['FirstName'],$_POST['LastName'],$_POST['Gender'], $_POST['House']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Added " . $stmt->affected_rows . " rows to characters.";
}
?>
