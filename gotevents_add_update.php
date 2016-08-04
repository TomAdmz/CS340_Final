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
$Type = $_POST['Type'];
$Casualties = $_POST['Casualties'];
$LocationId= $_POST['LocationId'];
if(isset($_POST['Add']))

{
  if(!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
  }

  if(!($stmt = $mysqli->prepare("INSERT INTO GoTEvents (Name, Type, Casualties, LocationId) VALUES (?,?,?,?)"))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!($stmt->bind_param("ssii",$Name , $Type, $Casualties, $LocationId))){
    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!$stmt->execute()){
    echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
  } else {
    echo "Event added to database.";}
} else
{

  if(!($updateQ = $mysqli->prepare("UPDATE GoTEvents SET LocationId=?, Type=?, Casualties=?  WHERE Name=?"))){
    echo "Prepare failed: "  . $updateQ->errno . " " . $updateQ->error;
  }
  if(!($updateQ->bind_param("isis", $LocationId, $Type, $Casualties, $Name))){
    echo "Bind failed: "  . $updateQ->errno . " " . $updateQ->error;
  }
  if(!$updateQ->execute()){
    echo "Execute failed: "  . $updateQ->errno . " " . $updateQ->error;
  }
  else if($updateQ->affected_rows > 0)
  {
    echo "Event updated!";
  }
  else
  {
    echo "No rows affected, please enter the correct name of the current Event to update.";
  }
}
?>
<p>Navigate back to <a href="gotevents.php"> GoTEvents</a> page.