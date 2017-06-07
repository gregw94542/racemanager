<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager - Generate Heat Cards</title>
<body>
<? include ("ncsadb.php")?>


<?php
function write_cell($name, $attr)
{
	echo "<td class=\"heatcard\" $attr>$name</td>";
}


function display_distance($id, $dist, $heatnum, $title)
{
	$query = " select division_id, division_name , 
	  $dist
          from divisions 
	  where race_id = $id";

	$division_list = mysql_query($query);



	while ( $division_row = mysql_fetch_array($division_list,MYSQL_ASSOC)){
	echo "<table>";
	   if ($division_row[$dist] != NULL &&
	       $division_row[$dist] != 0) {
		echo "<tr>\n";
	   	write_cell ("$heatnum","width=100px");
	   	write_cell( "$division_row[division_name]","width=250px" );
	   	write_cell( $division_row[$dist],"align=center" );
		echo "</tr>\n";
	   	$heatnum++;
	   }
	   echo "</table>";
	}
	return $heatnum;
}

function display_heatcard($id)
{
		$conn = mysql_connect(get_host(), get_user(), get_pass()) 
			or die ('Error connecting to mysql');
		mysql_select_db(get_db());

		
		$query = "select race_name, race_location, race_date
	  		from races 
  	  		where race_id = $id";
		$race_row =  mysql_query($query);
		$race_row = mysql_fetch_array($race_row,MYSQL_ASSOC);
		$rname = $race_row[race_name];
		$rloc = $race_row[race_location];
		$rdate = $race_row[race_date];

		echo "<h1>$race_row[race_name]</h1>\n";
		echo "<h3>$race_row[race_location]</h3>\n";
		echo "<h3>$race_row[race_date]</h3>\n";
		echo "<hr width=75% align=left>";
		$heat=1;

		$heat = display_distance($id, "division_distance1", $heat,$string);
		$heat = display_distance($id, "division_distance2", $heat,$string);
		$heat = display_distance($id, "division_distance3", $heat,$string);
		$heat = display_distance($id, "division_distance4", $heat,$string);
		$heat = display_distance($id, "division_distance5", $heat,$string);
		$heat = display_distance($id, "division_distance6", $heat,$string);

		mysql_close($conn);
}


if ($_POST[RACE_ID] != NULL) {
	$race_id = $_POST[RACE_ID];
}
if ($_GET[RACE_ID] != NULL)
   $race_id = $_GET[RACE_ID];

display_heatcard($race_id);

echo "<a href=racemanager.php?RACE_ID=$race_id>Back</a>";
?>


</body>
</html>
