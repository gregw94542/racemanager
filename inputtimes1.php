<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager - Generate Heat Cards</title>
<body>
<? include ("ncsadb.php")?>


<?php
function write_cell_entry($name, $attr)
{
	echo "<td class=\"e_heatcard\" $attr>$name</td>\n";
}

function  GetPointsFromPlace($place)
{
	$return = 0;
	switch ($place) {
		case "1":
		 $return = "34";
		break;

		case "2":
		 $return = "21";
		break;

		case "3":
		 $return = "13";
		break;

		case "4":
		 $return = "8";
		break;

		case "5":
		 $return = "5";
		break;

		case "6":
		 $return = "3";
		break;

		case "7":
		 $return = "2";
		break;

		case "8":
		 $return = "1";
		break;

	}
	return ($return);
}

function write_skaters($div_id)
{
	$query = "select skater_first, skater_last, s.skater_id
	from skaters s, division_skaters d
	where d.division_id = $div_id and
           s.skater_id = d.skater_id
        order by s.skater_last,
          s.skater_first";

	$skaters_list = mysql_query($query);
	echo "<table border=3>\n";
	echo "<td class=\"e_heatcard\">&nbsp</td>\n";
	echo "<td class=\"e_heatcard\" align=center width=35px>#</td>\n";
	echo "<td class=\"e_heatcard\" align=center width=250px>Name</td>\n";
	echo "<td class=\"e_heatcard\">Pos</td>\n";
	echo "<td class=\"e_heatcard\" align=center>Time</td>\n";
	echo "<td class=\"e_heatcard\">Place</td>\n";
	echo "<td class=\"e_heatcard\">Pts</td>\n";
	echo "<td class=\"e_heatcard\">Notes</td>\n";
	echo "</tr>\n";
	$skater_count = 1;
	while ( $current_skater = mysql_fetch_array($skaters_list,MYSQL_ASSOC)){
	   echo "<tr>";
	   write_cell_entry( "$skater_count","");
	   write_cell_entry( "&nbsp;","");
	   write_cell_entry( "$current_skater[skater_first]" . "  " .  
		$current_skater[skater_last].
		"\n<input type=hidden name=\"skater_id_$skater_count\" 
		value = \"$current_skater[skater_id]\">\n"
		,"" );
	   echo "\n";
	   write_cell_entry( "&nbsp;","width=50px");
	   write_cell_entry( "&nbsp;","width=100px");
	   write_cell_entry( "&nbsp;","width=50px");
	   write_cell_entry( "&nbsp;","width=50px");
	   write_cell_entry( "&nbsp;","width=200");
	   $skater_count++;
	   echo "</tr>\n";
	}
	echo "</table>";
}

function edit_distance($id, $dist, $heatnum, $div)
{
	$query = " select  division_name , $dist
          from divisions 
	  where race_id = $id and
	    division_id = $div";

	$division_list = mysql_query($query);

	echo "<table>";
	echo "<tr> <td class=\"heatcard\">$title</td></tr>\n";
	echo "<tr>";
	write_cell_entry( "$division_row[division_name]","" );
	echo "</tr>\n<tr>";
	write_cell_entry( $division_row[$dist],"" );
	echo "</tr>\n";
	echo "</table><hr>";

	while ( $division_row = mysql_fetch_array($division_list,MYSQL_ASSOC)){
	   if ($division_row[$dist] != NULL) {
		echo "<table>";
		echo "<tr>";
	   	write_cell_entry( $division_row[division_name],"" );
	   	write_cell_entry ("Distance $heatnum - $division_row[$dist] meters","");
	   	echo "</tr>\n";
		echo "<tr><td colspan=5>";
 		echo "<form action=\"inputtimes.php\" 
              		method=\"post\" enctype=\"multipart/form-data\" 
			name=\"inputtimes\" 
              		target=\"_parent\"> ";
		write_skaters($div);
		echo "</td></tr>\n";
  		echo "<tr><td>&nbsp;</td><td><input name=\"Submit\" 
			type=\"submit\" 
			value=\"Update Distance $heatnum\"></td></tr>\n";
		echo "</form>";
	   	$heatnum++;
		echo "</table><br>";
		echo "<hr>";
	   }
	}
	return $heatnum;
}

function input_entry( $race_id,$division_id,$heatnum,$skate_id,$pos,
	  $min,$sec,$hun,$place, $points,$notes,$bogusity)
{
		$conn = mysql_connect(get_host(), get_user(), get_pass()) 
			or die ('Error connecting to mysql');
		mysql_select_db(get_db());

		$query = "delete from raw_results 
			where division_id = $division_id
			  and skater_id = $skate_id
			  and heatnum = $heatnum";
	#	echo "$query<br>";
		mysql_query($query);

		$points = GetPointsFromPlace($place);

		$query = "insert into raw_results
		  (division_id, skater_id, heatnum, 
		   min, sec, hun, pos, point, notes, place, bogusity)
		  values
                  ($division_id, $skate_id, $heatnum, '$min', '$sec', 
	           '$hun', '$pos', '$points', '$notes', '$place', '$bogusity')";
#		echo "$query<br>";
		mysql_query($query);
			
}

function add_entry($race_id, $division_id, $heatnum, $skate_id, $pos, $min, $sec, $hun, $place, $points, $notes, $bogusity)
{

  if ($skate_id == NULL)
	return;
  if ($pos == NULL) {
	$pos = "-";
  }
  if ($min == NULL) {
	$min = "0";
  }
  if ($sec == NULL) {
	$sec = "0";
  }
  if ($hun == NULL) {
	$hun = "0";
  }
  if ($place == NULL) {
	$place = "0";
  }
  if ($points == NULL) {
	$points = "0";
  }
  if ($notes == NULL) {
	$notes = "";
  }
  if ($bogusity == NULL) {
	$bogusity = 0;
  }


  input_entry( $race_id,$division_id,$heatnum,$skate_id,$pos,
	  $min,$sec,$hun,$place, $points,$notes, $bogusity);
};



$keys = array_keys($_POST);
foreach ($keys as $vars) {
#echo "$vars = $_POST[$vars]<br>";
}


$RACE_ID = $_POST[RACE_ID];
$DIVISION_ID = $_POST[DIVISION_ID];
$HEATNUM = $_POST[HEATNUM];
$entry = 1;
$i_skater = "skater_id_" . $entry;
while ($_POST[$i_skater] != NULL) {
#	echo " index = $i_skater ,value =  $_POST[$i_skater]<br>";
	$i_skater = "skater_id_" . $entry;
	$i_pos = "pos_" . $entry;
	$i_min = "min_" . $entry;
	$i_sec = "sec_" . $entry;
	$i_hun = "hun_" . $entry;
	$i_place = "place_" . $entry;
	$i_points = "points_" . $entry;
	$i_notes = "notes_" . $entry;
	$i_bogusity = "bogusity_" . $entry;

	$skate_id = $_POST[$i_skater];
	$pos = $_POST[$i_pos];
	$min = strip_leading_zeros($_POST[$i_min]);
	$sec = strip_leading_zeros($_POST[$i_sec]);
	$hun = strip_leading_zeros($_POST[$i_hun]);
	$place = $_POST[$i_place];
	$points = $_POST[$i_points];
	$notes = $_POST[$i_notes];
	$bogusity = $_POST[$i_bogusity];
	if ($bogusity == "on") {
		$bogusity = 1;
	} else {
		$bogusity = 0;
	}
	add_entry($RACE_ID, $DIVISION_ID, $HEATNUM, $skate_id, $pos, $min, $sec, $hun, $place, $points, $notes, $bogusity);
	$entry++;
}


echo "<META HTTP-EQUIV=\"Refresh\" 
	CONTENT=\"1; URL=resultentry.php?RACE_ID=$RACE_ID\">";

echo "<a href=resultentry.php?RACE_ID=$RACE_ID>Updating database.... Click this link in case the browser gets stuck here</a>";
?>
</body>
</html>
