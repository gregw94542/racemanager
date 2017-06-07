<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager - Generate Results</title>
<body>
<? include ("ncsadb.php")?>


<?php

function display_virtual($race_id)
{
$current_skater_id = 0;
	$race_name = get_race($race_id);
	echo "<h1>Age Group Results for $race_name</h1>";

	$conn = mysql_connect(get_host(), get_user(), get_pass()) ;
	mysql_select_db(get_db());
	$query = " select skater_first, skater_last, division_name,  
		min, sec, hun, point, skater_dob, heatnum, skaters.skater_id
		from raw_results, skaters, divisions
		where raw_results.division_id in 
	    		(select division_id 
				from divisions
				where race_id = $race_id)
		and raw_results.skater_id = skaters.skater_id
		and raw_results.division_id = divisions.division_id
		order by skaters.skater_dob, heatnum" ;


	$result = mysql_query($query);
	echo "<table border=0>";
	echo "<tr>";
	echo "<td>First</td>";
	echo "<td>Last</td>";
	echo "<td>Div</td>";
	echo "<td>Class</td>";
	echo "<td>Heat</td>";
	echo "<td>Pts</td>";
	echo "<td>Time</td>";
	echo "</tr>";
	$total_points = 0;
	while ($row = mysql_fetch_array($result,MYSQL_ASSOC)){
		echo "<tr>";
		if ($current_skater_id != $row[skater_id]){
			if ($total_points != 0) {
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>Total</td>";
				echo "<td>$total_points</td>";
				echo "<td>&nbsp;</td>";
				echo "</tr><tr>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "</tr><tr>";

				$total_points = 0;
			}
			echo "<td>$row[skater_first]</td>";
			echo "<td>$row[skater_last]</td>";
			echo "<td>&nbsp;&nbsp;$row[division_name]&nbsp;&nbsp;</td>";
			#echo "<td>&nbsp;&nbsp;$row[skater_dob]&nbsp;&nbsp;</td>";
			$age_group = get_age_group($row[skater_id], $race_id);
			echo "<td>&nbsp;&nbsp;$age_group&nbsp;&nbsp;</td>";
			$current_skater_id = $row[skater_id];
		} else {
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
		}
		echo "<td>&nbsp;&nbsp;$row[heatnum]&nbsp;&nbsp;</td>";
		echo "<td>$row[point]</td>";
		echo "<td>$row[min]:$row[sec]:$row[hun]</td>";
		$total_points += $row[point];
		
		echo "</tr>";
	};

	if  ($total_points != 0) {
		echo "<tr>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "<td>Total</td>";
		echo "<td>$total_points</td>";
		echo "<td>&nbsp;</td>";
		echo "</tr>";
	}
	mysql_close($conn);
	echo "</tr></table>";
}

##################################################
display_virtual($_POST[RACE_ID]);

echo "<a href=racemanager.php?RACE_ID=$race_id>Back</a>";


?>


</body>
</html>
