<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager Edit Race</title>
<body>
<? include ("ncsadb.php")?>


<script language=javascript>
function DeleteDivision( )
{
	var answer = confirm("Delete Division? ");
	if (answer) {
		document.EditRace.action="DeleteDivision.php";
		document.EditRace.submit();
	} else {
		alert ("chicken!!");
	}
}
</script>

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

$query = "select division_name
   	from divisions where division_id  = $_GET[DIVISION_ID]";
	$result = mysql_query($query);

	#echo "$query<br>";
	$row = mysql_fetch_array($result,MYSQL_ASSOC);

echo "<h2>Change Division Name: $row[division_name] </h2>";

echo "<form action=\"editdivision1.php\" method=\"post\" 
	enctype=\"multipart/form-data\" name=\"EditRace\" 
	target=\"_parent\">";

echo "<table>";
echo "<tr>";
echo "<td>Name</td><td><input type=text name=DIVISION_NAME
	value=\"$row[division_name]\"></td>";
echo "</tr>";
echo "<tr><td><input type=submit name=\"change division\"></td></tr>";
echo "</table>";
  echo "<input type=hidden name=RACE_ID value=\"$race_id\">";
  echo "<input type=hidden name=DIVISION_ID value=\"$_GET[DIVISION_ID]\">";

  echo "<input type=\"BUTTON\" name=\"delete\" value=\"Delete Division\"
	onclick=DeleteDivision();>\n";
?>

</form>

</html>
