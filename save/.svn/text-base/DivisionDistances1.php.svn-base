<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager Set Up Distances</title>
<body>
<? include ("ncsadb.php")?>

<?php
$keys = array_keys($_POST);
foreach ($keys as $vars) {
#echo "$vars = $_POST[$vars]<br>";
}

$RACE_ID = $_POST[RACE_ID];

$conn = mysql_connect(get_host(), get_user(), get_pass()) 
	or die ('Error connecting to mysql');
mysql_select_db(get_db());
$birth_date = date("$_POST[BIRTH_YEAR]-$_POST[BIRTH_MON]-$_POST[BIRTH_DAY]");
$query = "update divisions 
           set division_distance1 = \"$_POST[first_race]\",
               division_distance2 = \"$_POST[second_race]\",
               division_distance3 = \"$_POST[third_race]\",
               division_distance4 = \"$_POST[fourth_race]\"
	where division_id = \"$_POST[DIVISION_ID]\"";

#echo "$query<br>";

$result = mysql_query($query);
?>

<h2>Changing Distances</h2>

<?php
echo "<a href=OpenRace.php?RACE_ID=$RACE_ID>Back</a>";
?>

<META HTTP-EQUIV="Refresh" 
	CONTENT="1; 
<?php
	echo "URL=OpenRace.php?RACE_ID=$RACE_ID\">";
?>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager Changing Division Information</title>
</body>
</body>
</html>
