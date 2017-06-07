<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager - Generate Results</title>
<body>
<? include ("ncsadb.php")?>
<?php
	include "utility.php"
?>

<?php
	include "USS-AdjustTimes.php";
?>

<?php
$vars = new VARS();
$database = new DB();
?>


<?php

##################################################
# update_skater_total
# this code goes into raw_results and totals up the 
# number of points that a skater has earned when they
# skated in a race
#
# a skaters results are stored in raw_results
#   referenced by skater_id, division_id (race + division within race)
#   doing this simplifies generation of final results
##################################################
function update_skater_total($div, $sid, $total)
{
	$query = "update raw_results 
	   set total_points=$total
	   where division_id = $div and
	         skater_id = $sid";
	#$database->runsql($query);
	run_query_no_result($query);
 
}

##################################################
# total points
#    sum up the pointd that a skater in a division has
##################################################
function total_points ($div, $sid)
{
	$conn1 = mysql_connect(get_host(), get_user(), get_pass()) ;
	mysql_select_db(get_db());
	$query2 = "select sum(point) as tot from raw_results 
           where division_id=$div and
                 skater_id = $sid";
	$result1 = mysql_query($query2);
	mysql_close($conn1);
	$pointrow  = mysql_fetch_array($result1,MYSQL_ASSOC);
	update_skater_total($div, $sid, $pointrow[tot]);
}

function total_pointsx($div, $sid) 
{
	$conn1 = mysql_connect(get_host(), get_user(), get_pass()) ;
	mysql_select_db(get_db());
	$query = "update raw_results 
	   set total_points=(select sum(point) from raw_results
		where division_id = $div and
		skater_id = $sid)
	   where division_id = $div and
	         skater_id = $sid";
	$result1 = mysql_query($query);


	mysql_close($conn1);
}
function total_pointsz ($div, $sid)
{
	$conn1 = mysql_connect(get_host(), get_user(), get_pass()) ;
	mysql_select_db(get_db());
	$query2 = "select sum(point) as tot from raw_results 
           where division_id=$div and
                 skater_id = $sid";
	$result1 = mysql_query($query2);
	$pointrow  = mysql_fetch_array($result1,MYSQL_ASSOC);
	$query2 = "update raw_results 
	   set total_points=$pointrow[tot]
	   where division_id = $div and
	         skater_id = $sid";
	#echo $query2;
	$result1 = mysql_query($query2);
	mysql_close($conn1);
}


function display_notes_for_division($did)
{
	$conn2 = mysql_connect(get_host(), get_user(), get_pass()) ;
	mysql_select_db(get_db());
	$query = "select heatnum, notes 
		from raw_results
		where division_id = $did
		and notes <> \"\"
	";
	$result1 = mysql_query($query);
	mysql_close($conn2);
	while ($row = mysql_fetch_array($result1, MYSQL_ASSOC)){
	echo "<tr><td class=\"notes\" colspan= 10>*- Distance $row[heatnum]: $row[notes]</td></tr>";
	}
}


##################################################
# total_raw_results
#    walk thru raw_results table and calculate total 
#    points for each skater in each division,
#
#   this will no scale well, need to add race_id
#   so that we only calculate the needed data
#   no time to do this right now.
##################################################

function total_raw_results()
{
	$conn = mysql_connect(get_host(), get_user(), get_pass()) ;
	mysql_select_db(get_db());
	$query = "select distinct division_id from raw_results order by division_id";
	$result = mysql_query($query);
	mysql_close($conn);
	while ( $divs = mysql_fetch_array($result,MYSQL_ASSOC)){
		$conn = mysql_connect(get_host(), get_user(), get_pass()) ;
		mysql_select_db(get_db());
		$query = "select distinct skater_id from raw_results
			where division_id = $divs[division_id]";
		$s_result = mysql_query($query);
		mysql_close($conn);
		while ( $ids = mysql_fetch_array($s_result,MYSQL_ASSOC)){
			total_points($divs[division_id],$ids[skater_id]);
		}
	}
}

##################################################
#  get_num_skaters_in_division
#    I home the function name says it all
##################################################
function get_num_skaters_in_division($id)
{
	$conn = mysql_connect(get_host(), get_user(), get_pass()) ;
	mysql_select_db(get_db());
	$query = "select count(*) as count
		from division_skaters 
		where division_id = $id";
	 $result = mysql_query($query);
	$d_row = mysql_fetch_array($result,MYSQL_ASSOC);
	mysql_close($conn);

	return "$d_row[count]";
}

##################################################
#  get_num_distances_skated
#    I home the function name says it all
##################################################
function get_num_distances_skated($id)
{
	$conn = mysql_connect(get_host(), get_user(), get_pass()) ;
	mysql_select_db(get_db());
	$query = "select division_distance1 as d1,
		division_distance2 as d2,
		division_distance3 as d3,
		division_distance4 as d4,
		division_distance5 as d5,
		division_distance6 as d6
		from divisions
		where division_id = $id";
	 $result = mysql_query($query);
	$d_row = mysql_fetch_array($result,MYSQL_ASSOC);
	mysql_close($conn);
	
	##################################################
	# count the non null columns
	##################################################

	$count = 0;
	if ($d_row[d1] != NULL && $d_row[d1] != 0)
		$count++;
	if ($d_row[d2] != NULL && $d_row[d2] != 0)
		$count++;
	if ($d_row[d3] != NULL && $d_row[d3] != 0)
		$count++;
	if ($d_row[d4] != NULL && $d_row[d4] != 0)
		$count++;
	if ($d_row[d5] != NULL && $d_row[d5] != 0)
		$count++;
	if ($d_row[d6] != NULL && $d_row[d6] != 0)
		$count++;

	return "$count";
}

##################################################
# returned distance skated for a heat in a race
##################################################
function get_distance($id, $distance)
{
	$conn = mysql_connect(get_host(), get_user(), get_pass()) ;
	mysql_select_db(get_db());
	$query = "select $distance from 
		divisions where division_id = $id";
	 $result = mysql_query($query);
	$d_row = mysql_fetch_array($result,MYSQL_ASSOC);
	mysql_close($conn);
	return "$d_row[$distance]";
}

function get_division_name($id)
{
	$conn = mysql_connect(get_host(), get_user(), get_pass()) ;
	mysql_select_db(get_db());
	$query = "select division_name from 
		divisions where division_id = $id";
	 $result = mysql_query($query);
	$d_row = mysql_fetch_array($result,MYSQL_ASSOC);
	mysql_close($conn);
	return "$d_row[division_name]";
}

function display_points_footer($mode)
{
   echo "\n<p style=\"color:blue; font-size: 9px;\">";
   echo "points - ";
   echo "1st-(34), ";
   echo "2nd-(21), ";
   echo "3rd-(13), ";
   echo "4th-(8), ";
   echo "5th-(5), ";
   echo "6th-(3), ";
   echo "7th-(2), ";
   echo "8th-(1) <br><br>";
   echo "All times are MANUAL.<br>"; 


   echo "Age Groups: TT 0-6, PW 7-8, Pny 9-10, Mgt 11-12, Jr C 13-14, Jr B 15-16, Jr A 17-18, Sr 19-29, M30 30-39, M40 40-49, M50 50-59, M60 60-69, M70 70+";

   if ($mode == "USS") {
	echo "<br>For official purposes: all race times have been adjusted by .2 seconds to account for hand timing descrepancies";
   } else {
	echo "<br>The posted times are not acceptable as USS qualifying times";
   }
	echo "</p>";

}



function display_race($id, $mode) {
		$conn = mysql_connect(get_host(), get_user(), get_pass()) 
			or die ('Error connecting to mysql');
		mysql_select_db(get_db());

		$query = "select race_name, race_location, 
			race_date, association_id, preliminary
			from races where race_id = $id";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result,MYSQL_ASSOC);
		#echo "<div>";		### main div
		
			// if sanctioned race, display USS Logo
			if ($mode == "USS"){
				echo "<div style=\"float:right;position:absolute; 
					left:10;top:10;width:200;height:100\">";
				echo "<img src=\"uss.png\" >";
				echo "</div>";
				
				echo "<div align=\"center\" style=\"width:250px;position:absolute;height:125;left:250;top:10\"><b>";
				if ($row[preliminary] == 1) {
					echo "PRELIMINARY RESULTS<br>";
				}
				echo "$row[race_name]<br>
				$row[race_location]<br>
				$row[race_date]";
				if ($row[preliminary] == 1) {
					echo "<br>PRELIMINARY RESULTS";
				}
				echo "<br>Sanctioned by USS";
					
				echo "</b>";
				echo "</div>";
				
				
			} else {
				### title div
				echo "<div align=\"left\" style=\"width:250px;height:125\"><b>";
				if ($row[preliminary] == 1) {
					echo "PRELIMINARY RESULTS<br>";
				}
				echo "$row[race_name]<br>
				$row[race_location]<br>
				$row[race_date]";
				if ($row[preliminary] == 1) {
					echo "<br>PRELIMINARY RESULTS";
				}
					
				echo "</b>";
				echo "</div>";
			}
				

			## logo div
			if (is_states($row[association_id])){
				echo "<div style=\"float:right;position:absolute; 
						left:150;top:20;width:275;height:125\">";
				echo "<img src=\"NCSA_Logo_2008.jpg\" width=\"100\" height=\"68\">&nbsp;";
				echo "</div>";
				echo "<div style=\"float:right;position:absolute; 
						left:570;top:20;width:275;height:125\">";
				##echo "<img src=\"scssa_small.gif\" width=\"100\" height=\"68\">";
				echo "<img src=\"SCSS-Logo.png\" width=\"100\" height=\"68\">";
			} else if (is_ncsa($row[association_id])) {

				echo "<div style=\"float:right;position:absolute; 
					left:700;top:10;width:200;height:100\">";
				echo "<img src=\"NCSA_Logo_2008.jpg\" width=\"150px\" height=\"100px\">";
			} else if (is_scssa($row[association_id])){
				echo "<div style=\"float:right;position:absolute; 
					left:700;top:10;width:200;height:100\">";
				echo "<img src=\"scssa_small.gif\" width=\"150px\" height=\"100px\">";
			} else if (is_scssc($row[association_id])){
				echo "<div style=\"float:right;position:absolute; 
					left:700;top:10;width:200;height:100\">";
				echo "<image src=\"SCSSC.png\" width=\"160\" height=\"104\"/>";
			}
			echo "</div>";

		### end main div
		echo "</div>";		### end main div

		$query = " select s.skater_id as id, r.division_id as did, s.skater_first as firstname, 
			s.skater_last as lastname, r.heatnum as heat, 
			r.min as min, r.sec as sec, r.hun as hun ,
			r.place as place, r.point as point, r.notes as notes, 
			r.total_points as total,
			d.helmet_num as helmet
		from raw_results r , skaters s, division_skaters d
		where s.skater_id = r.skater_id and
      		r.heatnum in (1,2,3,4) and
      		r.division_id in (select division_id from divisions
                 		where race_id = $id) and
		d.race_id = $id and
		d.skater_id = r.skater_id
		
		order by r.division_id ,
			total desc,
			s.skater_last, 
			s.skater_first, 
			r.heatnum
			";
		
		#echo "$query<br>";
		$result = mysql_query($query);
		mysql_close($conn);
		$current_id = "";
		$current_did = "";
		$first_time = 0;
		$old_did = 0;
		echo "<div style=\"float:right;position:absolute; 
				left:10;top:120;width:700\">";
		echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr>";
		while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){	

			##################################################
			#  the division_id has just changed, print up
			# a new set of headers
			##################################################

			if ($current_did != $row[did]) {
				$current_did = $row[did];
				$skater_count = 
					get_num_skaters_in_division($row[did]);

				$division_name = get_division_name($row[did]);

				if ($first_time == 0) {
					$first_time++;
				} 
				###################################################################
				# Print up the division name 
				###################################################################
				echo "</tr><tr><td>&nbsp</td></tr>";
				#echo "</tr>";
				echo "<tr><td colspan=5><b>$division_name</b></td></tr>\n";
				$current_place = 1;

				###################################################################
				# get number of distances skated, 
				# build title row for each
				###################################################################
				$distance_count  = 
					get_num_distances_skated($row[did]);
				$d1 = $distance_count + 1;
				echo "<tr><td class=\"r_title\" width=20px>&nbsp;</td> 
				   <td class=\"r_title\" width=200px>&nbsp;</td>
				   <td class=\"r_title\" width=40px>&nbsp;</td>\n";
				for ($x = 1 ; $x < $d1; $x++){
					$dstring = "division_distance" . $x;
					$distance = get_distance($row[did], $dstring);
					echo "<td class=\"r_title\" width=100px >$distance</td>
				      <td class=\"r_title\" width=40px>pl</td>
			    	      <td class=\"r_title\" width=40px>pts</td>";
				}
				echo "<td class=\"r_title\" width=40px>total</td></tr>";

				$current_heat = 0;			## got to number of heats skated
			}
			
			###################################################################
			# Only put the skater's name in each time
			# the skater's id changes
			###################################################################
			if ($current_id != $row[id]) {
				$current_id = $row[id];
				echo "\n<tr><td class=\"l_info\">$current_place</td><td class=\"l_info\" width=450px>$row[firstname] $row[lastname]";
				if ($row[helmet] != NULL) {
					echo "&nbsp;&nbsp;($row[helmet])";
				}
				echo "</td>";
				$national_division = get_age_group($row[id], $id );
				echo "<td class=\"l_info\">$national_division</td>";
			} 


			##echo "<td class=\"info_time\">$row[min]:$row[sec].$row[hun]</td>\n";
			
			
			adjust_times ($mode, $row[min],$row[sec],$row[hun]);	
			##printf ("<td class=\"info_time\">%d:%02d:%02d</td>", $row[min],$row[sec],$row[hun]);

			if ($row[place] == 'dq') {
				$row[place] = 'pen';
			}

			echo "<td class=\"info\">$row[place]</td>";
			echo "<td class=\"info\">$row[point]</td>";
			$current_heat++;
			if ($current_heat >= $distance_count) {
				echo "<td class=\"info\">$row[total]</td></tr>";
				$current_heat = 0;
				$current_place++;
			}
			$first_time = 0;


			if ($current_place > $skater_count) {
				display_notes_for_division($row[did]);
			}
		}

		echo "<td class=\"info\">$row[total] </td>";
		echo "</tr></table>";

}

$vars =  new VARS();
$result_mode = $_GET[resultmode];
$race_id = $vars->get_raceid();


##################################################
# walk thru raw results table and calculate total points
# note: this will not scale well, change later
#	possibly add code to just update based on race_id 
#	(derived from divisions)
##################################################
fix_raw();
total_raw_results();

##################################################
#  find this race in raw_results tables, clean it up
#  and display
##################################################
display_race($race_id,$result_mode);
display_points_footer($result_mode);


echo "<a href=racemanager.php?RACE_ID=$race_id>Back</a>";
echo "</div>";

?>


</body>
</html>
