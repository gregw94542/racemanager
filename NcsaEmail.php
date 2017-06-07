<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Racer Email Addresses</title>
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
<h2>Current NCSA Email Addresses </h2>
</div>  <!--top div -->

<div class="side">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body">
<?php

	echo "<br>";
	$race_id = $vars->get_raceid();

	$query = "select skater_first , skater_last, 
		skater_email 
		from skaters
		where 
			association_id = 1
			and skater_renewaldate is not NULL 
			and skater_renewaldate >= DATE_SUB(NOW(), INTERVAL 1 YEAR)
 		order by 
			skater_last, skater_first";
	

	$database->runsql($query, 
		$vars->get_debug());
		#1);

	$emailstr = "";
	while ($row = $database->getrow()){
		$emailstr = $emailstr . "$row[skater_email];";
	}
	echo "<textarea cols=120 rows=8 class=\"email\">";
	echo "$emailstr</textarea>";
	echo "<br><p class=\"mail\"><a href=\"mailto: $emailstr\">Send EMail To Skaters</a></p>";


	$count = 1;

	echo "<table>";
	echo "<tr><td></td><td class=\"left\" colspan=1><b>Name</b></td>";
	echo "<td><b>Email</b></td></tr>";
	echo "<tr><td colspan=8><hr></td></tr>";



	### ugly hack, run sql twice so I can paint screen going down screen ###
	$database->runsql($query, 
		#1);
		$vars->get_debug());
	while ($row = $database->getrow()){

		$position = strpos($row[skater_email], '@');
		$login = substr($row[skater_email], 0, $position);
		echo "<tr>";
		echo "<td class=\"left_sm\" width=\"20px\">$count</td>"; 
		echo "<td class=\"left_sm\" width=\"200px\">$row[skater_first] $row[skater_last]</td>"; 
		echo "<td class=\"left_sm\" width=\"120px\">$row[skater_email]</td></rr>"; 
		$count++;


	}
	echo "</table>";
?>


</div> <!--Body Div -->
</div>  <!--Container Div-->
</body>
</html>


