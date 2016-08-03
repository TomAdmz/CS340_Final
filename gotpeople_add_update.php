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

$FirstName = $_POST['FirstName'];
$LastName = $_POST['LastName'];
$Occupation = $_POST['Occupation'];
$Status = $_POST['Status'];
$HouseId= $_POST['HouseId'];
if(isset($_POST['Add']))

{
  if(!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
  }

  if(!($stmt = $mysqli->prepare("INSERT INTO GoTPeople (FirstName, LastName, Occupation, Status, HouseId) VALUES (?,?,?,?,?)"))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!($stmt->bind_param("ssssi",$FirstName , $LastName, $Occupation, $Status, $HouseId))){
    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!$stmt->execute()){
    echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
  } else {
    echo "Person added to database.";}
} else
{

  if(!($updateQ = $mysqli->prepare("UPDATE GoTPeople SET Status=?, Occupation=?  WHERE FirstName=? AND LastName=? "))){
    echo "Prepare failed: "  . $updateQ->errno . " " . $updateQ->error;
  }
  if(!($updateQ->bind_param("ssss", $Status, $Occupation, $FirstName, $LastName))){
    echo "Bind failed: "  . $updateQ->errno . " " . $updateQ->error;
  }
  if(!$updateQ->execute()){
    echo "Execute failed: "  . $updateQ->errno . " " . $updateQ->error;
  }
  else if($updateQ->affected_rows > 0)
  {
    echo "Person updated!";
  }
  else
  {
    echo "No rows affected, please enter the first name and last of current Person to update.";
  }
}
?>
<p>Navigate back to <a href="gotpeople.php"> GoTPeople</a> page.