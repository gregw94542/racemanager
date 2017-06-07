<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager - Add Skaters to division</title>
<body>
<? include ("ncsadb.php")?>


<?php

function clear_division($div)
{
$conn = mysql_connect(get_host(), get_user(), get_pass()) 
	or die ('Error connecting to mysql');
mysql_select_db(get_db());
$query = "delete from division_skaters 
    where division_id = '$div'";
$result = mysql_query($query);
mysql_close($conn);


}

function add_to_division($div, $skater)
{
$s = get_skater($skater);
$d = get_division($div);
$r = get_race($_POST[RACE_ID]);
$conn = mysql_connect(get_host(), get_user(), get_pass()) 
	or die ('Error connecting to mysql');
mysql_select_db(get_db());
$query = "delete from division_skaters
	  where race_id = '$_POST[RACE_ID]'	
	  and skater_id = '$skater'";
$result = mysql_query($query);


echo "<i>&nbsp;&nbsp; deleting $s from $r<i><br>";

$query = "insert into division_skaters
	(skater_id, division_id, race_id ) values
	('$skater', '$div', '$_POST[RACE_ID]')";
$result = mysql_query($query);
#echo "$query<br>";

echo "<i>&nbsp;&nbsp; adding $s to division: $d race $r</i><br>";
mysql_close($conn);
}


echo "<h3>Division Change in progress, please wait</h3>";
$keys = array_keys($_POST);
foreach ($keys as $vars) {
#  echo "$vars = $_POST[$vars]<br>";
}

$RACE_ID = $_POST[RACE_ID];
clear_division($_POST[DIVISION_ID]);
foreach ($keys as $vars) {
	if ($vars != "Submit" && $vars != "DIVISION_ID" 
            && $vars != "RACE_ID"  ){	
		add_to_division($_POST[DIVISION_ID], $_POST[$vars]);
	}
}
#echo "<form action=\"OpenRace.php\" 
        #method=\"post\" enctype=\"multipart/form-data\" 
	#name=\"popdivision\" target=\"_parent\"> ";
#echo "<input type=\"hidden\" name=\"RACE_ID\" value=\"$_POST[RACE_ID]\">\n";
#echo "<input name=\"Submit\" type=\"submit\"
  #value=\"Back\"></form>" ;
###########################################################################


?>
<META HTTP-EQUIV="Refresh" 
	CONTENT="0; 
<?php
	echo "URL=createdivision.php?RACE_ID=$RACE_ID\">";
?>

<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager Changing Division Information</title>
</body>
</html>
