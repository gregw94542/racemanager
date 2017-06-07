<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager Create</title>
<body>
<? include ("ncsadb.php")?>

<?php

#	$keys = array_keys($_POST);
#	foreach ($keys as $vars) {
#	echo "$vars = $_POST[$vars]<br>";
#	}
?>

<div class="inputbox">
<h2>Creating Race</h2>
<form action="CreateRace1.php" method="post" enctype="multipart/form-data" name="CreateRace" target="_parent">

<?php
echo "<input type=\"hidden\" name=\"RACE_NAME\" value=\"$_POST[RACE_NAME]\">\n";
echo "<input type=\"hidden\" name=\"RACE_LOCATION\" value=\"$_POST[RACE_LOCATION]\">\n";
echo "<input type=\"hidden\" name=\"RACE_MON\" value=\"$_POST[RACE_MON]\">\n";
echo "<input type=\"hidden\" name=\"RACE_DAY\" value=\"$_POST[RACE_DAY]\">\n";
echo "<input type=\"hidden\" name=\"RACE_YEAR\" value=\"$_POST[RACE_YEAR]\">\n";
echo "<input type=\"hidden\" name=\"RACE_HOUR\" value=\"$_POST[RACE_HOUR]\">\n";
echo "<input type=\"hidden\" name=\"RACE_MIN\" value=\"$_POST[RACE_MIN]\">\n";
echo "<input type=\"hidden\" name=\"RACE_AMPM\" value=\"$_POST[RACE_AMPM]\">\n";
echo "<input type=\"hidden\" name=\"ASSOCIATION_ID\" value=\"$_POST[ASSOCIATION_ID]\">\n";
?>

<p>You are about to create the following race:
<?php
	echo "$_POST[RACE_NAME]\n";
?>
<br>location:
<?php
echo "$_POST[RACE_LOCATION]";
?>

<br>Date:
<?php
echo "$_POST[RACE_MON]/";
echo "$_POST[RACE_DAY]/";
echo "$_POST[RACE_YEAR]";
?>

<?php
echo "<br><input name=\"Submit\" type=\"submit\" value=\"Sure Create the Race!\"></form>\n";

echo "<br><form action=\"racemanager.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"CreateRace\" target=\"_parent\">\n ";
echo "<input type=\"hidden\" name=\"RACE_NAME\" value=\"$_POST[RACE_NAME]\">\n";
echo "<input type=\"hidden\" name=\"RACE_LOCATION\" value=\"$_POST[RACE_LOCATION]\">\n";
echo "<input type=\"hidden\" name=\"RACE_MON\" value=\"$_POST[RACE_MON]\">\n";
echo "<input type=\"hidden\" name=\"RACE_DAY\" value=\"$_POST[RACE_DAY]\">\n";
echo "<input type=\"hidden\" name=\"RACE_YEAR\" value=\"$_POST[RACE_YEAR]\">\n";
echo "<input type=\"hidden\" name=\"RACE_START\" value=\"$_POST[RACE_START]\">\n";

echo "<input name=\"Submit\" type=\"submit\" value=\"Forget It!\"></form>\n";
?>

</body>
</html>
