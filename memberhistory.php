<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>View/Change Members</title>
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
<h2>Membership History </h2>
</div>  <!--top div -->

<div class="side">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body">
<?php
	$session_id = $vars->get_sessionid();
	echo "<input type=HIDDEN name='session_id' id='SESSION_ID' value='$session_id'>";
	$skater_id = $vars->get_skaterid();

	$sql = "select skater_first, skater_last from skaters
			where skater_id = $skater_id";
	$database->runsql($sql, 
		#1);
		$vars->get_debug());
	$row = $database->getrow();
	echo "<p style='text-align:left;'><b>&nbsp;&nbsp;Payment History for: $row[skater_first] $row[skater_last]</b></p>";

	$sql = "select 
			day(renewal_entered_date) as reday,
			month(renewal_entered_date) as remonth,
			year(renewal_entered_date) as reyear,

			day(renewal_date) as rday,
			month(renewal_date) as rmonth,
			year(renewal_date) as ryear,

			renewal_amount,
			renewal_id_addr,
			skater_first as a_first, 
			skater_last as a_last

		from renewal_dates r, skaters s
		where r.skater_id = $skater_id
			and s.skater_id = $skater_id
		order by renewal_entered_date";
	$database->runsql($sql, 
	#1);
	$vars->get_debug());

	echo "<table>";
	echo "<tr>";
	echo "<th style='width:20px;'></th>";
	echo "<th style='width:100px;'>Date Entered </th>";
	echo "<th style='width:100px;'>Renewal From</th>";
	echo "<th style='width:120px;'>Renewal Amount</th>";
	echo "<th style='width:120px;'>Entered By</th>";
	echo "</tr>";
	$count = 1;
	while ( $row = $database->getrow()) {
		echo "<tr>";
		echo "<td>$count</td>";
		echo "<td>$row[remonth]/$row[reday]/$row[reyear]</td>";
		echo "<td>$row[rmonth]/$row[rday]/$row[ryear]</td>";
		echo "<td>$$row[renewal_amount]</td>";
		echo "<td>$row[a_first] $row[a_last]</td>";
		echo "</tr>";
		$count++;
	}


	echo "</table>";

?>

</div>  <!--Container Div-->
</body>
</html>


