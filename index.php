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
  <head>
    <meta charset="utf-8">
    <title>GoT DB Project</title>
    <link rel="stylesheet" href="style.css" type="text/css">
  </head>
  <body>
    <fieldset id="CharacterFS">
      <table>
        <caption>Characters</th>
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
if(!($stmt = $mysqli->prepare("SELECT first_name, last_name, gender, name FROM characters
								INNER JOIN house ON characters.house = house.id"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($first_name, $last_name, $gender, $house)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

while($stmt->fetch()){
  echo "<tr>\n<td>" . $first_name . "</td>\n<td>" . $last_name . "</td>\n<td>" . $gender . "</td>\n<td>" . $house . "</td>\n</tr>\n";
}
$stmt->close();
?>

        </tbody>
      </table>
      <fieldset>
        <legend>Add</legend>
        <form method="post" action="addChar.php"> 
          <p>First Name: <input type="text" name="FirstName" /></p>
          <p>Last Name: <input type="text" name="LastName" /></p>
          <p>Gender: <select name="Gender">
              <option value="M">Male</option>
              <option value="F">Female</option>
          </select></p>
          <p>House: <select name="House">

<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM house"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $name)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<option value='". $id . "'>". $name . "</option>\n";
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
  echo "<option value='". $id . "'>" . $fname . " " . $lname . "</option>\n";
}
$stmt->close();
?>

          </select></p>
          <p>First Name: <input type="text" name="FirstName" /></p>
          <p>Last Name: <input type="text" name="LastName" /></p>
          <p>Gender: <select name="Gender">
              <option value="M">Male</option>
              <option value="F">Female</option>
          </select></p>

          <p>House: <select name="House">

<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM house"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $name)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<option value='". $id . "'>" . $name . "</option>\n";
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
  echo "<option value='". $id . "'>" . $fname . " " . $lname . "</option>\n";
}
$stmt->close();
?>

          </select></p>
          <p><input type="submit" value="Delete" /></p>
        </form>
      </fieldset>

    </fieldset>
  
  <fieldset id="MarriagesFS">
      <table>
        <caption>Marriages</caption>
        <thead>
          <tr>
            <th>Husband</th>
            <th>Wife</th>
          </tr>
        </thead>
        <tbody>

<?php
if(!($stmt = $mysqli->prepare("SELECT h.first_name, h.last_name, w.first_name, w.last_name FROM marriages m
                              INNER JOIN characters h ON m.husband_id = h.id
                              INNER JOIN characters w ON m.wife_id = w.id"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($h_fname, $h_lname, $w_fname, $w_lname)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<tr>\n<td>" . $h_fname . " " . $h_lname . "</td>\n<td>" . $w_fname . " " . $w_lname . "</td>\n</tr>\n";
}
$stmt->close();
?>

        </tbody>
      </table>
      <fieldset>
        <legend>Add</legend>
        <form method="post" action="addMarriage.php"> 
          <p>Husband: <select name="husband">

<?php
if(!($stmt = $mysqli->prepare("SELECT id, first_name, last_name FROM characters WHERE gender='M'"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $fname, $lname)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<option value='". $id . "'>". $fname . " " . $lname . "</option>\n";
}
$stmt->close();
?>

          </select></p>
          <p>Wife: <select name="wife">

<?php
if(!($stmt = $mysqli->prepare("SELECT id, first_name, last_name FROM characters WHERE gender='F'"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $fname, $lname)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<option value='". $id . "'>" . $fname . " " . $lname . "</option>\n";
}
$stmt->close();

?>

          </select></p>
          <p><input type="submit" value="Add"/></p>
        </form>
      </fieldset>

      <fieldset>
        <legend>Delete</legend>
        <form method="post" action="deleteMarriage.php"> 
          <p>Marriage: <select name="marriage">

<?php
if(!($stmt = $mysqli->prepare("SELECT m.id, h.first_name, h.last_name, w.first_name, w.last_name FROM marriages m
                              INNER JOIN characters h ON m.husband_id = h.id
                              INNER JOIN characters w ON m.wife_id = w.id"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $h_fname, $h_lname, $w_fname, $w_lname)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<option value ='" . $id . "'>" . $h_fname . " " . $h_lname . " & " . $w_fname . " " . $w_lname . "</option>\n";
}
$stmt->close();
?>

          </select></p>
          <p><input type="submit" value="Delete" /></p>
        </form>
      </fieldset>

  </fieldset>

    <fieldset id="HouseFS">
      <table>
        <caption>Houses</caption>
        <thead>
          <tr>
            <th>Name</th>
            <th>Sigil</th>
            <th>Region</th>
          </tr>
        </thead>
        <tbody>

<?php
if(!($stmt = $mysqli->prepare("SELECT house.name, house.sigil, region.name FROM house INNER JOIN region ON house.region = region.id"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($name, $sigil, $region)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<tr>\n<td>" . $name . "</td>\n<td>" . $sigil . "</td>\n<td>" . $region . "</td>\n</tr>\n";
}
$stmt->close();
?>

        </tbody>
      </table>
      <fieldset>
        <legend>Add</legend>
        <form method="post" action="addHouse.php"> 
          <p>Name: <input type="text" name="name" /></p>
          <p>Sigil: <input type="text" name="sigil" /></p>
          <p>Region: <select name="region">

<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM region"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $name)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<option value='". $id . "'>". $name . "</option>\n";
}
$stmt->close();
?>

          </select></p>
          <p><input type="submit" value="Add"/></p>
        </form>
      </fieldset>
    </fieldset>

    <fieldset id="RegionFS">
      <table>
        <caption>Regions</caption>
        <thead>
          <tr>
            <th>Name</th>
			<th>Capital</th>
          </tr>
        </thead>
        <tbody>

<?php
if(!($stmt = $mysqli->prepare("SELECT name, capital FROM region"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($name, $capital)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<tr>\n<td>" . $name . "</td>\n<td>" . $capital . "</td>\n</tr>\n";
}
$stmt->close();
?>

        </tbody>
      </table>
      <fieldset>
        <legend>Add</legend>
        <form method="post" action="addRegion.php"> 
          <p>Region name: <input type="text" name="name" /></p>
		  <p>Capital: <input type="text" name="capital" /></p>
          <p><input type="submit" value="Add"/></p>
        </form>
      </fieldset>

  
	<fieldset>
        <legend>Update</legend>
        <form method="post" action="updateRegion.php"> 
          <p>Region name: <select name="regionName">

<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM region"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $rname)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<option value='". $id . "'>" . $rname . "</option>\n";
}
$stmt->close();
?>

          </select></p>
          <p>Capital: <input type="text" name="capital" /></p>

          </select></p>
          <p><input type="submit" value="Update" /></p>
        </form>
      </fieldset>
	  
	  <fieldset>
        <legend>Delete</legend>
        <form method="post" action="deleteRegion.php"> 
          <p>Region name: <select name="name">

<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM region"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $name)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<option value='". $id . "'>" . $name . "</option>\n";
}
$stmt->close();
?>

          </select></p>
          <p><input type="submit" value="Delete" /></p>
        </form>
      </fieldset>
	</fieldset>

  <fieldset id="ReligionFS">
      <table>
        <caption>Religions</caption>
        <thead>
          <tr>
            <th>Name</th>
          </tr>
        </thead>
        <tbody>

<?php
if(!($stmt = $mysqli->prepare("SELECT name FROM religion"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($name)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<tr>\n<td>" . $name . "</td>\n</tr>\n";
}
$stmt->close();
?>

        </tbody>
      </table>
      <fieldset>
        <legend>Add</legend>
        <form method="post" action="addReligion.php"> 
          <p>Name: <input type="text" name="name" /></p>
          <p><input type="submit" value="Add"/></p>
        </form>
      </fieldset>
  </fieldset>

  <fieldset id="RegRelFS">
      <table>
        <caption>Religions found in Regions</caption>
        <thead>
          <tr>
            <th>Region</th>
            <th>Religion</th>
          </tr>
        </thead>
        <tbody>

<?php
if(!($stmt = $mysqli->prepare("SELECT reg.name, rel.name FROM region_religion rr
                              INNER JOIN region reg ON rr.region_id = reg.id
                              INNER JOIN religion rel ON rr.religion_id = rel.id"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($region, $religion)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<tr>\n<td>" . $region . "</td>\n<td>" . $religion . "</td>\n</tr>\n";
}
$stmt->close();
?>

        </tbody>
      </table>
      <fieldset>
        <legend>Add</legend>
        <form method="post" action="addRegRel.php"> 
          <p>Region: <select name="region">

<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM region"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $name)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<option value='". $id . "'>". $name . "</option>\n";
}
$stmt->close();
?>

          </select></p>
          <p>Religion: <select name="religion">

<?php
if(!($stmt = $mysqli->prepare("SELECT id, name FROM religion"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $name)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<option value='". $id . "'>". $name . "</option>\n";
}
$stmt->close();
?>

          </select></p>
          <p><input type="submit" value="Add"/></p>
        </form>
      </fieldset>

      <fieldset>
        <legend>Delete</legend>
        <form method="post" action="deleteRegRel.php">
        <p>Religion in Region: <select name="regRel">

<?php
if(!($stmt = $mysqli->prepare("SELECT rr.id, reg.name, rel.name FROM region_religion rr
                              INNER JOIN region reg ON rr.region_id = reg.id
                              INNER JOIN religion rel ON rr.religion_id = rel.id"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $reg_name, $rel_name)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo "<option value ='" . $id . "'>" . $rel_name . " in " . $reg_name . "</option>\n";
}
$stmt->close();
?>

          </select></p>
          <p><input type="submit" value="Delete" /></p>
        </form>
      </fieldset>

  </fieldset>
  </body>
</html>
