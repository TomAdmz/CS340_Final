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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Final Project: GoT Database</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <button class="navbar-toggle collapsed" data-target="#bs-example-navbar-collapse-2" data-toggle="collapse" type="button"><span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button> <a class="navbar-brand" href="index.php">GoT Database</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">Menu <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="gotpeople.php">GoT - People</a>
                </li>
                <li>
                  <a href="gothouses.php">GoT - Houses</a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="gotterritories.php">GoT - Territories</a>
                </li>
                <li>
                  <a href="gotevents.php">GoT - Events</a>
                </li>
                <li>
                  <a href="gotpeopleevents.php">GoT - PeopleEvents</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <h1>GoT People Table:</h1>
<div class="table-responsive">
<table class="table table-sm table-striped table-hover">
	<h3 class="text-center">GoT People</h3>
  <thead class="thead thead-default">
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Occupation</th>
      <th>Status</th>
      <th>House</th>
		</tr>
  </thead>
<?php
// create the sql query
if(!($stmt = $mysqli->prepare("SELECT p.FirstName, p.LastName, p.Occupation, p.Status, h.Name FROM GoTPeople p
    INNER JOIN GoTHouses h ON p.HouseId = h.id ORDER BY p.LastName"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
              
if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
// bind the results to variables
if(!$stmt->bind_result($FirstName, $LastName, $Occupation, $Status, $HouseId)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
// operate for each returned row. Inline the html.
while($stmt->fetch()){
 echo "<tr>\n<td>" . $FirstName . "</td>\n<td>" . $LastName . "</td>\n<td>" . $Occupation . "</td>\n<td>" . $Status . "</td><td>". $HouseId . "</td>\n</tr>\n";
}
// close out the sql query.
$stmt->close();
?>
</table>
</div>

<div class="table-responsive">
<table class="table table-sm table-striped table-hover">
  <h3 class="text-center">Events people were involed in:</h3>
  <thead class="thead thead-default">
    <tr>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Event</th>
      <th>Status</th>
    </tr>
  </thead>
  <?php
// create the sql query
if(!($stmt = $mysqli->prepare("SELECT p.FirstName, p.LastName, e.Name, p.Status FROM GoTPeople p
    INNER JOIN GoTPeopleEvents gpe ON p.id = gpe.pid 
    INNER JOIN GoTEvents e ON gpe.eid = e.id GROUP BY p.FirstName ORDER BY e.Name"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
              
if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
// bind the results to variables
if(!$stmt->bind_result($FirstName, $LastName, $Event, $Status)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
// operate for each returned row. Inline the html.
while($stmt->fetch()){
 echo "<tr>\n<td>" . $FirstName . "</td>\n<td>" . $LastName . "</td>\n<td>" . $Event . "</td><td>". $Status . "</td>\n</tr>\n";
}
// close out the sql query.
$stmt->close();
?>
</table>
</div>


<div class="form">
<h3>Update or Add Person</h3>

<form class="form-block" method="post" action="gotpeople_add_update.php">

    <fieldset class="form-group">
      <legend>Person Name</legend>
      <p>First Name: <input type="text" name="FirstName" /></p>
      <p>Last Name: <input type="text" name="LastName" /></p>
    </fieldset>

    <fieldset class="form-group">
      <legend>Occupation and Status</legend>
      <p>Occupation: <input type="text" name="Occupation" /></p>
      <p>Status:</p>
      <div class="radio">
      <label><input type="radio" name="Status" value="Alive">Alive</label>
      <label><input type="radio" name="Status" value="Deceased">Deceased</label>
      <label><input type="radio" name="Status" value="Unknown">Unknown</label>
      <label><input type="radio" name="Status" value="Resurrected">Resurrected</label>
      </div>
    </fieldset>

    <fieldset class="form-group">
      <legend>House</legend>
      <select name="HouseId">
<?php
//Generates a list of athlete team names, grabs id as well to store.
if(!($stmt = $mysqli->prepare("SELECT id, Name FROM GoTHouses"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $Name)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo '<option value=" '. $id . ' "> ' . $Name . '</option>\n';
}
$stmt->close();
?>

    </select>
    </fieldset>
    <input type="submit" name="Add" value="Add" />
    <input type="submit" name="Update" value="Update" />
  </form>
</div>

<br>
<footer> Final Project by Tom Adamcewicz and Steven Hunt</footer>
<br>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>

</body>
</html