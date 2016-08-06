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

$Pid = $_POST['Pid'];
$Eid = $_POST['Eid'];
if(isset($_POST['Add']))

{
  if(!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
  }

  if(!($stmt = $mysqli->prepare("INSERT INTO GoTPeopleEvents (Pid, Eid) VALUES (?,?)"))){
    echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!($stmt->bind_param("ii",$Pid , $Eid))){
    echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if(!$stmt->execute()){
    echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
  } else {
    echo "Person-Event relationship added to database.";}
} else
{

  if(!($deleteQ = $mysqli->prepare("DELETE FROM GoTPeopleEvents WHERE Pid=? AND Eid=? "))){
    echo "Prepare failed: "  . $deleteQ->errno . " " . $deleteQ->error;
  }
  if(!($deleteQ->bind_param("ii", $Pid, $Eid))){
    echo "Bind failed: "  . $deleteQ->errno . " " . $deleteQ->error;
  }
  if(!$deleteQ->execute()){
    echo "Execute failed: "  . $deleteQ->errno . " " . $deleteQ->error;
  }
  else if($deleteQ->affected_rows > 0)
  {
    echo "Person/Event pairing deleted!";
  }
  else
  {
    echo "No rows affected, please try again.";
  }
}
?>
<p>Navigate back to <a href="gotpeopleevents.php"> GoTPeopleEvents</a> page.