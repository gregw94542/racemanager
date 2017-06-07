<html>
<link rel="stylesheet" href="networkistics.css" type="text/css">
<title> </title>
<body>
<? include ("ncsadb.php")?>
<?php
	include "utility.php"
?>

<?php
$vars = new VARS();
$database = new DB();
?>


<?php

function new_page()
{
	echo "<p STYLE=\"page-break-before:always\">&nbsp;</p>";
}


##################################################
# make_certificate
#  This function will create a PR Certificate
#
#  inputs:   
##################################################

function 	make_certificate($min,$sec,$hun,$distance,$racedate,$first,$last,$location, $association)
{
	new_page();
	echo "<div class=\"certificate\">";	### body div


	echo "<div class=\"certificate_title\">";  ### name div
	
	// ok, this is kind of a hack 
	if ( $association == 7) {
		echo "The Santa Clarita Speedskating Club certifies <br>";				
	} else {
		echo "The Northern California Speedskating Association certifies <br>";		
	}

	echo "that on $racedate ";
	echo "</div>";						### end of name div
	echo "<div class=\"certificate_location\">";  ### name div
	echo "in $location  ";
	echo "</div>";						### end of name div
	echo "<div class=\"certificate_name\">";  ### name div
	echo "$first $last";
	echo "</div>";						### end of name div

	echo "<div class=\"certificate_distance_title\">";  ### distanc div
	echo "has skated a personal record for the following distance:<br><br> ";
	echo "</div>";

	echo "<div class=\"certificate_distance\">";  ### distanc div
	printf ("%sm in the time of %02d:%02d.%02d", $distance,$min,$sec, $hun);
	echo "</div>";						### end of distance div


	echo "<div class=\"certificate_authentication\">";
	echo "_________________________________________<br>";
	// ok, this is kind of a hack 
	if ( $association == 7) {
		echo "SCSSC Official";
		echo "</div>";
		echo "<div class=\"certificate_ncsa_logo\">";

		echo "<image src=\"SCSSC.png\" width=\"160\" height=\"104\"/>";
		echo "</div>";
	} else {
		echo "NCSA Official";
		echo "</div>";
		
		echo "<div class=\"certificate_ncsa_logo\">";
		echo "<image src=\"NCSA_Logo_2008_BW.jpg\" width=\"160\" height=\"104\"/>";
		echo "</div>";

	}	
	
	







	echo "<div class=\"certificate_uss_logo\">";
	//echo "<image src=\"usspeedskating.jpg\" width=\"300\" height=\"100\"/>";
	//echo "<image src=\"uss_1_5cm.jpg\" width=\"300\" height=\"100\"/>";
	//echo "<image src=\"uss.png\" width=\"425\" height=\"100\"/>";
	//echo "<image src=\"uss.png\" width=\"318\" height=\"75\"/>";
	echo "<image src=\"uss.png\" />";
	echo "</div>";


	echo "</div>";						### end of body div

}

##################################################
# isPR
#  This function will compare a time with a skaters
#  personal record to see if they got a new PR or not
#
#  inputs:   skater, distance, race_id, min, sec, hun
#  returns: 	1 for PR
#               0 for no PR
##################################################
function isPR ($skater_id, $distance, $race_id, $rminute, $rsecond, $rhundred, $association)
{
	$retval = 0;

	###### convert race time into hundredths ###################
	$total_time = ($rminute * 60 * 100) + ($rsecond * 100) + $rhundred;
	if (!$total_time) {
		return $retval;
	}

	$conn2 = mysql_connect(get_host(), get_user(), get_pass()) ;
	mysql_select_db(get_db());

	######## Fish the race date out of the database
	$query = "select race_date ,
		  date_format(race_date, '%W, %M %d, %Y') as f
		from races where race_id = \"$race_id\"";
	$result1 = mysql_query($query);
	while ($row = mysql_fetch_array($result1, MYSQL_ASSOC)){
		$rdate = $row[race_date];
		$fdate = $row[f];
		$q = $query;
	}
	######## search through the db to find this skater's fastest time ###

	$query = "select 
		distance, min, sec, hun ,
		r.race_enable, r.race_id,
		r.race_name, 
		r.race_date, 
		skater_first, skater_last, 
		cr.race_location as location,
		bogusity
	from raw_results, divisions, races r, skaters, races cr
	where raw_results.skater_id = \"$skater_id\"
		and skaters.skater_id = raw_results.skater_id
		and distance = \"$distance\"
        	and raw_results.division_id = divisions.division_id
		and divisions.race_id = r.race_id
		and ( (min != 0) or (sec != 0) or (hun != 0))
		and r.race_date < (\"$rdate\")
		and cr.race_id = \"$race_id\"
		and r.race_enable = 1
		and bogusity = 0
	order by min, sec, hun
	limit   1 ";


	$result1 = mysql_query($query);
	mysql_close($conn2);

	while ($row = mysql_fetch_array($result1, MYSQL_ASSOC)){
		$currentpr = ($row[min] * 60 * 100) + ($row[sec] * 100) + $row[hun];

		$racedate = $row[race_date];
		$first = $row[skater_first];
		$last = $row[skater_last];
		#$location = $row[race_location];
		$location = $row[location];
		if ($total_time < $currentpr) {
			$retval = 1;
		}

		########### Negate PR if Time = 0 ############
		if (  ($rminute == 0)  && ($rsecond == 0) && (!$rhundred== 0) ){
			$retval = 0;
		}

		
	}
	if ($retval ) {
	make_certificate($rminute,$rsecond,$rhundred,$distance,$fdate ,$first,$last,$location, $association);
	#make_certificate($rminute,$rsecond,$rhundred,$distance,$racedate,$first,$last,$location);
	#echo "$rminute:$rsecond:$rhundred/$distance/$racedate/$first $last/$f<br>";
	}
	return $retval;

}

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
function total_points($div, $sid)
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


function display_race($id) {
		$conn = mysql_connect(get_host(), get_user(), get_pass()) 
			or die ('Error connecting to mysql');
		mysql_select_db(get_db());

		$query = "select race_name, race_location, 
			race_date, association_id, preliminary
			from races where race_id = $id";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result,MYSQL_ASSOC);
		$association = $row[association_id];
		
		##echo "Association = $association";


		$query = " select s.skater_id as id, r.division_id as did, s.skater_first as firstname, 
			s.skater_last as lastname, r.heatnum as heat, 
			r.min as min, r.sec as sec, r.hun as hun ,
			r.place as place, r.point as point, r.notes as notes, 
			r.total_points as total,
			d.helmet_num as helmet, 
			r.bogusity
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
		
		$result = mysql_query($query);
		mysql_close($conn);
		$current_id = "";
		$current_did = "";
		$first_time = 0;
		$old_did = 0;

		while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){	

			##################################################
			#  the division_id has just changed, print up
			# a new set of headers
			##################################################

			if ($current_did != $row[did]) {
				$current_did = $row[did];
				$skater_count = 
					get_num_skaters_in_division($row[did]);


				if ($first_time == 0) {
					$first_time++;
				} 
				###################################################################
				# Print up the division name 
				###################################################################
				$current_place = 1;

				###################################################################
				# get number of distances skated, 
				# build title row for each
				###################################################################
				$distance_count  = 
					get_num_distances_skated($row[did]);
				$d1 = $distance_count + 1;
				$distance_array  = array();
				#for ($x = 1 ; $x < $d1; $x++){
				for ($x = 1 ; $x < 5; $x++){
					$dstring = "division_distance" . $x;
					$distance = get_distance($row[did], $dstring);
					if ($distance != 0) {
						array_push($distance_array, $distance);
					}

				}

				$current_heat = 0;			## got to number of heats skated
			}
			
			###################################################################
			# Only put the skater's name in each time
			# the skater's id changes
			###################################################################
			if ($current_id != $row[id]) {
				$current_id = $row[id];
			} 


			##echo "<td class=\"info_time\">$row[min]:$row[sec].$row[hun]</td>\n";
			###################################################################
			# Check to see if the skater has skated a pr
			###################################################################
			$pr = "";
			if (!$row[bogusity]) {
				if (isPR( $row[id], $distance_array[$current_heat], $id, $row[min], $row[sec], $row[hun], $association) ){
					$pr = "*";
				}
			}

			$current_heat++;
			if ($current_heat >= $distance_count) {
				$current_heat = 0;
				$current_place++;
			}
			$first_time = 0;


		}


}

$vars =  new VARS();
$race_id = $vars->get_raceid();

##################################################
# walk thru raw results table and calculate total points
# note: this will not scale well, change later
#	possibly add code to just update based on race_id 
#	(derived from divisions)
##################################################
#total_raw_results();

##################################################
#  find this race in raw_results tables, clean it up
#  and display
##################################################
display_race($race_id);



?>


</body>
</html>
