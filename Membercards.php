<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Sync Member Renewal with USS</title>
<script type='text/javascript' src='jquery-1.4.2.js'></script>
<script type='text/javascript' src='ViewMember.js'></script>
</head>
<?php
include "utility.php"
?>
<?php
include "ncsadb.php"
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
<h2>Sync Member Renewal Dates with USS</h2>
</div>  <!--top div -->

<div class="side">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body">
<?php

	$filename ="/home/networki/public_ftp/Labels/MemberCards.csv";
	$ftp="ftp://networkistics.com/public_ftp/Labels/MemberCards.csv";
	$fh= fopen($filename,'w');
	fwrite($fh,"First,Last,Expires,Class,Joined,MemberNum,MemberType\n");

	$query = "select year(now()) as yr, 
			month(now()) as mn,
			day(now()) as dy
		from dual";

	$database->runsql($query, 
		#1);
		$vars->get_debug());
	$row = $database->getrow();

	$renewalwindow = $row[yr]-1 . "-" . $row[mn] . "-" . $row[dy];
	$renewalwindow = "2012-06-30";

	$query = "select skater_first, skater_last, 
	year(skater_renewaldate) as year,
	month(skater_renewaldate) as month,
	day(skater_renewaldate) as day,

	year(skater_dob) as byear,
	month(skater_dob) as bmonth,
	day(skater_dob) as bday,

	year(skater_joindate) as jyear,
	title,
	skater_id

	from skaters, skater_titles
	where association_id = 1
	and skater_renewaldate > date(\"$renewalwindow\")	
	and skaters.title_id = skater_titles.title_id
	order by  skater_last, skater_first";
	

	$database->runsql($query, 
		1);
		#$vars->get_debug());

	$count = 1;
	echo "<table>";
	echo "<tr><td></td><td class=\"left\"><b>Name</b></td>";
#	echo "<td></td><td class=\"left\"><b>Renewal</b></td>";
	echo "<td></td><td class=\"left\"><b>Expires</b></td>";
	echo "<td class=\"left\"><b>Class</b></td>";
	echo "<td class=\"left\"><b>Joined</b></td>";
	echo "<td class=\"left\"><b>Member#</b></td>";
	echo "<td class=\"left\"><b>MemberType#</b></td>";
	echo "</tr>";
	echo "<tr><td colspan=5><hr></td></tr>";
	while ($row = $database->getrow()){
		$age_group = calc_age_group($row[bmonth],$row[byear],7, 2012);
		echo "<tr>";
		echo "<td class=\"left\" width=\"20px\">$count</td>"; 
		echo "<td class=\"left\" width=\"100px\">$row[skater_first]</td>"; 
		echo "<td class=\"left\" width=\"120px\">$row[skater_last]</td>"; 
		#printf ("<td class=\"left\" width=\"90px\">%02d/%02d/%d</td>",$row[bmonth],$row[bday],$row[byear]);
		#printf ("<td class=\"left\" width=\"90px\">%02d/%02d/%d</td>",$row[month],$row[day],$row[year]);
		$Expires = $row[year];
		$Expires++;

		echo "<td class=\"left\" width=\"100px\">June 30,$Expires</td>";
		echo "<td class=\"left\" width=\"100px\">$age_group</td>";
		echo "<td class=\"left\" width=\"100px\">$row[jyear]</td>";
		echo "<td class=\"left\" width=\"100px\">$row[skater_id]</td>";
		echo "<td class=\"left\" width=\"100px\">$row[title]</td>";
		echo "</tr>";

		### insert code for updating skaters table
		echo "<tr>";
		echo "<td colspan=6 class=\"left_sm_sql\"></td>";
		echo "</tr>";
		### insert code for updating renewal_dates table
		echo "<tr>";
		echo "<td colspan=6 class=\"left_sm_sql\"></td>";
		echo "</tr>";
		$count++;
		fwrite($fh,"$row[skater_first],$row[skater_last],$Expires,$age_group,$row[jyear],$row[skater_id],$row[title]\n");
	}
	echo "<tr><td><a href=\"$ftp\">Download Mailmerge File</a>";
	echo "</table>";
	fclose($fh);
	
?>


</div> <!--Body Div -->
</div>  <!--Container Div-->
</body>
</html>


