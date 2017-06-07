<html>
<? include ("ncsadb.php")?>

<?php
#	$keys = array_keys($_POST);
#	foreach ($keys as $vars) {
#	echo "$vars = $_POST[$vars]<br>";
#	}
	

	$race_date = date("$_POST[RACE_YEAR]-$_POST[RACE_MON]-$_POST[RACE_DAY]");
	$query = "update races 
	    set race_name = \"$_POST[RACE_NAME]\",
	    race_location = \"$_POST[RACE_LOCATION]\",
	    race_date = \"$race_date\"
	  where race_id = $_POST[RACE_ID]";

	run_query_no_result($query);


echo "<META HTTP-EQUIV=\"Refresh\" 
	CONTENT=\"1; URL=racemanager.php?RACE_ID=$_POST[RACE_ID]\">";
?>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager Update</title>
<h3>Race Update in progress, please wait</h3>
<body>


</body>
</html>
