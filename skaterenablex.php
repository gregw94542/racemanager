<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager - Enable/Disable Races</title>
<body>
<? include ("ncsadb.php")?>


<?php


$keys = array_keys($_POST);
foreach ($keys as $vars) {
#echo "$vars = $_POST[$vars]<br>";
}

echo "<div class=\"story1\"><table>";
echo "<h3 width=75%>RACE: $RACE - Change Race Status: </h3>";
echo "<hr  class=\"hline\">";
###########################################################################

$conn = mysql_connect(get_host(), get_user(), get_pass()) 
	or die ('Error connecting to mysql');
mysql_select_db(get_db());


##### handle the active skater case  ###################
$query = "select skater_id, skater_first, skater_last, is_active
	from skaters
	where is_active = 1;
	order by  skater_first, skater_last
	desc";


$race_names = array();
$array_index = 0;
 echo "<form action=\"skaterenable1.php\" 
        method=\"post\" enctype=\"multipart/form-data\" 
	name=\"popdivision\" target=\"_parent\"> ";

$result = mysql_query($query);
while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
	if ($row[is_active] ==  0){
		$checked = "";
	} else {
		$checked = "checked";
	}
	$skater_names[$array_index] = 
		"<input type=\"checkbox\" name='SELECTED_$array_index'
		  value=\"$row[skater_id]\" $checked>
		<i>$row[skater_first] $row[skater_last]</i></b> ";
	$array_index++;
}

##### handle the inactive skater case  ###################

$query = "select skater_id, skater_first, skater_last, is_active
	from skaters
	where is_active <> 1;
	order by  skater_first, skater_last
	desc";

$result = mysql_query($query);

mysql_close($conn);

while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
	if ($row[is_active] ==  0){
		$checked = "";
	} else {
		$checked = "checked";
	}
	$skater_names[$array_index] = 
		"<input type=\"checkbox\" name='SELECTED_$array_index'
		  value=\"$row[skater_id]\" $checked>
		<i>$row[skater_first] $row[skater_last]</i></b> ";
	$array_index++;
}


#############################################################

$colcount = 6;
$num_rows = $array_index;
$display_rows = floor((($num_rows-1) / $colcount)+1);

for ($x = 0; $x < $display_rows; $x++) {
	echo "<tr>";
	for ($c = 0 ; $c < $colcount; $c++) {
		$entry_offset = $x + ($c * $display_rows);
		echo "<td class=\"checkbox\">$skater_names[$entry_offset] </td>";
	}
	echo "</tr>";
}
echo "</table>";

echo "<br>";
echo "<table><tr><td>";
echo "<input name=\"Submit\" type=\"submit\"
  value=\"Update Races\"></form>" ;
echo "</td></tr></table>";
echo "</div>";



?>

</body>
</html>
