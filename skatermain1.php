<html>
<? include ("ncsadb.php")?>

<?php
	$keys = array_keys($_POST);
	foreach ($keys as $vars) {
	echo "$vars = $_POST[$vars]<br>";
	}
?>

<?php
echo "<input type=\"hidden\" name=\"RACE_NAME\" value=\"$_POST[RACE_NAME]\">\n";
?>

<?php
	

	$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	$dob = date("$_POST[BIRTH_YEAR]-$_POST[BIRTH_MON]-$_POST[BIRTH_DAY]");
	$query = "update skaters
           set skater_first = \"$_POST[FIRST_NAME]\",
               skater_last = \"$_POST[LAST_NAME]\",
	       skater_email = \"$_POST[EMAIL]\",
	       skater_sex = \"$_POST[SEX]\",
	       association_id = \"$_POST[ASSOCIATION_ID]\",
	       title_id = \"$_POST[TITLE_ID]\",
	       skater_dob = \"$dob\"
	where skater_id = \"$_POST[SKATER_ID]\"";
	#$query = "update skaters
        #   set skater_email = \"$_POST[EMAIL]\",
	#       skater_sex = \"$_POST[SEX]\",
	#       skater_dob = \"$dob\"
	#where skater_id = \"$_POST[SKATER_ID]\"";
	#echo "$query<br>";
	$result = mysql_query($query);


?>

<META HTTP-EQUIV="Refresh" 
	CONTENT="1; URL=skatermain.php">
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager Changing Skater Information</title>
<h3>Skater Change in progress, please wait</h3>
<body>


</body>
</html>
