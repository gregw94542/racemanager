<?php
include "utility.php"
?>
<?php
	$vars = new VARS();
	$database = new DB();
	$first = $vars->get_firstname();
	$last = $vars->get_lastname();


	$database->runsql ("
		select 
			 skater_first, skater_last
		from skaters
		where skater_first like '$first%' and
                      skater_last like '$last%'
		order by skater_first, skater_last",
		$vars->get_debug());

	echo "Possible Matches<hr>";
	echo "<table border=0>";
	$count = 1;
	while ($row = $database->getrow()) {
		echo "<tr>";
		echo "<td class=\"left_sm\"> $row[skater_first] $row[skater_last]</td>";
		echo "</tr>";
	}
	echo "</table>";
		
?>
