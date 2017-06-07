<?php
include "utility.php"
?>
<? include ("ncsadb.php")?>
<?php
	$vars = new VARS();
	$database = new DB();
?>
<?php



function pick($db,$v) {
	$sql = "select skater_first, skater_last, skater_id
		from skaters
		where is_active = 1
		order by skater_first, skater_last ";
 	//$db->runsql($sql, $v->get_debug()); 
	$db->runsql($sql, 0);
	
	$count = 0;
	echo "<table>";
	echo "<tr><td colspan=5>Select  Skaters In Race From Here</td></tr><tr>";
	while ($row = $db->getrow()){
		if (!($count % 6)){
		    echo "</tr><tr>";
		}
		echo "<td class=\"hat\" id=\"$row[skater_id]\" hat_id=\"$row[skater_id]\">
		   <p>$row[skater_first] $row[skater_last]</></p></td>";
		   
		   //<input type=\"checkbox\" check_id=\"$row[skater_id]\" hat_id=\"$row[skater_id]\">

		$count++;
	}
	echo "</tr></table>";
}
 
function get_group_color($NATIONAL_CLASS)
{
	

	$retval = "red";
	if (!(strcmp($NATIONAL_CLASS,"TT"))) {
		$retval = "red";
	} elseif (!(strcmp($NATIONAL_CLASS,"Pny"))){
		$retval = "red";
	} elseif (!(strcmp($NATIONAL_CLASS,"Mgt"))){
		$retval = "green";
	} elseif (!(strcmp($NATIONAL_CLASS,"Jr C"))){
		$retval = "green";
	} elseif (!(strcmp($NATIONAL_CLASS,"Jr B"))){
		$retval = "blue";	
	} elseif (!(strcmp($NATIONAL_CLASS,"Jr A"))){
		$retval = "blue";
	} elseif (!(strcmp($NATIONAL_CLASS,"Sr"))){
		$retval = "blue";
	} elseif (!(strcmp($NATIONAL_CLASS,"M30"))){
		$retval = "blue";
	} elseif (!(strcmp($NATIONAL_CLASS,"M40"))){
		$retval = "blue";
	} elseif (!(strcmp($NATIONAL_CLASS,"M50"))){
		$retval = "blue";
	} elseif (!(strcmp($NATIONAL_CLASS,"M60"))){
		$retval = "blue";
	} elseif (!(strcmp($NATIONAL_CLASS,"M70"))){
		$retval = "blue";	
	}
	return $retval;
	
}
function skaters_in_race_url($db,$v,$raceid, $windowsize, $years) {
	$sql = "select skater_first, skater_last, skater_id
		from skaters
		where is_active = 1
		order by skater_first, skater_last";
	$db->runsql($sql, 0); 
	
	$count = 0;
	

	$array = array();
	while ($row = $db->getrow()){
				
		$national_division = get_age_group($row[skater_id], $raceid);
		$score = get_skater_score($row[skater_id], $windowsize, $years, false);
		$color = get_group_color($national_division);
				
		$thisSkater = array(
		    "first_name" => $row[skater_first],
		    "last_name" => $row[skater_last],
			"skater_id" => $row[skater_id],
			"division" => $national_division,
			"score"=> $score,
			"checked" => "false",
			"color" => $color,
		);
		array_push($array, $thisSkater);
	}
	echo json_encode($array);
}

function skaters_in_debug($db,$v,$raceid, $windowsize, $years, $debug) {
	$sql = "select skater_first, skater_last, skater_id
		from skaters
		where is_active = 1
		order by skater_first, skater_last";
	$db->runsql($sql, 0); 
	
	$count = 0;
	

	$array = array();
	echo "<table border=1>";
	while ($row = $db->getrow()){
				
		$national_division = get_age_group($row[skater_id], $raceid);
		$score = get_skater_score($row[skater_id], $windowsize, $years, $debug);
		
		echo "<td class=\"debug\">" . $row[skater_first] . "</td>";
		echo "<td class=\"debug\">" . $row[skater_last] . "</td>";
		echo "<td class=\"debug\">" . $national_division . "</td>";		
		echo "<td class=\"debug\">" . $score . "</td>";		
		echo "</tr>";
	}
	echo "</table>";
}


	

$keys1 = array_keys($_GET);
foreach ($keys1 as $vars) {
	echo "GET $vars = $_GET[$vars]<br>";
}

if ($_GET[MODE] == "pick"){
	pick($database,$vars);
} elseif ($_GET[MODE] == "skaters_in_race"){
	skaters_in_race_url($database,$vars, $_GET[RACEID], $_GET[COUNT]);
} elseif ($_GET[MODE] == "skaters_in_url"){
	skaters_in_race_url($database,$vars, $_GET[RACEID], $_GET[COUNT], $_GET[YEARS]);
} elseif ($_GET[MODE] == "skaters_in_debug"){
	skaters_in_debug($database,$vars, $_GET[RACEID], $_GET[COUNT], $_GET[YEARS], $_GET[DEBUG]);
} 





?>
