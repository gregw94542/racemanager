<?php
include "utility.php"
?>
<?php
	$vars = new VARS();
	$database = new DB();

	$sql = str_replace("\\", "", $vars->get_sql());

	$database->runsql ($sql,
		#1);
		$vars->get_debug());

	$count = 1;
	echo "<table border=0>";
	while ($row = $database->getrow()) {
		echo "<tr style=\"height: 5px;\">";

		##### figure out what keys got returned in the resultset ###
		$keys = array_keys($row);

		##### ok, now how many are there ? ######
		$array_count = count ($keys);

		#####  iterate thru the columns 
		for ($x = 0; $x < $array_count; $x++){
			$column = $keys[$x];
			
			#echo "<td class=\"left_sql\"> $row[$column]</td>";
			echo "<td class=\"left\" style=\"font-size: 10px;\"> $row[$column]</td>";
		}
		echo "<br>";
		echo "</tr>";

	}
	echo "</table>";
		
?>
