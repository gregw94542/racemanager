<? include ("ncsadb.php")?>
<?php
	include "utility.php"
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


function display_race($id, $num_places) {
		$conn = mysql_connect(get_host(), get_user(), get_pass()) 
			or die ('Error connecting to mysql');
		mysql_select_db(get_db());

		$query = "select race_name, race_location, 
			race_date,
			association_id, preliminary
			from races where race_id = $id";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result,MYSQL_ASSOC);
		$race_name = $row[race_name];
		$racedate = $row[race_date];

		$filename = "/home/networki/public_ftp/Labels/$race_name.csv";
		$ftp = "ftp://networkistics.com/Labels/$race_name.csv";
		$fh = fopen($filename, 'w');

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
		
		$result = mysql_query($query);
		mysql_close($conn);
		$current_id = "";
		$current_did = "";
		$first_time = 0;
		$old_did = 0;
		echo "RaceName, Division, Place, Name, Age, Racedate<br>";
		fwrite($fh,  "RaceName, Division, Place, Name, Age, Racedate\n");
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
				$current_place = 1;

				###################################################################
				# get number of distances skated, 
				# build title row for each
				###################################################################
				$distance_count  = 
					get_num_distances_skated($row[did]);
				$d1 = $distance_count + 1;

				$current_heat = 0;			## got to number of heats skated
			}
			
			###################################################################
			# Only put the skater's name in each time
			# the skater's id changes
			###################################################################
			if ($current_id != $row[id]) {
				$current_id = $row[id];
				$national_division = get_age_group($row[id], $id );

				if ($current_place < ($num_places+1)) {
					echo "$race_name,$division_name,$current_place,$row[firstname] $row[lastname],$national_division,$racedate<br>";
					fwrite($fh,  "$race_name,$division_name,$current_place,$row[firstname] $row[lastname],$national_division,$racedate\n");
				}
			} 


			$current_heat++;
			if ($current_heat >= $distance_count) {
				$current_heat = 0;
				$current_place++;
			}
			$first_time = 0;


		}
		echo "<a href=\"$ftp\">Download CSV File for Label Printer</a>";
}

$vars =  new VARS();
$race_id = $vars->get_raceid();

##################################################
# walk thru raw results table and calculate total points
# note: this will not scale well, change later
#	possibly add code to just update based on race_id 
#	(derived from divisions)
##################################################
total_raw_results();

##################################################
#  find this race in raw_results tables, clean it up
#  and display
##################################################
display_race($race_id, 8);


?>


