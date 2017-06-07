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

	$query = "update races set race_enable = 0";
	mysql_query($query);
	foreach ($keys as $vars) {
		if ($vars != "Submit" && $vars != "DIVISION_ID" 
            	&& $vars != "RACE_ID"  ){	
			$query = "update races set race_enable = 1
				where race_id = $_POST[$vars]";
			mysql_query($query);
		}
	}


?>

<META HTTP-EQUIV="Refresh" 
	CONTENT="1; URL=racemanager.php">
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager Changing Division Information</title>
</body>
</html>
