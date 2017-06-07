<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="design.css" rel="stylesheet" type="text/css" />
<script src="tabs.js" type="text/javascript"></script>



<title> NCSA Race Manager Skater Results</title>
<body>
<? include ("ncsadb.php")?>

<?php
$keys = array_keys($_POST);
foreach ($keys as $vars) {
#echo "$vars = $_POST[$vars]<br>";
}

$keys = array_keys($_GET);
foreach ($keys as $vars) {
#echo "$vars = $_GET[$vars]<br>";
}


if ($_POST[SKATER_ID] != NULL)
   $skater_id = $_POST[SKATER_ID];

if ($_GET[SKATER_ID] != NULL)
   $skater_id = $_GET[SKATER_ID];


?>

<div class="inputbox">
<?php
  if ($_GET[DISPLAY_SKATER] == TRUE) {
   $name =get_skater_name($skater_id);
   echo "<h2> Race Results for $name</h2>";
  } else {
    echo "<h2> Display Skaters Race Result History</h2>";
  }
?>

<?php
function display_skater_results_by_time($skater_id, $distance)
{
	$query = "select 
		r.race_name, r.race_location, r.race_date,  sh.heatnum, 
		 sh.distance, sh.place, sh.min, sh.hun, sh.sec
	  from skater_history sh,
		races r, skaters s
	  where s.skater_id = $skater_id and 
		sh.skater_id = s.skater_id and
		r.race_id = sh.race_id and
		sh.distance = \"$distance\" and 
		sh.place <> 'dnf' and 
		sh.place <> 'dq' and 
		sh.place <> 'pen' and 
		sh.place <> 'dns'
	  order by 
		convert(sh.min, SIGNED) asc,
		convert(sh.sec, SIGNED) asc,
		convert(sh.hun, SIGNED) asc
	  ";
	#echo "$query<br>";
	$result = mysql_query($query);
		
	
	echo "<table border=0>\n";
	echo "<tr> <td colspan=10><h2>$distance meters</h2></td></tr>";
	echo "<tr>";
	echo "<td class=\"title\" width=250px>RACE</td>";
	echo "<td class=\"title\" width=150>LOCATION</td>";
	echo "<td class=\"title\" width=75px>DATE</td>";
	echo "<td class=\"title\" colspan=3>TIME</td>";
	echo "<td class=\"title\">PLACE</td>";
	echo "</tr>";
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){

		if ($row[place] == 'dq') {
			$row[place] = 'pen';
		}

		echo "<tr>";
		echo "<td>$row[race_name]</td>";
		echo "<td class=\"info\">$row[race_location]</td>";
		echo "<td class=\"info\">$row[race_date]</td>";
		echo "<td class=\"info\" width=5px>$row[min]:</td>";
		echo "<td class=\"info\" width=5px>$row[sec].</td>";
		echo "<td class=\"info\" width=5px>$row[hun]</td>";
		echo "<td class=\"info\" width=5px>($row[place])</td>";
		echo "</tr>";
	
	}
	echo "</table><br><br>\n";
}

function display_skater_results($skater_id, $distance)
{
	$query = "select 
		r.race_name, r.race_location, r.race_date,  sh.heatnum, 
		 sh.distance, sh.place, sh.min, sh.hun, sh.sec
	  from skater_history sh,
		races r, skaters s
	  where s.skater_id = $skater_id and 
		sh.skater_id = s.skater_id and
		r.race_id = sh.race_id and
		sh.distance = $distance and 
		sh.place <> 'dnf' and 
		sh.place <> 'dq' and 
		sh.place <> 'pen' and 
		sh.place <> 'dns' 
	  order by sh.distance,
		r.race_date desc,
		sh.heatnum 
	  ";
	#echo "$query<br>";
	$result = mysql_query($query);
		
	
	echo "<table border=0>\n";
	echo "<tr> <td colspan=10><h2>$distance meters<h2></td></tr>";
	echo "<tr>";
	echo "<td class=\"title\" width=250px>RACE</td>";
	echo "<td class=\"title\" width=150>LOCATION</td>";
	echo "<td class=\"title\" width=75px>DATE</td>";
	echo "<td class=\"title\" colspan=3>TIME</td>";
	echo "<td class=\"title\">PLACE</td>";
	echo "</tr>";
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		echo "<tr>";
		echo "<td>$row[race_name]</td>";
		echo "<td class=\"info\">$row[race_location]</td>";
		echo "<td class=\"info\">$row[race_date]</td>";
		echo "<td class=\"info\" width=5px>$row[min]:</td>";
		echo "<td class=\"info\" width=5px>$row[sec].</td>";
		echo "<td class=\"info\" width=5px>$row[hun]</td>";
		echo "<td class=\"info\" width=5px>($row[place])</td>";
		echo "</tr>";
	
	}
	echo "</table><br><br>\n";
}
		
function  get_skater_results($skater, $dist, $heat)
{
	$query = "select 
		rr.min, rr.sec, rr.hun, r.race_id, r.race_date,
		rr.place, rr.skater_id , rr.bogusity,
		d.division_distance$heat as distance,
		rr.heatnum
		
		from raw_results rr,
			divisions d, 
			races r
		where
			rr.skater_id = $skater and
			rr.division_id = d.division_id and
			r.race_enable <> '0' and
			rr.heatnum = $heat and
			d.race_id = r.race_id and
			d.division_distance$heat=\"$dist\" and
			rr.bogusity = 0
		order by r.race_date desc 
			";
	#echo "$query<br>";
       	$result = mysql_query($query);
	return $result;



}
  if ($_GET[DISPLAY_SKATER] == TRUE) {

	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
        mysql_select_db(get_db());

	##################################################
	#  Create Table if necessary
	##################################################
	$query = "create table if not exists skater_history (
			skater_history_id int auto_increment primary key,
			race_id int,
			skater_id int,
			heatnum int,
			distance int,
			min	char(3),
			sec 	char(2),
			hun	char(2),
			place	varchar(10)
		)";
        $result = mysql_query($query);

	##################################################
	#  Clean this skater's stuff from the table
	##################################################
	$query = "delete from skater_history where skater_id = $skater_id";
        $result = mysql_query($query);


	##################################################
	#  Find times for this skater
	##################################################

	$distances = array("111", "222", "333", "500", "777", "1000", "1500");
	foreach ($distances as $distance){
		#echo "I got $distance<br>";
		for ($heatnum = 1 ; $heatnum < 5; $heatnum++) {
			$result  = get_skater_results($skater_id, $distance, 
				$heatnum);
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
				#echo "$row[race_id] $row[race_date] $row[skater_id] $row[heatnum] $row[distance] $row[min] $row[sec] $row[hun] ($row[place]) <br>";
				$query = "insert into skater_history ( race_id,
				 skater_id, heatnum, distance, min, sec, hun, 
				 place) values
                                 (
                                  \"$row[race_id]\",
                                  \"$row[skater_id]\",
                                  \"$row[heatnum]\",
                                  \"$row[distance]\",
                                  \"$row[min]\",
                                  \"$row[sec]\",
                                  \"$row[hun]\",
                                  \"$row[place]\"
				)";
				#echo "$query<br>";
        			$noresult = mysql_query($query);
			}
		}
	}
?>

	<ol id="toc">
	<li><a href=#date> Sorted By Date </a></li>
	<li><a href=#time> Sorted By Time</a></li>
	<li><a href=skaterresults.php> Back</a></li>
	</ol><br>
<?php

	$distances = array("111", "222", "333", "500", "777", "1000", "1500");
?>
	<div class="content" id="date">
<?php
	foreach ($distances as $distance){
		display_skater_results($skater_id, $distance);
	}
?>
	</div>
	<div class="content" id="time">
<?php>
	$distances = array("111", "222", "333", "500", "777", "1000", "1500");
		
	foreach ($distances as $distance){
		display_skater_results_by_time($skater_id, $distance);
	}
?>
	</div>
<?php



	mysql_close($conn);
	

  } else {
 	$skaternames = array();
  	$query = "select skater_first, skater_last, skater_id from skaters 
		order by skater_first, skater_last";
	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
        mysql_select_db(get_db());
        $result = mysql_query($query);
	mysql_close($conn);

	$array_index = 0;

	while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
		#echo "<br>";
		#echo "<a href=\"skatermain.php?SKATER_ID=$row[skater_id]&UPDATE_SKATER=TRUE\">$row[skater_first] $row[skater_last]</a>";
		$skaternames[$array_index] = "<a href=\"skaterresults.php?SKATER_ID=$row[skater_id]&DISPLAY_SKATER=TRUE\">$row[skater_first] $row[skater_last]</a>";
		$array_index++;
	}

	echo "<table>";
	for ($x = 0; $x < ($array_index); ){
		echo "<tr>";
		echo "<td class=\"email\">$skaternames[$x] </td>";
		$x++;
		echo "<td class=\"email\">$skaternames[$x] </td>";
		$x++;
		echo "<td class=\"email\">$skaternames[$x] </td>";
		$x++;
		echo "<td class=\"email\">$skaternames[$x] </td>";
		$x++;
		echo "</tr>";
	}
	echo "</table>";
   }
?>

</div>

<div class="inputbox">
<br>
<a href="racemanager.php">Return to main</a>
&nbsp;&nbsp;&nbsp
</div>
</body>
</html>
