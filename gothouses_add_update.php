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
$Colors = $_POST['Colors'];
$Sigil = $_POST['Sigil'];
$HouseWords = $_POST['HouseWords'];
$HeadId= $_POST['HeadId'];
if(isset($_POST['Add']))

{
  if(!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
  }

  if(!($stmt = $mysqli->prepare("INSERT INTO GoTHouses (Name, Colors, Sigil, HouseWords) VALUES (?,?,?,?)"))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!($stmt->bind_param("ssss",$Name , $Colors, $Sigil, $HouseWords))){
    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!$stmt->execute()){
    echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
  } else {
    echo "House added to database.";}
} else
{

  if(!($updateQ = $mysqli->prepare("UPDATE GoTHouses SET Colors=?, Sigil=?, HouseWords=?, HeadId=?  WHERE Name=?"))){
    echo "Prepare failed: "  . $updateQ->errno . " " . $updateQ->error;
  }
  if(!($updateQ->bind_param("sssis", $Colors, $Sigil, $HouseWords, $HeadId, $Name))){
    echo "Bind failed: "  . $updateQ->errno . " " . $updateQ->error;
  }
  if(!$updateQ->execute()){
    echo "Execute failed: "  . $updateQ->errno . " " . $updateQ->error;
  }
  else if($updateQ->affected_rows > 0)
  {
    echo "House updated!";
  }
  else
  {
    echo "No rows affected, please enter the first name and last of current Person to update.";
  }
}
?>
<p>Navigate back to <a href="gothouses.php"> GoTHouses</a> page.