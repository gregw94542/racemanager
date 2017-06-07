<html>
<? include ("ncsadb.php")?>

<?php
	#$keys = array_keys($_POST);
	#foreach ($keys as $vars) {
	#echo "$vars = $_POST[$vars]<br>";
	#}
?>

<?php
echo "<input type=\"hidden\" name=\"RACE_NAME\" value=\"$_POST[RACE_NAME]\">\n";
echo "<input type=\"hidden\" name=\"RACE_LOCATION\" value=\"$_POST[RACE_LOCATION]\">\n";
echo "<input type=\"hidden\" name=\"RACE_MON\" value=\"$_POST[RACE_MON]\">\n";
echo "<input type=\"hidden\" name=\"RACE_DAY\" value=\"$_POST[RACE_DAY]\">\n";
echo "<input type=\"hidden\" name=\"RACE_YEAR\" value=\"$_POST[RACE_YEAR]\">\n";
echo "<input type=\"hidden\" name=\"RACE_HOUR\" value=\"$_POST[RACE_HOUR]\">\n";
echo "<input type=\"hidden\" name=\"RACE_MIN\" value=\"$_POST[RACE_MIN]\">\n";
echo "<input type=\"hidden\" name=\"RACE_AMPM\" value=\"$_POST[RACE_AMPM]\">\n";
?>

<?php
	

	$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	$race_date = date("$_POST[RACE_YEAR]-$_POST[RACE_MON]-$_POST[RACE_DAY]");
	$query = "insert into races(race_name, race_location, race_date, race_enable) values ('$_POST[RACE_NAME]', '$_POST[RACE_LOCATION]',  '$race_date', 1 )";
	$result = mysql_query($query);



echo "<META HTTP-EQUIV=\"Refresh\" 
	CONTENT=\"2; URL=racemanager.php\">";
?>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager Create</title>
<h3>Race Creation in progress, please wait</h3>
<body>


</body>
</html>
