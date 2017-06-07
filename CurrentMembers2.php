<?php
include "utility.php"
?>
<?php
	$vars = new VARS();
	$database = new DB();
?>



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
	$sort = $vars->get_sort();
	$orderby = "order by skater_first, skater_last";

	if ($sort == "last") {
		$orderby = "order by skater_last, skater_first";
	}  else if ($sort == "birth") {
		$orderby = "order by skater_dob";
	}   else if ($sort == "renewal") {
		$orderby = "order by skater_renewaldate, skater_last, skater_first";
	}   else if ($sort == "gender") {
		$orderby = "order by skater_sex, skater_dob, skater_last, skater_first";
	}

	$query = "select skater_first, skater_last, 
	year(skater_renewaldate) as year,
	month(skater_renewaldate) as month,
	day(skater_renewaldate) as day,
	skater_sex,


	year(skater_dob) as byear,
	month(skater_dob) as bmonth,
	day(skater_dob) as bday,
	skater_email as email


	from skaters
	where association_id = 1
	and skater_renewaldate > '$renewalwindow' "  . $orderby;
	

	$database->runsql($query, 
		#1);
		$vars->get_debug());

	$count = 1;
	echo "<table border=0>";
	echo "<tr><td></td><td class=\"left_sm\"><b>Name</b></td>";
	echo "<td></td><td class=\"left_sm\"><b>Birthdate</b></td><td class=\"left_sm\"><b>Renewal</b></td><td class=\"left_sm\">Gender</td></tr>";
	echo "<tr><td colspan=6><hr></td></tr>";
	while ($row = $database->getrow()){
		echo "<tr>";
		echo "<td class=\"left_sm\" width=\"30px\">$count</td>"; 
		echo "<td class=\"left_sm\" width=\"100px\">$row[skater_first]</td>"; 
		echo "<td class=\"left_sm\" width=\"120px\">$row[skater_last]</td>"; 
		printf ("<td class=\"left_sm\" width=\"120px\">%02d/%02d/%d</td>",$row[bmonth],$row[bday],$row[byear]);
		printf ("<td class=\"left_sm\" width=\"120px\">%02d/%02d/%d</td>",$row[month],$row[day],$row[year]);
		echo "<td class=\"left_sm\" width=\"20px\">$row[skater_sex]</td>"; 
		echo "<td class=\"left_sm\" width=\"20px\">$row[email]</td>"; 
		echo "</tr>";
		$count++;
	}
?>


