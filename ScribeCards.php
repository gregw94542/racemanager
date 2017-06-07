<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager - Generate Heat Cards</title>
<body>
<? include ("ncsadb.php")?>


<?php
function write_cell($name, $attr)
{
	echo "<td class=\"heatcard\" $attr>$name</td>";
}

function display_points_footer()
{
		


   echo "<br><br><br> Timer: ________________________________________<br><br><br>\n";
   echo "Clerk: ________________________________________<br><br><br>\n";
   echo "<p class=\"tiny\"> \n";
   echo "Scoring: ";
   echo "1st(34)  ";
   echo "2nd(21)  ";
   echo "3rd(13)  ";
   echo "4th(8)  ";
   echo "5th(5)  ";
   echo "6th(3)  ";
   echo "7th(2)  ";
   echo "8th(1)  ";
   echo "</p>";
}

function new_page()
{
	display_points_footer();
	echo "<hr>";
	echo "<p STYLE=\"page-break-before:always\">&nbsp;</p>";
}


function write_skaters($div_id, $race_id, $lane)
{

	$query = "select helmet_num, skater_first, skater_last, s.skater_id as skater_id
	from skaters s, division_skaters d
	where d.division_id = $div_id and
           s.skater_id = d.skater_id
        order by s.skater_last,
          s.skater_first";

	$skaters_list = mysql_query($query);
	echo "<table border=1>";
	echo "<td class=\"t_heatcard\">&nbsp</td>";
	echo "<td class=\"t_heatcard\" align=center>Helmet<br>#</td>";
	echo "<td class=\"t_heatcard\" align=center>Name</td>";
	echo "<td class=\"t_heatcard\" align=center>Div</td>";
	echo "<td class=\"t_heatcard\">Pos</td>";
	echo "<td class=\"t_heatcard\" align=center>Time</td>";
	echo "<td class=\"t_heatcard\">Place</td>";
	echo "<td class=\"t_heatcard\">Pts</td>";
	echo "</tr>\n";
	$skater_count = 1;
	while ( $current_skater = mysql_fetch_array($skaters_list,MYSQL_ASSOC)){
	   $national = get_age_group( $current_skater[skater_id], $race_id);
	   echo "<tr>";
	   write_cell( "$skater_count","");
	   write_cell( "&nbsp;&nbsp;&nbsp;$current_skater[helmet_num] ","");
	   write_cell( "$current_skater[skater_first]" . "  " .  
		$current_skater[skater_last],"" );
	   echo "\n";
           write_cell("$national","");
	 #  echo "\n";
	 # write_cell( "&nbsp;","width=50px");	
	   $count_index = $skater_count-1;
	   #write_cell( "&nbsp;&nbsp;$lane[$count_index]","width=50px;");
	   write_cell( "&nbsp;&nbsp;","width=50px;");
	   write_cell( "&nbsp;","width=150px");
	   write_cell( "&nbsp;","width=50px");
	   write_cell( "&nbsp;","width=50px");
	   $skater_count++;
	   echo "</tr>\n";
	}
	echo "</table>";
}

function display_distance($id, $dist, $heatnum, $title)
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
		$lane = range(1, $num_skaters);
		shuffle($lane);
		for ($x = 0; $x < 1; $x++) {
			if ($x == 0) {
				$cardfor = "Scribe's Copy";
			} else {
				$cardfor = "Timer's Copy";
			}

			echo "<table border=0>";
			echo "<tr> <td class=\"heatcard\" style=\"font-size:26px;\"><u>$cardfor</u></td></tr>";
			echo "<tr> <td class=\"heatcard\">$title</td>";
			echo "<td><img src=\"NCSA_Logo_2008.jpg\" width=\"150px\" height=\"100px\"></td>";
			echo "</tr>\n";
	   		echo "<tr>";

			$division_name = "$division_row[division_name] - "  . "$cardfor";
	   		write_cell( "$division_name","" );
			echo "</tr>\n<tr>";
	   		write_cell( $division_row[$dist],"" );
	   		write_cell ("Event $heatnum","");
	   		echo "</tr>\n";
			echo "<tr><td colspan=5>";
			write_skaters($division_row[division_id], $id, $lane);
			echo "</td></tr>\n";
			echo "</table><br><br><br><br>";
			new_page();
		}
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

		$string = $rname . "<br>" . $rloc . "<br> " . $rdate . "<br><br>";

		$heat = 1;
		
		$heat = display_distance($id, "division_distance1", $heat,$string);
		$heat = display_distance($id, "division_distance2", $heat,$string);
		$heat = display_distance($id, "division_distance3", $heat,$string);
		$heat = display_distance($id, "division_distance4", $heat,$string);
		$heat = display_distance($id, "division_distance5", $heat,$string);
		$heat = display_distance($id, "division_distance6", $heat,$string);

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
#display_race($_POST[RACE_ID]);

echo "<a href=racemanager.php?RACE_ID=$race_id>Back</a>";


?>


</body>
</html>
