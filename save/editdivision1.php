<html>
<? include ("ncsadb.php")?>

<?php

	$query = "update divisions 
	    set division_name = \"$_POST[DIVISION_NAME]\"
	  where division_id = $_POST[DIVISION_ID]";

	run_query_no_result($query);



echo "<META HTTP-EQUIV=\"Refresh\" 
	CONTENT=\"1; URL=racemanager.php?RACE_ID=$_POST[RACE_ID]\">";
?>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager Update Division</title>
<h3>Race Update Division in progress, please wait</h3>
<body>


</body>
</html>
