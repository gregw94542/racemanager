<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager Edit Race</title>
<body>
<? include ("ncsadb.php")?>

<?php

#	$keys = array_keys($_POST);
#	foreach ($keys as $vars) {
#	echo "$vars = $_POST[$vars]<br>";
#	}

if ($_POST[RACE_ID] != NULL) {
	$race_id = $_POST[RACE_ID];
}
if ($_GET[RACE_ID] != NULL)
   $race_id = $_GET[RACE_ID];

?>


<div class="inputbox">
<?php
$conn = mysql_connect(get_host(), get_user(), get_pass()) or 
	die ('Error connecting to mysql');
mysql_select_db(get_db());

$query = "select race_name, race_location, year(race_date) as year,
	  month(race_date) as month, day(race_date) as day
   	from races where race_id = $race_id";
	$result = mysql_query($query);

	#echo "$query<br>";
	$row = mysql_fetch_array($result,MYSQL_ASSOC);

echo "<h2>Editing Race: $row[race_name] </h2>";

echo "<form action=\"editrace1.php\" method=\"post\" 
	enctype=\"multipart/form-data\" name=\"EditRace\" 
	target=\"_parent\">";

echo "<table>";
echo "<tr>";
echo "<td>Name</td><td><input type=text name=RACE_NAME 
	value=\"$row[race_name]\"></td>";
echo "</tr> <tr>";
echo "<td>Location</td><td><input type=text name=RACE_LOCATION 
	value=\"$row[race_location]\"></td>";
echo "</tr>";
echo "<tr><td>Date</td> ";
echo " <td class=\"info\">
	<input name=\"RACE_MON\" type=\"text\" size=\"2\" maxlength=\"2\" value=\"$row[month]\">
	<input name=\"RACE_DAY\" type=\"text\" size=\"2\" maxlength=\"2\" value=\"$row[day]\">
	<input name=\"RACE_YEAR\" type=\"text\" size=\"4\" maxlength=\"4\" value=\"$row[year]\"></td></tr>\n";
  echo "<tr><td>&nbsp;</td><td><input name=\"Submit\" type=\"submit\" value=\"Change Race\"></td></tr>\n";
echo "</table>";
  echo "<input type=hidden name=RACE_ID value=\"$race_id\">";
?>

</form>

</html>
