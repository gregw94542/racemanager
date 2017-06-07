<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager Set Up Distances</title>
<body>
<? include ("ncsadb.php")?>
<? include "utility.php"?>

<?php
$vars = new VARS();
$database = new DB();
$vars->insert_css_file();

$yr = $vars->get_birth_year();
$RACE_ID = $vars->get_race_id();
$mon = $vars->get_birth_mon();
$day = $vars->get_birth_day();
$race1 = $vars ->get_first_race();
$race2 = $vars ->get_second_race();
$race3 = $vars ->get_third_race();
$race4 = $vars ->get_fourth_race();
$division_id = $vars->get_divisionid();

echo "raceid = $RACE_ID";

$birth_date = date("$yr-$mon-$$day");
$query = "update divisions 
           set division_distance1 = \"$race1\",
               division_distance2 = \"$race2\",
               division_distance3 = \"$race3\",
               division_distance4 = \"$race4\"
	where division_id = \"$division_id\"";
$database->runsql($query, 1);

#echo "$query<br>";

?>

<h2>Changing Distances</h2>

<?php
echo "<a href=OpenRace.php?RACE_ID=$RACE_ID>Back</a>";
echo "a href=OpenRace.php?RACE_ID=$RACE_ID>Back";
?>

<META HTTP-EQUIV="Refresh" 
	CONTENT="0; 
<?php
	echo "URL=OpenRace.php?RACE_ID=$RACE_ID\">";
?>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager Changing Division Information</title>
</body>
</body>
</html>
