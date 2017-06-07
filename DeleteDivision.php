<html>
<? include ("ncsadb.php")?>

<?php
	$keys = array_keys($_POST);
	foreach ($keys as $vars) {
	#echo "$vars = $_POST[$vars]<br>";
	}
	

	$query = "delete from division_skaters where division_id = $_POST[DIVISION_ID]";
	echo "$query<br>";
	run_query_no_result($query);

	$query = "delete from raw_results where division_id = $_POST[DIVISION_ID]";
	echo "$query<br>";
	run_query_no_result($query);

	$query = "delete from divisions where division_id = $_POST[DIVISION_ID]";
	echo "$query<br>";
	run_query_no_result($query);


echo "<META HTTP-EQUIV=\"Refresh\" 
	CONTENT=\"1; URL=racemanager.php?RACE_ID=$_POST[RACE_ID]\">";
?>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager Division Delete</title>
<h3>Delete Division in Progress, please wait</h3>
<body>


</body>
</html>
