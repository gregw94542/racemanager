<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Sql Worksheet</title>
<script type='text/javascript' src='jquery-1.4.2.js'></script>
<script type='text/javascript' src='Sql.js'></script>
</head>
<?php include "utility.php" ?>
<?php include ("ncsadb.php") ?>
<?php
	$vars = new VARS();
	$database = new DB();
	$vars->insert_css_file();
	write_head_tag($vars);
	write_body_tag( $vars, $database);
?>
<div class="container">

<div class="top">
<h2>Sql Worksheet </h2>
</div>  <!--top div -->

<div class="side">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body">
<?php

###################################################
function get_distance($division, $heat)
{
        $conn = mysql_connect(get_host(), get_user(), get_pass()) ;
        mysql_select_db(get_db());
	$column = "division_distance".$heat;
	$query = "select " . $column  . " as distance from divisions where division_id = $division";
        $s_result = mysql_query($query);
	$distance = null;
        while ( $row = mysql_fetch_array($s_result,MYSQL_ASSOC)){
		$distance = $row[distance];
	}
	return $distance;
}
###################################################


function fixraw($heat) {
	$sql = "select raw_id, 
		divisions.division_id as did , 
		distance,
		heatnum
	from raw_results , divisions
	where distance is null
		and raw_results.division_id = divisions.division_id
		and heatnum = $heat
	order by divisions.division_id ";
	echo "$sql<br>";
        $conn = mysql_connect(get_host(), get_user(), get_pass()) ;
        mysql_select_db(get_db());
        $results = mysql_query($sql);

        while ( $row = mysql_fetch_array($results,MYSQL_ASSOC)){
		$did = $row[did];
		$distance = get_distance($did,$heat);
		$sql = "update raw_results 
			set distance=($distance) 
			where raw_id = $row[raw_id]";
		mysql_query($sql);
	}
}

for ($x = 1; $x < 7; $x++){
	echo "Fixing Heat $x<br>";
	fixraw($x);
}

echo "normalizing minutes<br>";
$sql = "update raw_results set min=\"0\" where min=\"00\"";
mysql_query($sql);
echo "normalizing seconds<br>";
$sql = "update raw_results set sec=\"0\" where sec=\"00\"";
mysql_query($sql);

echo "normalizing hundredths<br>";
$sql = "update raw_results set hun=\"0\" where hun=\"00\"";
mysql_query($sql);

	
?>

</div> <!--Body Div -->
</div>  <!--Container Div-->
</body>
</html>


