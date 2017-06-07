<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager - Change Race Status</title>
<body>
<? include ("ncsadb.php")?>


<?php

echo "<h3>Race Status Change in progress, please wait</h3>";
$keys = array_keys($_POST);
foreach ($keys as $vars) {
  #echo "$vars = $_POST[$vars]<br>"#;
}
foreach ($keys as $vars) {
	if ($vars != "Submit" && $vars != "DIVISION_ID" 
            && $vars != "RACE_ID"  ){	
	}
}
###########################################################################

	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
	or die ('Error connecting to mysql');
	mysql_select_db(get_db());

	$query = "update skaters set is_active = 0";
	mysql_query($query);
	foreach ($keys as $vars) {
		if ($vars != "Submit" && $vars != "DIVISION_ID" 
            	&& $vars != "RACE_ID"  ){	
			$query = "update skaters set is_active = 1
				where skater_id = $_POST[$vars]";
			#echo "$query<br>";
			mysql_query($query);
		}
	}


?>

<META HTTP-EQUIV="Refresh" 
	CONTENT="0; URL=racemanager.php">
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager Changing Skater Information</title>
</body>
</html>
