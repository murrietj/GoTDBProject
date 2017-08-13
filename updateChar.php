<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","fatehie-db","IuBhtRIUUdodcvXy","fatehie-db");
if(!$mysqli || $mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	
if(!($stmt = $mysqli->prepare("UPDATE characters SET first_name=?, last_name=?, house=? WHERE id=?"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!($stmt->bind_param("ssii",$_POST['FirstName'],$_POST['LastName'],$_POST['House'],$_POST['Character']))){
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
} else {
	echo "Updated " . $stmt->affected_rows . " rows from characters.";
}
?>
