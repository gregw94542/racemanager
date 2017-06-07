<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<link rel="stylesheet" href="networkistics.css" type="text/css">
<title> NCSA Race Manager - Schedule of Events</title>
<body>
<? include ("ncsadb.php")?>


<?php
function write_cell($name, $attr)
{
	echo "<td class=\"heatcard\" $attr>$name</td>";
}




function write_skaters($div_id, $race_id, $lane)
{

	$query = "select helmet_num, skater_first, skater_last, s.skater_id as skater_id
	from skaters s, division_skaters d
	where d.division_id = $div_id and
           s.skater_id = d.skater_id
        order by helmet_num, s.skater_last,
          s.skater_first";

	$skaters_list = mysql_query($query);
	$skater_count = 1;
	echo "<table border=0>";
	$namecount = 0;
	while ( $current = mysql_fetch_array($skaters_list,MYSQL_ASSOC)){
	   if ($namecount == 0) {
	   	echo "<tr><td style=\"width: 40px;\" >&nbsp;</td>";
	   }
	   $namecount++;
	   echo "<td class=\"schedule_left_exsm\"> ($current[helmet_num])$current[skater_first] $current[skater_last]&nbsp;&nbsp;&nbsp; </td>";

	   if ($namecount > 3) {
	   	echo "</tr>";
		$namecount = 0;
	   }
	}
	echo "</table>";
}

function display_distance($id, $dist, $heatnum )
{
	$query = " select division_id, division_name , 
	  $dist
          from divisions 
	  where race_id = $id 
	  order by division_name";

	$division_list = mysql_query($query);


	while ( $division_row = mysql_fetch_array($division_list,MYSQL_ASSOC)){
	   $len = strlen($division_row[$dist]);
	   if ($len > 0 && $division_row[$dist] != 0 ) {
		##### print out 2 copies, 1 for the starter, the other for 
		##### the timer


			##### draw heats here
			#### calculate number of skaters in race
			$query = "select count(*) as c
			from skaters s, division_skaters d
			where d.division_id = $division_row[division_id] and
           		s.skater_id = d.skater_id";
			$skater_count = mysql_query($query);
			$sc = mysql_fetch_array($skater_count, MYSQL_ASSOC);
			$num_skaters = $sc[c];

			### create an array for start positions

			
			echo "<tr>";
			echo "<td class=\"heading\" style=\"width: 200px;\">Event #$heatnum</td>"; 

	   		echo  "<td class=\"heading\" style=\"width: 250px;\">$division_row[division_name]</td>";
	   		echo  "<td class=\"heading\" style=\"width: 100px;\">$division_row[$dist]m</td></tr><tr>";
				
			echo "<td colspan=3>";
			write_skaters($division_row[division_id], $id, $lane);
			echo "</td>";
			echo "</tr>";
			#echo "<tr><td colspan=4><hr></td></tr>";
	   	$heatnum++;
	   }
	}
	return $heatnum;
}

function display_heatcard($id)
{
		$conn = mysql_connect(get_host(), get_user(), get_pass()) 
			or die ('Error connecting to mysql');
		mysql_select_db(get_db());

		$query = "select race_name, race_location, race_date
		  from races 
  		  where race_id = $id";
		$race_row =  mysql_query($query);
		$race_row = mysql_fetch_array($race_row,MYSQL_ASSOC);
		$rname = $race_row[race_name];
		$rloc = $race_row[race_location];
		$rdate = $race_row[race_date];

		#echo "<p>";

		echo "<h1>Schedule of Events:  ";
		echo "$rname<br></h1>";
		echo "$rloc ";
		echo "$rdate<br>";
		#echo "</p>";

		$heat = 1;

		echo "<table border=0>";
		echo "<tr><td colspan=4><hr></td></tr>";

		
		$heat = display_distance($id, "division_distance1", $heat);
		$heat = display_distance($id, "division_distance2", $heat);
		$heat = display_distance($id, "division_distance3", $heat);
		$heat = display_distance($id, "division_distance4", $heat);
		$heat = display_distance($id, "division_distance5", $heat);
		$heat = display_distance($id, "division_distance6", $heat);
		echo "</table>";

		mysql_close($conn);
	}


function display_race($id) {
		$conn = mysql_connect(get_host(), get_user(), get_pass()) 
			or die ('Error connecting to mysql');
		mysql_select_db(get_db());
		$query = " select d.division_name, ds.division_skaters_id,
			ds.division_id, ds.skater_id,
			s.skater_id, s.skater_first, s.skater_last
			from division_skaters ds, divisions d, skaters s
			where d.race_id = $id
				and  ds.division_id = d.division_id
				and  ds.race_id = $id
				and  ds.skater_id = s.skater_id
			order by division_id,
				s.skater_last,
				s.skater_first
	";

		
		echo "$query<br><br>";
		echo "<table><tr>\n";
		echo "<td>&nbsp;</td>";
		echo "<td>division name</td>";
		echo "<td>division id</td>";
		echo "<td>skater_id</td>";
		echo "<td>skater_first</td>";
		echo "<td>skater_last</td>";
		echo "</tr>\n";

		$result = mysql_query($query);
		$linenum = 1;
		while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
		   echo "<tr>";
		   write_cell( $linenum,"" );
		   write_cell( $row[division_name],"" );
		   write_cell( $row[division_id],"" );
		   write_cell( $row[skater_id],"" );
		   write_cell( $row[skater_first],"" );
		   write_cell( $row[skater_last],"");
		   echo "</tr>";
		  $linenum++;
		}
		mysql_close($conn);
		echo "</table>";

	}


	$keys = array_keys($_POST);
	#foreach ($keys as $vars) {
	#echo "$vars = $_POST[$vars]<br>";
#}

if ($_POST[RACE_ID] != NULL) {
	$race_id = $_POST[RACE_ID];
}
if ($_GET[RACE_ID] != NULL)
   $race_id = $_GET[RACE_ID];
display_heatcard($race_id);



?>


</body>
</html>
