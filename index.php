<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","fatehie-db","IuBhtRIUUdodcvXy","fatehie-db");
if($mysqli->connect_errno){
  echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <body>
    <div>
      <table>
        <tr>
          <th>Characters</th>
        </tr>
        <tr>
          <td>First Name</td>
          <td>Last Name</td>
          <td>House</td>
        </tr>

<?php
if(!($stmt = $mysqli->prepare("SELECT characters.first_name, characters.last_name, house.name FROM characters INNER JOIN house ON characters.house = house.id"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($first_name, $last_name, $house)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<tr>\n<td>\n" . $first_name . "\n</td>\n<td>\n" . $last_name . "\n</td>\n<td>\n" . $house . "\n</td>\n</tr>";
}
$stmt->close();
?>

      </table>
    </div>

    <div>
      <fieldset>
        <legend>Character</legend>
        <fieldset>
          <legend>Add</legend>
          <form method="post" action="addChar.php"> 
            <p>First Name: <input type="text" name="FirstName" /></p>
            <p>Last Name: <input type="text" name="LastName" /></p>
            <p>House: <select name="House">

<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM house"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $pname)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo '<option value=" '. $id . ' "> ' . $pname . '</option>\n';
}
$stmt->close();
?>

            </select></p>
            <p><input type="submit" value="Add"/></p>
          </form>
        </fieldset>
        
        <fieldset>
          <legend>Update</legend>
          <form method="post" action="updateChar.php"> 
            <p>Character: <select name="Character">

<?php
if(!($stmt = $mysqli->prepare("SELECT id, first_name, last_name FROM characters"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $fname, $lname)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo '<option value=" '. $id . ' "> ' . $fname . ' ' . $lname . '</option>\n';
}
$stmt->close();
?>

            </select></p>
            <p>First Name: <input type="text" name="FirstName" /></p>
            <p>Last Name: <input type="text" name="LastName" /></p>
            <p>House: <select name="House">

<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM house"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $pname)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo '<option value=" '. $id . ' "> ' . $pname . '</option>\n';
}
$stmt->close();
?>

            </select></p>
            <p><input type="submit" value="Update" /></p>
          </form>
        </fieldset>

        <fieldset>
          <legend>Delete</legend>
          <form method="post" action="deleteChar.php"> 
            <p>Character: <select name="Character">

<?php
if(!($stmt = $mysqli->prepare("SELECT id, first_name, last_name FROM characters"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $fname, $lname)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo '<option value=" '. $id . ' "> ' . $fname . ' ' . $lname . '</option>\n';
}
$stmt->close();
?>

            </select></p>
            <p><input type="submit" value="Delete" /></p>
          </form>
        </fieldset>
        
      </fieldset>
    </div>	
  </body>
</html>
