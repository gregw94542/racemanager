<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager - Open Race</title>
<body>
<? include ("ncsadb.php")?>


<?php

function check_selected($id, $div)
{
$check_conn = mysql_connect(get_host(), get_user(), get_pass()) 
	or die ('Error connecting to mysql');
mysql_select_db(get_db());

$check_query = "select count(*) cnt from division_skaters
	where skater_id = '$id' and 
	 division_id = '$div'";
#echo "$check_query<br>";
$check_result = mysql_query($check_query);
mysql_close($check_conn);
$check_row = mysql_fetch_array($check_result,MYSQL_ASSOC);

  if ($check_row[cnt] == 0){
  	$checked="";
  }else{
  	$checked = "checked";
  }
  return $checked;

}


$keys = array_keys($_POST);
foreach ($keys as $vars) {
#echo "$vars = $_POST[$vars]<br>";
}


$RACE = get_race($_POST[RACE_ID]);
$GROUP = get_division($_POST[DIVISION_ID]);
echo "<div class=\"story1\"><table>";
echo "<h3 width=75%>RACE: $RACE - Change Division: $GROUP</h3>";
echo "<hr  class=\"hline\">";
###########################################################################

$conn = mysql_connect(get_host(), get_user(), get_pass()) 
	or die ('Error connecting to mysql');
mysql_select_db(get_db());

$query = "select skater_first, skater_last, skater_id from skaters
	order by skater_first";
$result = mysql_query($query);
mysql_close($conn);

$skaternames = array();
$array_index = 0;
 echo "<form action=\"populate_division1.php\" 
        method=\"post\" enctype=\"multipart/form-data\" 
	name=\"popdivision\" target=\"_parent\"> ";

while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
	$checked = check_selected($row[skater_id], $_POST[DIVISION_ID]);
	$skaternames[$array_index] = 
		"<input type=\"checkbox\" name='SELECTED_$array_index'
		  value=\"$row[skater_id]\" $checked>
		$row[skater_first] 
		$row[skater_last]";
	$array_index++;
}

for ($x = 0; $x < ($array_index); ){
	echo "<tr>";
	echo "<td class=\"checkbox\">$skaternames[$x] </td>";
	$x++;
	echo "<td class=\"checkbox\">$skaternames[$x] </td>";
	$x++;
	echo "<td class=\"checkbox\">$skaternames[$x] </td>";
	$x++;
	echo "<td class=\"checkbox\">$skaternames[$x] </td>";
	$x++;
	echo "</tr>";
}
echo "</table>";

#echo "<input type=\"hidden\" name=\"TOTAL_SKATERS\" value=\"$array_index\">\n";
echo "<br>";
echo "<input type=\"hidden\" name=\"DIVISION_ID\" value=\"$_POST[DIVISION_ID]\">\n";
echo "<input type=\"hidden\" name=\"RACE_ID\" value=\"$_POST[RACE_ID]\">\n";
echo "<table><tr><td>";
echo "<input name=\"Submit\" type=\"submit\"
  value=\"Update Division\"></form>" ;

echo "</td><td>";
echo "<form action=\"OpenRace.php\" 
        method=\"post\" enctype=\"multipart/form-data\" 
	name=\"popdivision\" target=\"_parent\"> ";
echo "<input type=\"hidden\" name=\"RACE_ID\" value=\"$_POST[RACE_ID]\">\n";
echo "<input name=\"Submit\" type=\"submit\"
  value=\"Back\"></form>" ;
echo "</td></tr></table>";
echo "</div>";



?>

</body>
</html>
