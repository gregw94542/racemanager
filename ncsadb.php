<?php
function get_host(){ return 'localhost'; }
function get_user(){ return 'networki_ncsa';}
function get_pass(){ return '06ncsa17';}
function get_db()  { return 'networki_ncsa';}


function get_working_directory(){
	echo "dev";
	#echo "SalesDemo";
}
function get_last_field(){
	return "ZZZZZZ";
}

function get_delimiter(){
	return "%--%";
}
 
function get_records_per_page(){
	return 5;
}

function csv_encode( $my_string) {
	
	$my_result  =  ereg_replace("\"", "\"\"", $my_string);
	$return = "\"" . $my_result . "\"";
	return  $return ;
}

function strip_leading_zeros( $my_string)
{
	$num = intval($my_string);
	$retval = strval($num);
	return $retval;
}

function strip_leading_zeros_hun( $my_string)
{
	$num = intval($my_string);
	$retval = strval($num);
	return $retval;
}

#####################################################################
# these functions check to see if we are in the context of a specific
# association
#
# implementation is hokey, but I'm in Kamakaze mode
#####################################################################
function is_ncsa ($id)
{
	$retval = 0;
	if ($id == 1) {
		$retval = 1;
	}
	return $retval;
}

function is_scssa($id)
{
	$retval = 0;
	if ($id == 4) {
		$retval = 1;
	}
	return $retval;
}
function is_scssc($id)
{
	$retval = 0;
	if ($id == 7) {
		$retval = 1;
	}
	return $retval;
}

function is_states($id)
{
	$retval = 0;
	if ($id == 6) {
		$retval = 1;
	}
	return $retval;
}


function display_query_in_table( $my_query) {
	$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	$result = mysql_query($my_query);
	echo "<table border=2>";

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		echo "<tr>";
		$keys = array_keys($row);
		foreach ($keys as $vars){
			echo "<td>$row[$vars]</td>";
		}
		echo "</tr>";
	}
	mysql_close($conn);
	echo "</table>";
}

function get_skater($hidden)
{

	$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	$query = "select skater_first from skaters where skater_id  = '$hidden'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$keys = array_keys($row);
	mysql_close($conn);
	return $row[$keys[0]];
}

function get_skater_name($hidden)
{

	$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	$query = "select skater_first, skater_last from skaters where skater_id  = '$hidden'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$keys = array_keys($row);
	mysql_close($conn);
	$retval = $row[skater_first] . ' ' . $row[skater_last] ;
	return $retval;
}

function get_division($hidden)
{
	$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	$query = "select division_name from divisions where division_id = '$hidden'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$keys = array_keys($row);
	mysql_close($conn);
	return $row[$keys[0]];
}

function get_race($hidden)
{
	$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	$query = "select race_name from races where race_id = '$hidden'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$keys = array_keys($row);
	mysql_close($conn);
	return $row[$keys[0]];
}

function run_query_no_result($query)
{
	$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	$result = mysql_query($query);
	mysql_close($conn);
}

function get_last_insert_value()
{
	$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
	$query = "select last_insert_id() from dual";
	
	mysql_select_db(get_db());
	$result = mysql_query($query);
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	$keys = array_keys($row);
	mysql_close($conn);
	return( $row[$keys[0]]);
	
}
function calc_age_group( $BMONTH, $BYEAR, $RMONTH,$RYEAR)
{
	############################################################
	#  if birthmonth is June or earlier, calc on this year
        #  else, use next year for calculation
	############################################################

	$CALCYEAR=$RYEAR;
	if ($RMONTH < 6) {	
	 	$RYEAR--;
	} 
	
	#if ($BMONTH > 6){
	# 	$RYEAR--;
	#}
	##############################################################
	# Gene's corrections for the age calculation
	##############################################################
	if ($BMONTH >= 7) {
		$BYEAR++;
	}


	if ($BMONTH == 0  || $BYEAR == 0){
		return "--";
	}

	$NATIONALS_AGE=$RYEAR - $BYEAR;
	##echo "Nationals Age = $NATIONALS_AGE<br>";

	#if ($NATIONALS_AGE <= 10 ) {
		#$NATIONAL_CLASS = "Pony";
        if ($NATIONALS_AGE <= 6) {
		$NATIONAL_CLASS = "TT";
	} elseif ($NATIONALS_AGE >= 7 && $NATIONALS_AGE <= 8){
		$NATIONAL_CLASS = "PW";
	} elseif ($NATIONALS_AGE >= 9 && $NATIONALS_AGE <= 10){
		$NATIONAL_CLASS = "Jr-E";
	} elseif ($NATIONALS_AGE >= 11 && $NATIONALS_AGE <= 12){
		$NATIONAL_CLASS = "Jr-D";
	} elseif ($NATIONALS_AGE >= 13 && $NATIONALS_AGE <= 14){
		$NATIONAL_CLASS = "Juv";
		$NATIONAL_CLASS = "Jr-C";
	} elseif ($NATIONALS_AGE >= 15 && $NATIONALS_AGE <= 16){
		$NATIONAL_CLASS = "Jr";
		$NATIONAL_CLASS = "Jr-B";
	} elseif ($NATIONALS_AGE >= 17 && $NATIONALS_AGE <= 18){
		$NATIONAL_CLASS = "Int";
		$NATIONAL_CLASS = "Jr-A";
	} elseif ($NATIONALS_AGE >= 19 && $NATIONALS_AGE <= 29){
		$NATIONAL_CLASS = "Sr";
	} elseif ($NATIONALS_AGE >= 30 && $NATIONALS_AGE <= 39){
		$NATIONAL_CLASS = "M30";
	} elseif ($NATIONALS_AGE >= 40 && $NATIONALS_AGE <= 49){
		$NATIONAL_CLASS = "M40";
	} elseif ($NATIONALS_AGE >= 50 && $NATIONALS_AGE <= 59){
		$NATIONAL_CLASS = "M50";
	} elseif ($NATIONALS_AGE >= 60 && $NATIONALS_AGE <= 69){
		$NATIONAL_CLASS = "M60";
	} elseif ($NATIONALS_AGE >= 70 ){
		$NATIONAL_CLASS = "M70";
	}
	return "$NATIONAL_CLASS" ;


	#################################################################
}

function get_skater_score($skater_id, $windowsize, $year, $debug){
	
	$distance  = array(111,222,333,444,500,777,1000,1500);

	$count = 0;		// number of scores to average
	$average = 0;		// clear out the accumulator
	
	if ($debug == true) {
		echo "<tr class=\"debug\">";
	}
	
	for ($x = 0; $x < sizeof($distance); $x++){
		$temp = get_skater_score_sub($skater_id, $windowsize, $distance[$x], $year, $debug);
		if ($temp ) {
			$count++;
			$average += $temp;
		}
	}
	
	if ($debug == true) {
		echo "<td class=\"debug\">";
		echo "distances used:" . $count . "</td>";		
	}

	if ($average) {
		$average = $average/$count;

		$average = round($average,2);	
	} else {
		$average = 100;
	}
	
	if ($debug == true) {
		echo "</td>";
	}
	
		
	return ($average);
}


function get_skater_score_sub( $skater_id, $windowsize, $distance, $year, $debug)
{
	
	$curYear = date('Y');
	$years_to_check_from = $curYear - $year;	// how far back in time do we check times
	$age_conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	
	
	
	  $query = "select min, sec, hun, bogusity, raw_results.division_id, race_enable race_name, race_date from raw_results, divisions, races where skater_id = ";
	  $query = $query    . $skater_id;
	  $query = $query .  " and raw_results.division_id = divisions.division_id ";
	  $query = $query .   " and divisions.race_id = races.race_id ";
	  $query = $query . " and race_enable = 1 and bogusity = 0 and distance=" . $distance ;
	  $query = $query . " and race_date > '". $years_to_check_from . "'";
	  $query = $query . " order by race_date desc limit " . $windowsize;
	  
	//echo  $query . "<br>";

	$result = mysql_query($query);
	$a = array();
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		$second = intval($row[min]);		// get minute value
		$second *=60;				// convert minutes to seconds
		$second += intval($row[sec]);		// now add in seconds
		
		//echo $row[race_date] . "<br>";
		
		// strip out no-times
		if ($second){
			array_push($a, $second);			
		}

	}
	sort($a);
	$retval = "0";
	$divisor = 1;		// avoid divide by 0
	
	switch ($distance){
		case	111:
			$divisor = 1;
			break;
		case	222:
			$divisor = 2;
			break;
		case	333:
			$divisor = 3;
			break;
		case	444:
			$divisor = 4;
			break;
		case	500:
			$divisor = 4.5;
			break;
		case	777:
			$divisor = 7;
			break;
		case	1000:
			$divisor = 9;
			break;
		case	1500:
			$divisor = 13.5;
			break;
	}
	
	
	if ($a[0]){
		$retval = floatval($a[0]);
		$retval = $retval/$divisor; 
		$retval = round($retval,2);	
	}
	
	if ($debug == true) {
		echo "<td class=\"debug\">distance:" . $distance . " fastest:" . $a[0] . " normalized:" . $retval . "</td>";
	}

	return ($retval);
	
}

function get_age_group($id, $race_id)
{
	
	$age_conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	$query = "select YEAR(race_date) as year, MONTH(race_date) as month
		from races
		where race_id = $race_id";
	##echo "$query<br>";
	$result = mysql_query($query);
	$race_array =  mysql_fetch_array($result, MYSQL_ASSOC);
	$race_month = $race_array[month];
	$race_year = $race_array[year];
	
	$query = "select YEAR(skater_dob) as year, MONTH(skater_dob) as month
		from skaters
		where skater_id = $id";
	#echo "$query<br>";
	$result = mysql_query($query);
	#mysql_close($age_conn);

	$retval = "";


	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		#echo "$id: $row[first] $row[last] $row[month] $row[d] $row[year]<br>";
		$retval = calc_age_group( $row[month],  $row[year],
			 $race_month, $race_year);
	}
	return $retval;

}

function alert($string)
{
	echo "<script>";
	echo "alert(\"$string\");";
	echo "</script>";
}


?>
