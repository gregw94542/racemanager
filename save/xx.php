<html>
<?php
echo "<link rel=\"stylesheet\" href=\"ncsa.css\" type=\"text/css\">";
?>
<title> NCSA Race Manager</title>
<body>
<? include ("ncsadb.php")?>

<h1> NCSA Race Manager</h1>

<script language=javascript>
function OpenRace()
{
	alert ("Here we go");
}
</script>
<?php

function DisplayRaces($race_id)
{
  	$query = "select race_name, race_id, race_date 
		from races
		where race_enable <> 0
		order by race_date desc";
	$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
        mysql_select_db(get_db());
        $result = mysql_query($query);
	mysql_close($conn);

	echo "<form action=\"OpenRace.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"OpenRace\" target=\"_parent\"> ";
	echo "<select NAME=\"RACE_ID\">";
	while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
		if ($row[race_id] == $race_id) {
			$selected = "selected";
		} else{
			$selected = "";
		}
		
		echo "<option VALUE=\"$row[race_id]\" $selected >$row[race_date] : $row[race_name]</option>";
	}
	echo "</select>";
}

if ($_POST[RACE_ID] != NULL) {
	$race_id = $_POST[RACE_ID];
}
if ($_GET[RACE_ID] != NULL){
   $race_id = $_GET[RACE_ID];
}

?>
<hr>
<h2>Create Race</h2>
<table border=0>
<?php
echo "<form action=\"CreateRace.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"OpenRace\" target=\"_parent\"> ";
  echo "<tr><td class=\"title\">Name</td>\n";
 echo    "<td  class=\"input\" colspan=4><input name=\"RACE_NAME\" type=\"text\" size=\"30\" maxlength=\"50\" value=\"$_POST[RACE_NAME]\"></input></td></tr>\n";

  echo "<tr><td class=\"title\">Location</td>\n";
  echo "<td class=\"input\" colspan=3><input name=\"RACE_LOCATION\" type=\"text\" size=\"30\" maxlength=\"50\" value=\"$_POST[RACE_LOCATION]\"></input></td></tr>\n";
#
  echo "<tr> <td class=\"title\">Race Date (mmddyy)</td>\n";
  echo " <td class=\"info\">
	<input name=\"RACE_MON\" type=\"text\" size=\"2\"\
	 maxlength=\"2\" value=\"$_POST[RACE_MON]\">
	<input name=\"RACE_DAY\" type=\"text\" size=\"2\" maxlength=\"2\"\
	 value=\"$_POST[RACE_DAY]\"/>
	<input name=\"RACE_YEAR\" type=\"text\" size=\"4\" 
	maxlength=\"4\" value=\"$_POST[RACE_YEAR]\"/></td></tr>\n";
 echo "<tr><td>&nbsp;</td><td><input name=\"Submit\" type=\"submit\" value=\"Create Race\"></td>\n";
 echo "</tr></table>";
?>
</form>
<hr>

<div class="inputbox">
<h2>Race Maintenance</h2>
<?php
#################
	if (0){
  	$query = "select race_name, race_id, race_date 
		from races
		where race_enable <> 0
		order by race_date desc";
	$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
        mysql_select_db(get_db());
        $result = mysql_query($query);
	mysql_close($conn);

	echo "<form action=\"OpenRace.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"OpenRace\" target=\"_parent\"> ";
	echo "<select NAME=\"RACE_ID\">";
	while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
		if ($row[race_id] == $race_id) {
			$selected = "selected";
		} else{
			$selected = "";
		}
		
		echo "<option VALUE=\"$row[race_id]\" $selected >$row[race_date] : $row[race_name]</option>";

	}
	echo "</select>";
	}
#################

	DisplayRaces($race_id);
  	echo "<input name=\"Submit\" type=\"submit\" value=\"Open Existing Race\">";
	
	echo "</form>";
?>
<?php
  	$query = "select race_name, race_id, race_date 
		from races 
		where race_enable <> 0
		order by race_date desc";
	$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
        mysql_select_db(get_db());
        $result = mysql_query($query);
	mysql_close($conn);

	echo "<form action=\"ScheduleOfEvents.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"OpenRace\" target=\"_parent\"> ";
	echo "<select NAME=\"RACE_ID\">";
	while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
		if ($row[race_id] == $race_id) {
			$selected = "selected";
		} else{
			$selected = "";
		}
		echo "<option VALUE=\"$row[race_id]\" $selected>
		$row[race_date] : $row[race_name]</option>";

	}
	echo "</select>";
  	echo "<input name=\"Submit\" type=\"submit\" value=\"Schedule of Events\">";
	
	echo "</form>";
?>

<?php
  	$query = "select race_name, race_id, race_date 
		from races
		where race_enable <> 0
		order by race_date desc";
	$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
        mysql_select_db(get_db());
        $result = mysql_query($query);
	mysql_close($conn);

	echo "<form action=\"GenerateRace.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"OpenRace\" target=\"_parent\"> ";
	echo "<select NAME=\"RACE_ID\">";
	while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
		if ($row[race_id] == $race_id) {
			$selected = "selected";
		} else{
			$selected = "";
		}
		echo "<option VALUE=\"$row[race_id]\" $selected>
		$row[race_date] : $row[race_name]</option>\n";

	}
	echo "</select>";
  	echo "<input name=\"Submit\" type=\"submit\" value=\"Create Heat Cards\">";
	
	echo "</form>";
?>
<?php
  	$query = "select race_name, race_id, race_date 
		from races
		where race_enable <> 0
		order by race_date desc";
	$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
        mysql_select_db(get_db());
        $result = mysql_query($query);
	mysql_close($conn);

	echo "<form action=\"GenerateResults.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"OpenRace\" target=\"_parent\"> ";
	echo "<select NAME=\"RACE_ID\">";
	while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
		if ($row[race_id] == $race_id) {
			$selected = "selected";
		} else{
			$selected = "";
		}
		echo "<option VALUE=\"$row[race_id]\" $selected>
		$row[race_date] : $row[race_name]</option>\n";

	}
	echo "</select>";
  	echo "<input name=\"Submit\" type=\"submit\" value=\"Create Results for Selected Race\">";
	
	echo "</form>";
?>

<hr>
<div class="inputbox">
<h2>Skater Maintenance </h2>

<form action="skatermain.php" 
	method="post" enctype="multipart/form-data" name="skatermain" 
	target="_parent"> 
  	<input name="Submit" type="submit" value="Add/Change Skaters">
	</form>
</div>

<hr>
<div class="inputbox">
<h2>Enable/Disable Races </h2>

<form action="raceenable.php" 
	method="post" enctype="multipart/form-data" name="raceenable" 
	target="_parent"> 
  	<input name="Submit" type="submit" value="Enable/Disable Races">
	</form>
</div>
</body>
</html>
