<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Current Members</title>
<script type='text/javascript' src='jquery-1.4.2.js'></script>
<script type='text/javascript' src='ViewMember.js'></script>
</head>
<?php
include "utility.php"
?>
<?php
	$vars = new VARS();
	$database = new DB();
	$vars->insert_css_file();
	write_head_tag($vars);
	write_body_tag( $vars, $database);
?>
<div class="container">

<div class="top">
<h2>Current NCSA Members</h2>
</div>  <!--top div -->

<div class="side">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body">
<?php

	$query = "select year(now()) as yr, 
			month(now()) as mn,
			day(now()) as dy
		from dual";

	$database->runsql($query, 
		#1);
		$vars->get_debug());
	$row = $database->getrow();

	$renewalwindow = $row[yr]-1 . "-" . $row[mn] . "-" . $row[dy];

	$query = "select skater_first, skater_last, 
	year(skater_renewaldate) as year,
	month(skater_renewaldate) as month,
	day(skater_renewaldate) as day,

	year(skater_dob) as byear,
	month(skater_dob) as bmonth,
	day(skater_dob) as bday

	from skaters
	where association_id = 1
	and skater_renewaldate > '$renewalwindow'
	order by skater_last, skater_first";
	

	$database->runsql($query, 
		#1);
		$vars->get_debug());

	$count = 1;
	echo "<table>";
	echo "<tr><td></td><td class=\"left\"><b>Name</b></td>";
	echo "<td></td><td class=\"left\"><b>Birthdate</b></td><td class=\"left\"><b>Renewal</b></td></tr>";
	echo "<tr><td colspan=5><hr></td></tr>";
	while ($row = $database->getrow()){
		echo "<tr>";
		echo "<td class=\"left\" width=\"20px\">$count</td>"; 
		echo "<td class=\"left\" width=\"100px\">$row[skater_first]</td>"; 
		echo "<td class=\"left\" width=\"120px\">$row[skater_last]</td>"; 
		printf ("<td class=\"left\" width=\"90px\">%02d/%02d/%d</td>",$row[bmonth],$row[bday],$row[byear]);
		printf ("<td class=\"left\" width=\"90px\">%02d/%02d/%d</td>",$row[month],$row[day],$row[year]);
		echo "</tr>";
		$count++;
	}
?>


</div> <!--Body Div -->
</div>  <!--Container Div-->
</body>
</html>


