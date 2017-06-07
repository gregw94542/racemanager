<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="ncsa.css" type="text/css">
	<link href="design.css" rel="stylesheet" type="text/css" />
	<link type='text/css' href='test.css' rel='stylesheet' />

	<script type='text/javascript' src='jquery-2.1.1.js'></script>
	<script type='text/javascript' src='resultentry.js'></script>
	<script src="tabs.js" type="text/javascript"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>


	<? include ("ncsadb.php")?>
	<title>NCSA Race Result Data Entry - experimental</title>
</head>
<body>
<h1> Add/Change Heat Results - With Validation</h1>

    <!--p>
        jQuery is not loaded.
    </p-->

<?php

#### take csv string, unpack 
###  and create form:
function make_table($id)
{
	$m_array  = split( ",", $id, 4);
	echo "heat#: $m_array[0]<br>";
	echo "division_id: : $m_array[1]<br>";
	echo "division_column: $m_array[2]<br>";

}

function write_cell_entry($name, $attr)
{
	echo "<td class=\"e_heatcard\" $attr>$name</td>\n";
}

function write_cell_entry_time($name, $attr)
{
	echo "<td class=\"time\" $attr>$name</td>\n";
}


function get_heat_count($id)
{

$race_id = $id;

$heat_ids = array();
$check_conn = mysql_connect(get_host(), get_user(), get_pass()) 
	or die ('Error connecting to mysql');
mysql_select_db(get_db());

$check_query = "select division_name, division_id, division_distance1 as dist
	from divisions
	where race_id = $id
	order by division_name";

$results = mysql_query($check_query);

while ($current_heat = mysql_fetch_array($results,MYSQL_ASSOC)){
	$c_name = $current_heat[division_name];
	$c_id = $current_heat[division_id];
	$c_distance = $current_heat[dist];
	if ($c_distance != 0 && $c_distance != NULL && $c_distance != "") {
		$heatnum++;
		$heat_ids[] = $heatnum . "," . $c_id. ",1,$c_name,$c_distance";
	}
}
$check_query = "select division_name, division_id, division_distance2 as dist
	from divisions
	where race_id = $id
	order by division_name";
$results = mysql_query($check_query);

while ($current_heat = mysql_fetch_array($results,MYSQL_ASSOC)){
	$c_name = $current_heat[division_name];
	$c_id = $current_heat[division_id];
	$c_distance = $current_heat[dist];
	if ($c_distance != 0 && $c_distance != NULL && $c_distance != "") {
		$heatnum++;
		$heat_ids[] = $heatnum . "," . $c_id. ",2,$c_name,$c_distance";
	}
}

$check_query = "select division_name, division_id, division_distance3 as dist
	from divisions
	where race_id = $id
	order by division_name";
$results = mysql_query($check_query);

while ($current_heat = mysql_fetch_array($results,MYSQL_ASSOC)){
	$c_name = $current_heat[division_name];
	$c_id = $current_heat[division_id];
	$c_distance = $current_heat[dist];
	if ($c_distance != 0 && $c_distance != NULL && $c_distance != "") {
		$heatnum++;
		$heat_ids[] = $heatnum . "," . $c_id. ",3,$c_name,$c_distance";
	}
}

$check_query = "select division_name, division_id, division_distance4 as dist
	from divisions
	where race_id = $id
	order by division_name";
$results = mysql_query($check_query);

while ($current_heat = mysql_fetch_array($results,MYSQL_ASSOC)){
	$c_name = $current_heat[division_name];
	$c_id = $current_heat[division_id];
	$c_distance = $current_heat[dist];
	if ($c_distance != 0 && $c_distance != NULL && $c_distance != "") {
		$heatnum++;
		$heat_ids[] = $heatnum . "," . $c_id. ",4,$c_name,$c_distance";
	}
}

$check_query = "select division_name, division_id, division_distance5 as dist
	from divisions
	where race_id = $id
	order by division_name";
$results = mysql_query($check_query);

while ($current_heat = mysql_fetch_array($results,MYSQL_ASSOC)){
	$c_name = $current_heat[division_name];
	$c_id = $current_heat[division_id];
	$c_distance = $current_heat[dist];
	if ($c_distance != 0 && $c_distance != NULL && $c_distance != "") {
		$heatnum++;
		$heat_ids[] = $heatnum . "," . $c_id. ",5,$c_name,$c_distance";
	}
}

$check_query = "select division_name, division_id, division_distance6 as dist
	from divisions
	where race_id = $id
	order by division_name";
$results = mysql_query($check_query);

while ($current_heat = mysql_fetch_array($results,MYSQL_ASSOC)){
	$c_name = $current_heat[division_name];
	$c_id = $current_heat[division_id];
	$c_distance = $current_heat[dist];
	if ($c_distance != 0 && $c_distance != NULL && $c_distance != "") {
		$heatnum++;
		$heat_ids[] = $heatnum . "," . $c_id. ",6,$c_name,$c_distance";
	}
}

	mysql_close($check_conn);


	echo "<ol id=\"toc\">";
		foreach ($heat_ids as $id){
		#$current = split( ",", $id, 4);
		$current = preg_split( "/,/", $id);
		echo "<li><a href=\"#heat" . $current[0] . "\">&nbsp;H" .
           	$current[0] . "&nbsp;</a></li>";
	}

	#echo "<li><a href=\"/dev/ncsa/racemanager.php?RACE_ID=$race_id\"> Home</a></li>";
	echo "<li><a href=\"racemanager.php?RACE_ID=$race_id\"> Home</a></li>";
	echo "</ol><br>";


	foreach ($heat_ids as $id){
		###################################################
		# current[0] = heatnum
                # current[1] = division_id
		# current[2] = which race per division 
		# current[3] = division name
		# current[4] = division distance
		###################################################

		$current = preg_split( "/,/", $id, 5);
		echo "<div class=\"content\" id=\"heat" .  $current[0] . "\">";
		echo "<h2> Heat:$current[0] Division:$current[3] Distance:$current[4]</h2>";


		##############################################
                # switch doesn't work,
                # not sure if it exists in the version of
		# php that site5 is running
		##############################################

		if ($current[2] == "1") {
			$heatnum = 1;
		} else if ($current[2] == "2") {
			$heatnum = 2;
		} else if ($current[2] == "3") {
			$heatnum = 3;
		} else if ($current[2] == "4") {
			$heatnum = 4;
		} else if ($current[2] == "5") {
			$heatnum = 5;
		} else if ($current[2] == "6") {
			$heatnum = 6;
		}
 		echo "<form action=\"inputtimes1-validation.php\" 
              		method=\"post\" enctype=\"multipart/form-data\" 
			class=\"input_times_form\"
			name=\"inputtimes\" 
			id=\"inputtimes\"
              		target=\"_parent\"> ";

		write_skaters($current[1], $heatnum) ;

  		echo "<tr><td>&nbsp;</td><td><input name=\"Submit\" 
			type=\"submit\" 
			value=\"Update\" id=\"heat_submit\"></td></tr>";
		echo "<input type=hidden name=\"DIVISION_ID\"
		  value=\"$current[1]\"><br>";
		echo "<input type=hidden name=\"RACE_ID\"
		  value=\"$race_id\"><br>";
		echo "<input type=hidden name=\"HEATNUM\"
		  value=\"$heatnum\"><br>";
		echo "</form>\n";
	        echo  "</div>";
	}
}

##################################################

function write_skaters($div_id, $heat)
{
	$check_conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	$query = "select helmet_num, skater_first, skater_last, s.skater_id
	from skaters s, division_skaters d
	where d.division_id = $div_id and
           s.skater_id = d.skater_id
        order by s.skater_last,
          s.skater_first";

#	echo "Query: $query<br>";
	$skaters_list = mysql_query($query);
	echo "<table border=3>\n";
	echo "<td class=\"e_heatcard\">&nbsp</td>\n";
	echo "<td class=\"e_heatcard\" align=center width=35px>#</td>\n";
	echo "<td class=\"e_heatcard\" align=center width=150>Name</td>\n";
	echo "<td class=\"e_heatcard\">Pos</td>\n";
	echo "<td class=\"e_heatcard\" align=center width=150px>Time</td>\n";
	echo "<td class=\"e_heatcard\">Place</td>\n";
	echo "<td class=\"e_heatcard\">Pts</td>\n";
	echo "<td class=\"e_heatcard\">&#10003;</td>\n";
	echo "<td class=\"e_heatcard\" align=center width=200px>Notes</td>\n";
	echo "<td class=\"e_heatcard\"></td>\n";
	echo "</tr>\n";
	$skater_count = 1;
	while ( $current_skater = mysql_fetch_array($skaters_list,MYSQL_ASSOC)){
	   echo "<tr>";

	    ##########################################################
            # find the raw results for this entry, if it exisits
	    # query need
            # divsion,  heat  and skater_id
	    ##########################################################
	   $query = "select min, sec, hun, pos, point, notes, place, bogusity
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
	   if (strlen($min) == 1){
		$min = "0" . $min;
	   }
	   $sec = $data[sec];
	   if (strlen($sec) ==1){
		$sec = "0" . $sec;
	   }
	   
	   $hun = $data[hun];
	   if (strlen($hun) == 1){
		$hun = "0" . $hun;
	   }
	   $pos = $data[pos];
	   $point = $data[point];
	   $notes = $data[notes];
	   $place = $data[place];
	
	   $bogusity = $data[bogusity];
	 




	   write_cell_entry( "$skater_count","");
	   write_cell_entry( "&nbsp;&nbsp;&nbsp;$current_skater[helmet_num]","");
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
	   write_cell_entry_time( "<input type=\"text\"
		class=\"min\"
                name=\"min_$skater_count\"
                value=\"$min\"
		id=\"min\"
		size=\"2\"
		maxlength=\"2\">:
	   	<input type=\"text\"
		class=\"sec\"
                name=\"sec_$skater_count\"
                value=\"$sec\"
		id=\"sec\"
		size=\"2\",
		maxlength=\"2\">.
	   	<input type=\"text\"
		class=\"hun\"
                name=\"hun_$skater_count\"
                value=\"$hun\"
		id=\"hun\"
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

##          bogusity flag 
	    if ($bogusity == 0){
	    	$checked = "";
	    } else {
	    	$checked = "checked";
	    }
	    echo "<td class=\"e_heatcard\">";
	    echo "<input type=\"checkbox\" name=\"bogusity_$skater_count\" $checked/>";
	    echo "</td>";

##
	
	   write_cell_entry( "<input type=\"text\"
                name=\"notes_$skater_count\"
                value=\"$notes\"
		size=\"40\",
		maxlength=\"50\">",
		"");
	   echo "<td class=\"hintbox\"></td>\n";
	   $skater_count++;
	   echo "</tr>\n";
	}
	echo "</table>";
}


##################################################
$keys = array_keys($_POST);
foreach ($keys as $vars) {
	#echo "$vars = $_POST[$vars]<br>";

}
$keys1 = array_keys($_GET);
foreach ($keys1 as $vars) {
	#echo "$vars = $_GET[$vars]<br>";
}


if ($_GET[RACE_ID] != NULL)
   $RACE_ID = $_GET[RACE_ID];
if ($_POST[RACE_ID] != NULL)
   $RACE_ID = $_POST[RACE_ID];


	$racename = get_race($RACE_ID);
	echo "<H2>Race: $racename</h2>";

get_heat_count($RACE_ID);
?>

</body>
</html>
