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


function write_skaters($div_id, $heat)
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

	    ##########################################################
            # find the raw results for this entry, if it exisits
	    # query need
            # divsion,  heat  and skater_id
	    ##########################################################
	   $query = "select min, sec, hun, pos, point, notes, place
		from raw_results
		where division_id = $div_id and
		   skater_id = $current_skater[skater_id] and 
		   heatnum = $heat";

#	   echo "$query<br>";
	   $skater_data = mysql_query($query);
	   $data = mysql_fetch_array($skater_data,MYSQL_ASSOC);
           $min = "";
	   $sec = "";
	   $hun = "";
           $pos = "";
	   $point = "";
	   $notes = "";
	   $place = "";

	   $min = $data[min];
	   $sec = $data[sec];
	   $hun = $data[hun];
	   $pos = $data[pos];
	   $point = $data[point];
	   $notes = $data[notes];
	   $place = $data[place];
	 




	   write_cell_entry( "$skater_count","");
	   write_cell_entry( "&nbsp;","");
	   write_cell_entry( "$current_skater[skater_first]" . "  " .  
		$current_skater[skater_last].
		"\n<input type=hidden name=\"skater_id_$skater_count\" 
		value = \"$current_skater[skater_id]\">\n"
		,"width=40px" );
	   echo "\n";
	   write_cell_entry( "<input type=\"text\"
                name=\"pos_$skater_count\"
                value=\"$pos\"
		size=\"2\",
		maxlength=\"2\">",
		"width=50px");
	   write_cell_entry( "<input type=\"text\"
                name=\"min_$skater_count\"
                value=\"$min\"
		size=\"2\"
		maxlength=\"2\">:
	   	<input type=\"text\"
                name=\"sec_$skater_count\"
                value=\"$sec\"
		size=\"2\",
		maxlength=\"2\">.
	   	<input type=\"text\"
                name=\"hun_$skater_count\"
                value=\"$hun\"
		size=\"2\",
		maxlength=\"2\">",
		"width=140");

	  echo "<td class=\"e_heatcard\">";
	  echo "<select name=\"place_$skater_count\">";
	  for ( $x = 1 ; $x < 10; $x++){
		if ($place == $x)
		   $selected = "selected";
		else 
		   $selected = "";
		echo "<option value = $x $selected>$x</selected>";
	  }
	  if ($place == "dns")
		   $selected = "selected";
		else 
		   $selected = "";
	  echo "<option value = \"dns\" $selected>dns</selected>";

	  if ($place == "dnf")
		   $selected = "selected";
		else 
		   $selected = "";
	  echo "<option value = \"dnf\" $selected>dnf</selected>";

	  if ($place == "dq")
		   $selected = "selected";
		else 
		   $selected = "";
	  echo "<option value = \"dq\" $selected>dq</selected>";

	  echo "</select>";
	  echo "</td>";

	   #write_cell_entry( "<input type=\"text\"
                #name=\"points_$skater_count\"
                #value=\"$point\"
		#size=\"2\",
		#maxlength=\"2\">",
		#"width=50px");
	   write_cell_entry($point,"");
	   write_cell_entry( "<input type=\"text\"
                name=\"notes_$skater_count\"
                value=\"$notes\"
		size=\"20\",
		maxlength=\"40\">",
		"");
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
	echo "</table>";

	while ( $division_row = mysql_fetch_array($division_list,MYSQL_ASSOC)){
	   $len = strlen($division_row[$dist]);
	   #echo "len = $len<br>";

	   if ($division_row[$dist] != NULL && $division_row[$dist] != 0 ) {
		echo "<hr><table>";
		echo "<tr>";
	   	write_cell_entry( $division_row[division_name],"" );
	   	write_cell_entry ("Distance $heatnum - $division_row[$dist] meters","");
	   	echo "</tr>\n";
		echo "<tr><td colspan=5>";
 		echo "<form action=\"inputtimes.php\" 
              		method=\"post\" enctype=\"multipart/form-data\" 
			name=\"inputtimes\" 
              		target=\"_parent\"> ";
		write_skaters($div, $heatnum);
		echo "</td></tr>\n";
  		echo "<tr><td>&nbsp;</td><td><input name=\"Submit\" 
			type=\"submit\" 
			value=\"Update Distance $heatnum\"></td></tr>\n";
		echo "<input type=hidden name=\"DIVISION_ID\"
		  value=\"$div\">";
		echo "<input type=hidden name=\"RACE_ID\"
		  value=\"$id\">";
		echo "<input type=hidden name=\"HEATNUM\"
		  value=\"$heatnum\">";
		echo "</form>";
	   	$heatnum++;
		echo "</table><br>";
		echo "<hr>";
	   }
	}
	return $heatnum;
}

function display_heatcard_for_edit($id, $div)
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

		echo "<h3>$rname $rdate</h3>\n";

		$heat = 1;
		
		$heat = edit_distance($id, "division_distance1", $heat,$div);
		$heat = edit_distance($id, "division_distance2", $heat,$div);
		$heat = edit_distance($id, "division_distance3", $heat,$div);
		$heat = edit_distance($id, "division_distance4", $heat,$div);
		$heat = edit_distance($id, "division_distance5", $heat,$div);
		$heat = edit_distance($id, "division_distance6", $heat,$div);

		mysql_close($conn);
}


#$keys = array_keys($_POST);
#foreach ($keys as $vars) {
#echo "$vars = $_POST[$vars]<br>";
#}

if ($_POST[RACE_ID] != NULL)
   $RACE_ID = $_POST[RACE_ID];

if ($_GET[RACE_ID] != NULL)
   $RACE_ID = $_GET[RACE_ID];

if ($_POST[DIVISION_ID] != NULL)
   $DIVISION_ID = $_POST[DIVISION_ID];

if ($_GET[DIVISION_ID] != NULL)
   $DIVISION_ID = $_GET[DIVISION_ID];

display_heatcard_for_edit($RACE_ID, $DIVISION_ID);

echo "<a href=OpenRace.php?RACE_ID=$RACE_ID>Back</a>";

?>


</body>
</html>
