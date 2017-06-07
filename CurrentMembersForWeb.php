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
	day(skater_dob) as bday,
	
	skater_email,
	skater_mobile, 
	skater_phone

	from skaters
	where association_id = 1
	and skater_renewaldate > '$renewalwindow'
	order by skater_last, skater_first";
	

	$database->runsql($query, 
		#1);
		$vars->get_debug());

	$count = 1;
	$filename = "/home/networki/public_ftp/Labels/CurrentMembers.csv";
	$ftp = "ftp://networkistics.com/public_ftp/Labels/CurrentMembers.csv";
	$fh = fopen($filename, 'w');
	fwrite($fh, "Name,Login,Email,Home,Mobile,Birthday,Renewal\n");

	echo "<table>";
	echo "<tr><td></td><td class=\"left\" colspan=1><b>Name</b></td>";
	echo "<td><b>Login</b></td>";
	echo "<td><b>Email</b></td><td><b>Home</b></td><td><b>Mobile</b></td>";
	echo "<td class=\"left\"><b>Birthdate</b></td><td class=\"left\"><b>Renewal</b></td></tr>";
	echo "<tr><td colspan=8><hr></td></tr>";
	while ($row = $database->getrow()){

		$position = strpos($row[skater_email], '@');
		$login = substr($row[skater_email], 0, $position);
		echo "<tr>";
		echo "<td class=\"left_sm\" width=\"20px\">$count</td>"; 
		echo "<td class=\"left_sm\" width=\"200px\">$row[skater_first] $row[skater_last]</td>"; 
		echo "<td class=\"left_sm\" width=\"100px\">$login</td>"; 
		echo "<td class=\"left_sm\" width=\"120px\">$row[skater_email]</td>"; 
		echo "<td class=\"left_sm\" width=\"120px\">$row[skater_phone]</td>"; 
		echo "<td class=\"left_sm\" width=\"120px\">$row[skater_mobile]</td>"; 
		printf ("<td class=\"left_sm\" width=\"90px\">%02d/%02d/%d</td>",$row[bmonth],$row[bday],$row[byear]);
		$bday = sprintf ("%02d/%02d/%d",$row[bmonth],$row[bday],$row[byear]);
		printf ("<td class=\"left_sm\" width=\"90px\">%02d/%02d/%d</td>",$row[month],$row[day],$row[year]);
		$renewal = sprintf ("%02d/%02d/%d",$row[month],$row[day],$row[year]);
		echo "</tr>";
		$count++;
		fwrite($fh,"$row[skater_first] $row[skater_last],$login, $row[skater_email], $row[skater_phone], $row[skater_mobile],$bday, $renewal\n");


	}
	echo "</table>";
	echo "<a href=\"$ftp\">Download CSV File for Membership</a>";
?>


</div> <!--Body Div -->
</div>  <!--Container Div-->
</body>
</html>


