<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","fatehie-db","IuBhtRIUUdodcvXy","fatehie-db");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
  <meta charset="utf-8">
  <title>Filtered Characters</title>
  <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<div>
	<table>
		<caption>Filtered Characters</th>
        <thead>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>House</th>
          </tr>
        </thead>
        <tbody>
<?php
//initialize select query select query
$select_query="SELECT first_name, last_name, gender, h.name FROM characters c LEFT JOIN house h ON c.house = h.id";

//bind appropriate parameters
if($_POST['lname']!="*"){
  $select_query = $select_query . " WHERE last_name=?";

  if($_POST['gender']!="*"){
    $select_query = $select_query . " AND gender=?";

    if($_POST['house']!="*"){  //no any's
      $select_query = $select_query . " AND h.id=?";

      if(!($stmt = $mysqli->prepare($select_query))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
      }

      if(!($stmt->bind_param("ssi",$_POST['lname'],$_POST['gender'],$_POST['house']))){
        echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
      }
    }
    else{ //house is any
      if(!($stmt = $mysqli->prepare($select_query))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
      }

      if(!($stmt->bind_param("ss",$_POST['lname'],$_POST['gender']))){
        echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
      }
    }
  }
  else if($_POST['house']!="*"){ //gender is any
    $select_query = $select_query . " AND h.id=?";

    if(!($stmt = $mysqli->prepare($select_query))){
      echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!($stmt->bind_param("si",$_POST['lname'],$_POST['house']))){
      echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }
  }
  else{ //gender and house are any
    if(!($stmt = $mysqli->prepare($select_query))){
      echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!($stmt->bind_param("s",$_POST['lname']))){
      echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }
  }
}
else if($_POST['gender']!="*"){
  $select_query = $select_query . " WHERE gender=?";

  if(!$_POST['house']="*"){ //lname is any
    $select_query = $select_query . " AND h.id=?";

    if(!($stmt = $mysqli->prepare($select_query))){
      echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!($stmt->bind_param("si",$_POST['gender'],$_POST['house']))){
      echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }
  }
  else{ //lname and house are any
    if(!($stmt = $mysqli->prepare($select_query))){
      echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }

    if(!($stmt->bind_param("s",$_POST['gender']))){
      echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }
  }
}
else if($_POST['house']!="*"){  //lname and gender are any
  $select_query = $select_query . " WHERE house=?";

  if(!($stmt = $mysqli->prepare($select_query))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }

  if(!($stmt->bind_param("i",$_POST['house']))){
    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
  }
}
else{
  if(!($stmt = $mysqli->prepare($select_query))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($fname, $lname, $gender, $house)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  if(is_null($lname))
    $lname="N/A";
  if(is_null($house))
    $house="N/A";

  echo "<tr>\n<td>\n" . $fname . "\n</td>\n<td>\n" . $lname . "\n</td>\n<td>\n" . $gender . "\n</td>\n<td>\n" . $house ."\n</td>\n</tr>";
}
$stmt->close();
?>
	</table>
</div>

</body>
</html>
