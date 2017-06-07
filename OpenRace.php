<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<head>
<meta charset="UTF-8">
<meta name="google" content="notranslate">
<meta http-equiv="Content-Language" content="en">
</head>
<title> NCSA Race Manager - Open Race</title>
<body>
<? include ("ncsadb.php")?>
<? include ("utility.php")?>


<?php
$vars = new VARS();
$database = new DB();

function	display_distances($id)
{
	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	$query = "select division_distance1, 
			division_distance2, division_distance3, 
			division_distance4
		from divisions where division_id = $id";

	#echo "$query<br>";
	$result = mysql_query($query);
	while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
	   echo "<table><tr>";
	   if ($row[division_distance1] != "0" && 
		$row[division_distance1] != "9999"){
	   	echo "<td><b>&nbsp;&nbsp;Race 1:</b> $row[division_distance1] meters</td> ";
	   }
	   if ($row[division_distance2] != "0" &&
		$row[division_distance2] != "9999"){
	   	echo "<td><b>&nbsp;&nbsp; Race 2:</b> $row[division_distance2] meters</td>";
	   }
	   if ($row[division_distance3] != "0" &&
		$row[division_distance3] != "9999"){
	   	echo "<td><b>&nbsp;&nbsp; Race 3:</b> $row[division_distance3] meters</td>";
	   }
	   if ($row[division_distance4] != "0" &&
		$row[division_distance4] != "9999"){
	   	echo "<td><b>&nbsp;&nbsp; Race 4:</b> $row[division_distance4] meters</td>";
	   }
	}
  	mysql_close($conn);
	

}

function display_division($id, $rid) {
	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	$query = "select skater_first, skater_last, skater_id 
           from skaters 
	    where skater_id in
		(select skater_id 
			from division_skaters
			where division_id = '$id')
	   order by skater_last, skater_first";

#	echo "$query<br>";
	$skater_count = 1;
	$result = mysql_query($query);
	echo "<table>";
	while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
	  $national = get_age_group($row[skater_id], $rid);
	   echo "<tr><td>";
	   echo "<td>$skater_count: $row[skater_first] $row[skater_last]</td>";
	   echo "<td>&nbsp;&nbsp</td>";
	   echo "<td>$national</td></tr>";
	   $skater_count++;
	}
  	mysql_close($conn);
	echo "</table>";

}

#############################################################
#  Create Division if CREATE_DIVISION == TRUE
#############################################################
$race_id = $vars->get_race_id();



if ($_POST[CREATE_DIVISION] == TRUE) {

	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	$query = "insert into divisions (division_name,  
           race_id) values ('$_POST[DIVISION_NAME]', 
                \"$race_id\")";
	#echo "$query<br>";
	$result = mysql_query($query);
  	mysql_close($conn);

}

	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	$birth_date = date("$_POST[BIRTH_YEAR]-$_POST[BIRTH_MON]-$_POST[BIRTH_DAY]");
	$query = "select race_name, race_location, race_date from 
	  races where race_id = $race_id";
	#echo "$query<br>";
	$result = mysql_query($query);

	$row = mysql_fetch_array($result,MYSQL_ASSOC);
	echo "<div class=\"inputbox\">\n";
	echo "<h3>Create Division for $row[race_name]</h3>";
 	echo "<form action=\"OpenRace.php\" 
              method=\"post\" enctype=\"multipart/form-data\" name=\"adddivision\" 
              target=\"_parent\"> ";
  	echo "	<table border=0>";
  	echo "<tr><td class=\"title\">Division Name</td>\n";
  	echo  "<td  class=\"input\" colspan=2><input name=\"DIVISION_NAME\" type=\"text\" 
              size=\"12\" maxlength=\"32\" value=\"\"</td></tr>";
	
	echo "<input type=\"hidden\" name=\"CREATE_DIVISION\" value=\"TRUE\">\n";
	echo "<input type=\"hidden\" name=\"RACE_ID\" value=\"$race_id\">\n";
  	echo "<tr><td>&nbsp;</td><td><input name=\"Submit\" type=\"submit\"
  		value=\"Create Division\"></td></tr></table></form>" ;
	echo "</div>";

	###########################################################################
	echo "<hr>";
	echo "<div class=\"inputbox\"><h3>Current  Division for 
		<a href=editrace.php?RACE_ID=$race_id>$row[race_name]</h3></a>\n";


  	$query = "select division_name, division_start_order, race_id, division_id
	 from divisions 
              where race_id = \"$race_id\"
              order by division_name";
              #order by division_start_order";
	#echo "$query<br>";
	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
        mysql_select_db(get_db());
        $result = mysql_query($query);
	mysql_close($conn);
	
		
	while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
		#echo "$row[division_start_order] - $row[division_name]";
		echo "<div class=\"story1\">";
		echo "<u><h3><a href=editdivision.php?DIVISION_ID=$row[division_id]&RACE_ID=$race_id>
			$row[division_name]_</a>";
		echo "</u></h3>";
		display_division($row[division_id], $race_id);
		display_distances($row[division_id]);
		echo "<table><tr><td>";
		echo "<form action=\"populate_division.php\" 
             		 method=\"post\" enctype=\"multipart/form-data\"
			 name=\"popdivision\" target=\"_parent\">";
		echo "<input type=\"hidden\" name=\"DIVISION_ID\" 
			value=\"$row[division_id]\">";
		echo "<input type=\"hidden\" name=\"RACE_ID\" 
			value=\"$race_id\">";
  		echo "<input name=\"Submit\" type=\"submit\"
  			value=\"Add/Change Skaters to $row[division_name]\">";
		echo "</form>\n";
		echo "</td><td>";
		echo "<form action=\"DivisionDistances.php\" 
             		 method=\"post\" enctype=\"multipart/form-data\"
			 name=\"division_distances\" target=\"_parent\">";
		echo "<input type=\"hidden\" name=\"DIVISION_ID\" 
			value=\"$row[division_id]\">";
		echo "<input type=\"hidden\" name=\"RACE_ID\" 
			value=\"$race_id\">";
  		echo "<input name=\"Submit\" type=\"submit\"
  			value=\"Add/Change Distances Skated\">";
		echo "</form>\n";
		echo "</td><td>";
		echo "<form action=\"DivisionEnterResults.php\" 
             		 method=\"post\" enctype=\"multipart/form-data\"
			 name=\"division_distances\" target=\"_parent\">";
		echo "<input type=\"hidden\" name=\"DIVISION_ID\" 
			value=\"$row[division_id]\">";
		echo "<input type=\"hidden\" name=\"RACE_ID\" 
			value=\"$race_id\">";
  		#echo "<input name=\"Submit\" type=\"submit\"
  		#	value=\"Add/Change Results\">";
		echo "</form>\n";

		echo "</td></tr></table>";
		echo "</div><hr width=66%>";
	}




	echo "<a href=racemanager.php?RACE_ID=$race_id>Back</a>";
?>


</body>
</html>
