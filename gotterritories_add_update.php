<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$dbhost = 'oniddb.cws.oregonstate.edu';
$dbname = 'adamcewt-db';
$dbuser = 'adamcewt-db';
$dbpass = 'lvM53HhGM1h1R6OO';

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if($mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$Name = $_POST['Name'];
$Climate = $_POST['Climate'];
$Location = $_POST['Location'];
$Continent = $_POST['Continent'];
$RuledById= $_POST['RuledById'];
if(isset($_POST['Add']))

{
  if(!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
  }

  if(!($stmt = $mysqli->prepare("INSERT INTO GoTTerritories (Name, Climate, Location, Continent, RuledById) VALUES (?,?,?,?,?)"))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!($stmt->bind_param("ssssi",$Name , $Climate, $Location, $Continent, $RuledById))){
    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!$stmt->execute()){
    echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
  } else {
    echo "Territory added to database.";}
} else
{

  if(!($updateQ = $mysqli->prepare("UPDATE GoTTerritories SET Climate=?, Location=?, Continent=?, RuledById=?  WHERE Name=? "))){
    echo "Prepare failed: "  . $updateQ->errno . " " . $updateQ->error;
  }
  if(!($updateQ->bind_param("sssis", $Climate, $Location, $Continent, $RuledById, $Name))){
    echo "Bind failed: "  . $updateQ->errno . " " . $updateQ->error;
  }
  if(!$updateQ->execute()){
    echo "Execute failed: "  . $updateQ->errno . " " . $updateQ->error;
  }
  else if($updateQ->affected_rows > 0)
  {
    echo "Territory updated!";
  }
  else
  {
    echo "No rows affected, please enter the correct name of the Territory to update.";
  }
}
?>
<p>Navigate back to <a href="gotterritories.php"> GoTTerritories</a> page.