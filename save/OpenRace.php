<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager - Open Race</title>
<body>
<? include ("ncsadb.php")?>


<?php
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

function display_division($id) {
	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	$query = "select skater_first, skater_last 
           from skaters 
	    where skater_id in
		(select skater_id 
			from division_skaters
			where division_id = '$id')
	   order by skater_last, skater_first";

#	echo "$query<br>";
	$result = mysql_query($query);
	while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
	   #echo "$row[skater_first] $row[skater_last] ($id)<br>";
	   echo "$row[skater_first] $row[skater_last] <br>";
	}
  	mysql_close($conn);

}


$keys = array_keys($_POST);
foreach ($keys as $vars) {
#echo "$vars = $_POST[$vars]<br>";
}

#############################################################
#  Create Division if CREATE_DIVISION == TRUE
#############################################################

if ($_POST[CREATE_DIVISION] == TRUE) {
	#echo "I think we need to create a division, ";
	#echo "RACE_ID = $_POST[RACE_ID]<br>";
	#echo "DIVISION_NAME = $_POST[DIVISION_NAME]<br>";
	#echo "DIVISION_START_ORDER = $_POST[DIVISION_START_ORDER]<br>";

	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	#$query = "insert into divisions (division_name, division_start_order, 
        #   race_id) values ('$_POST[DIVISION_NAME]', 
        #        '$_POST[DIVISION_START_ORDER]', '$_POST[RACE_ID]')";
	$query = "insert into divisions (division_name,  
           race_id) values ('$_POST[DIVISION_NAME]', 
                '$_POST[RACE_ID]')";
#	echo "$query<br>";
	$result = mysql_query($query);
  	mysql_close($conn);

}

if ($_POST[RACE_ID] != NULL)
   $race_id = $_POST[RACE_ID];


if ($_GET[RACE_ID] != NULL)
   $race_id = $_GET[RACE_ID];



	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	$birth_date = date("$_POST[BIRTH_YEAR]-$_POST[BIRTH_MON]-$_POST[BIRTH_DAY]");
	$query = "select race_name, race_location, race_date from 
	  races where race_id = $race_id";
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
  	#echo "<tr><td class=\"title\">Starting Order</td>\n";

  	#echo  "<td  class=\"input\" colspan=2><select name=\"DIVISION_START_ORDER\">";
	#for ($x = 1 ; $x < 10; $x++){
		#echo "<option VALUE=\"$x\">$x</option>\n";
	#}
	#echo "</select></td></tr>\n";
	
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
			$row[division_name]</a>";
		echo "</u></h3>";
		display_division($row[division_id]);
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
  		echo "<input name=\"Submit\" type=\"submit\"
  			value=\"Add/Change Results\">";
		echo "</form>\n";

		echo "</td></tr></table>";
		echo "</div><hr width=66%>";
	}




	echo "<a href=racemanager.php?RACE_ID=$race_id>Back</a>";
?>


</body>
</html>
