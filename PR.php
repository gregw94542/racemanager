
<html>
<?php
include "ncsadb.php"
?>
<?php
include "utility.php"
?>


<?php
	$vars = new VARS();
	$database = new DB();
	$vars->insert_css_file();

function print_pr($s, $d, $rd, $database){
	#$database1 = new DB();
	$dd = date($rd);

	$sql = "select r.race_id, r.race_name, 
		 r.race_date, d.division_name,
		 rr.heatnum, 
		 rr.min, rr.sec, rr.hun
		 from races r , division_skaters ds,
			divisions d, raw_results rr
		 where race_enable = 1
		  and ds.race_id = r.race_id
		  and ds.skater_id = '$s'
		  and d.race_id = d.race_id
		  and ds.division_id = d.division_id
		  and rr.division_id = d.division_id
		  and ds.skater_id = rr.skater_id
		  and r.race_date < '$dd'
		  and (d.division_distance1 = '$d'
		       or d.division_distance2 = '$d'
		       or d.division_distance3 = '$d'
		       or d.division_distance4 = '$d'
		       or d.division_distance5 = '$d'
		       or d.division_distance6 = '$d'
                      )
		  order by r.race_date
			
		";
	$database->runsql($sql, 1);
	echo "<table>";
	while ($row = $database->getrow()) {
		echo "<tr>";
		echo "<td style=\"width: 210px;\" class=\"left_sm\">$row[race_name]</td>";
		echo "<td style=\"width: 110px;\" class=\"left_sm\">$row[race_date]</td>"; 
		echo "<td style=\"width: 160px;\"  class=\"left_sm\">$row[division_name]</td>"; 
		echo "<td class=\"left_sm\">id: $row[race_id] </td>";
		echo "<td style=\"width: 100px;\"  class=\"left_sm\">heat: $row[heatnum]</td>";
		echo "<td style=\"width: 150px;\"  class=\"left_sm\">$row[min]:$row[sec]:$row[hun]</td>";
		echo "</tr>";
	}
	echo "</table>";


	for ($x = 1 ; $x < 7 ; $x++) {
	$sql = "select r.race_name, d.division_name, d.division_distance$x as distance, rr.skater_id, rr.min, rr.sec, rr.hun,
			s.skater_first, s.skater_last, 
			rr.raw_id, rr.heatnum, rr.distance as newdistance
		from races r, divisions d, raw_results rr, skaters s
		where
			r.race_id  in (select race_id from races where race_enable = 1)
			and rr.skater_id = s.skater_id
			and d.race_id = r.race_id
			and rr.division_id = d.division_id
			and rr.heatnum  = $x
		order by rr.raw_id
		
	";

	$database->runsql($sql, 1);

	echo "<table border=1>";
	while ($row = $database->getrow()) {
		#$sql = "update raw_results 
			  #set distance=\"$row[distance]\"
			#where raw_id = \"$row[raw_id]\"";
		#$database1->runsql($sql, 1);
		echo "<tr>";
		echo "<td style=\"width: 210px;\" class=\"left_sm\">$row[race_name]</td>";
		echo "<td style=\"width: 110px;\" class=\"left_sm\">$row[division_name]</td>"; 
		echo "<td style=\"width: 60px;\"  class=\"left_sm\">$row[distance]</td>"; 
		echo "<td style=\"width: 60px;\"  class=\"left_sm\">$row[newdistance]</td>"; 
		echo "<td class=\"left_sm\">$row[skater_first] $row[skater_last] </td>";
		echo "<td class=\"left_sm\">$row[raw_id] </td>";
		echo "<td class=\"left_sm\">$row[heatnum] </td>";
		echo "<td style=\"width: 30px;\"  class=\"left_sm\">$row[min]:$row[sec]:$row[hun]</td>";
	#	echo "<td style=\"width: 130px;\"  class=\"left_sm\">$sql</td>";
		echo "</tr>";


	}
	echo "</table>";
	}

		
}
?>

<title>PR Work Area </title>
<div class="container">

<div class="top">
<h2>Race Manager</h2>
PR Workarea
</div>  <!--top div -->


<div class="side" style="height: 730px;">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body" style="text-align: left; padding: 10px; margin: 10px;">
<?php
	$skater = "1";
	$distance = "1000";
	$rdate = "2010-10-28";
	print_pr($skater, $distance, $rdate, $database);
?>
</div> <!--Body Div -->
</div>  <!--Container Div-->


</div>  
</body>
</html>
