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
	
	if ($BMONTH > 6){
	 	$RYEAR++;
	}


	if ($BMONTH == 0  || $BYEAR == 0){
		return "--";
	}

	$NATIONALS_AGE=$RYEAR - $BYEAR;
	##echo "Nationals Age = $NATIONALS_AGE<br>";

	if ($NATIONALS_AGE <= 10 ) {
		$NATIONAL_CLASS = "Pony";
	} elseif ($NATIONALS_AGE >= 11 && $NATIONALS_AGE <= 12){
		$NATIONAL_CLASS = "Midget";
	} elseif ($NATIONALS_AGE >= 13 && $NATIONALS_AGE <= 14){
		$NATIONAL_CLASS = "Juv";
	} elseif ($NATIONALS_AGE >= 15 && $NATIONALS_AGE <= 16){
		$NATIONAL_CLASS = "Jr";
	} elseif ($NATIONALS_AGE >= 17 && $NATIONALS_AGE <= 18){
		$NATIONAL_CLASS = "Int";
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
		#. 
		#"(" . $RYEAR .")" .
		#"(" . $BYEAR .")" .
		#"(" . $NATIONALS_AGE . ")";

	#################################################################
}

function get_age_group($id, $race_id)
{
	$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
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
	mysql_close($conn);

	$retval = "";


	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		#echo "$id: $row[first] $row[last] $row[month] $row[d] $row[year]<br>";
		$retval = calc_age_group( $row[month],  $row[year],
			 $race_month, $race_year);
	}
	return $retval;

}


?>
