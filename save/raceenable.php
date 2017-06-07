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

$query = "select race_id, race_name, race_enable
	from races
	order by race_name";

$result = mysql_query($query);
mysql_close($conn);

$race_names = array();
$array_index = 0;
 echo "<form action=\"raceenable1.php\" 
        method=\"post\" enctype=\"multipart/form-data\" 
	name=\"popdivision\" target=\"_parent\"> ";

while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
#	echo "$row[race_name] - $row[race_enable]<br>";
	if ($row[race_enable] != 0){
		$checked = "checked";
	} else {
		$checked = "";
	}
	$race_names[$array_index] = 
		"<input type=\"checkbox\" name='SELECTED_$array_index'
		  value=\"$row[race_id]\" $checked>
		$row[race_name] ";
	$array_index++;
}

for ($x = 0; $x < ($array_index); ){
	echo "<tr>";
	echo "<td class=\"checkbox\">$race_names[$x] </td>";
	$x++;
	echo "<td class=\"checkbox\">$race_names[$x] </td>";
	$x++;
	echo "<td class=\"checkbox\">$race_names[$x] </td>";
	$x++;
	echo "<td class=\"checkbox\">$race_names[$x] </td>";
	$x++;
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
