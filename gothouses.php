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
    <h1>GoT Houses Table:</h1>
<div class="table-responsive">
<table class="table table-sm table-striped table-hover">
	<h3 class="text-center">GoT Houses</h3>
  <thead class="thead thead-default">
		<tr>
			<th>Name</th>
			<th>Head</th>
			<th>Colors</th>
      <th>Sigil</th>
      <th>House Words</th>
		</tr>
  </thead>
<?php
// create the sql query
if(!($stmt = $mysqli->prepare("SELECT h.Name, p.FirstName, p.LastName, h.Colors, h.Sigil, h.HouseWords FROM GoTHouses h
    LEFT JOIN GoTPeople p ON h.HeadId = p.id ORDER BY h.Name"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
              
if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
// bind the results to variables
if(!$stmt->bind_result($Name, $FirstName, $LastName, $Colors, $Sigil, $HouseWords)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
// operate for each returned row. Inline the html.
while($stmt->fetch()){
 echo "<tr>\n<td>" . $Name . "</td>\n<td>" . $FirstName . " " . $LastName . "</td>\n<td>" . $Colors . "</td>\n<td>" . $Sigil . "</td><td>". $HouseWords . "</td>\n</tr>\n";
}
// close out the sql query.
$stmt->close();
?>
</table>
</div>

<div class="table-responsive">
<table class="table table-sm table-striped table-hover">
  <h3 class="text-center">Territores Ruled by Each House:</h3>
  <thead class="thead thead-default">
    <tr>
      <th>House Name</th>
      <th>Territory Name</th>
      <th>Region</th>
      <th>Continent</th>
    </tr>
  </thead>
  <?php
// create the sql query
if(!($stmt = $mysqli->prepare("SELECT h.Name, t.Name, t.Location, t.Continent FROM GoTHouses h
    INNER JOIN GoTTerritories t ON t.RuledById = h.id  ORDER BY h.Name"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
              
if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
// bind the results to variables
if(!$stmt->bind_result($HouseName, $TerritoryName, $Location, $Continent)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
// operate for each returned row. Inline the html.
while($stmt->fetch()){
 echo "<tr>\n<td>" . $HouseName . "</td>\n<td>" . $TerritoryName . "</td>\n<td>" . $Location . "</td><td>". $Continent . "</td>\n</tr>\n";
}
// close out the sql query.
$stmt->close();
?>
</table>
</div>


<div class="form">
<h3>Update or Add House</h3>

<form class="form-block" method="post" action="gothouses_add_update.php">

    <fieldset class="form-group">
      <legend>House Name</legend>
      <p>Name: <input type="text" name="Name" /></p>
    </fieldset>

    <fieldset class="form-group">
      <legend>House Colors, Sigil and House Words</legend>
      <p>Colors: <input type="text" name="Colors" /></p>
      <p>Sigil: <input type="text" name="Sigil" /></p>
      <p>House Words: <input type="text" name="HouseWords" /></p>
    </fieldset>

    <fieldset class="form-group">
      <legend>House Head **ON UPDATE ONLY**</legend>
      <select name="HeadId">
        <option value="">None</option>
<?php
//Generates a list of athlete team names, grabs id as well to store.
if(!($stmt = $mysqli->prepare("SELECT id, FirstName, LastName FROM GoTPeople"))){
  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
if(!$stmt->execute()){
  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $FirstName, $LastName)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
  echo '<option value=" '. $id . ' "> ' . $FirstName .  " " . $LastName . '</option>\n';
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