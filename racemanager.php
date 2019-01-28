<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="design.css" rel="stylesheet" type="text/css" />
<script src="tabs.js" type="text/javascript"></script>
<? include ("ncsadb.php")?>
<? include ("utility.php")?>


<title> NCSA Race Manager</title>
<body>

<h1> NCSA Race Manager </h1>

<script language=javascript>
function Openrace( )
{
	document.OpenRace.action="OpenRace.php";
	document.OpenRace.submit();
}
function SkaterMain( )
{
	document.OpenRace.action="skatermain.php";
	document.OpenRace.submit();
}
function SkaterResults( )
{
	document.OpenRace.action="skaterresults.php";
	document.OpenRace.submit();
}
function SkaterValid( )
{
	document.OpenRace.action="skaterenable.php";
	document.OpenRace.submit();
}

function Genrace( )
{
	document.OpenRace.action="GenerateRace.php";
	document.OpenRace.submit();
}

function Helmets( )
{
	document.OpenRace.action="Helmets.php";
	document.OpenRace.submit();
}

function Gensched( )
{
	document.OpenRace.action="ScheduleOfEvents.php";
	document.OpenRace.submit();
}

function EnterResults( )
{
	document.OpenRace.action="resultentry.php";
	document.OpenRace.submit();
}


function EnterResultsValidate( )
{
	document.OpenRace.action="resultentry-validation.php";
	document.OpenRace.submit();
}



function Genresults( )
{
	document.OpenRace.action="GenerateResults.php";
	document.OpenRace.submit();
}

function RaceHelper( )
{
	document.OpenRace.action="VirtualRace.php";
	document.OpenRace.submit();
}
function AMaint( )
{
	document.OpenRace.action="Association.php";
	document.OpenRace.submit();
}
</script>
<?php

function DisplayRaces($race_id, $name)
{

  	$query = "select race_name, race_id, race_date, association_name
		from races, associations
		where race_enable <> 0
		and races.association_id = associations.association_id
		order by race_date desc";
	$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
        mysql_select_db(get_db());
        $result = mysql_query($query);
	mysql_close($conn);

	echo "<select NAME=\"RACE_ID\" ID=\"RACE_ID\">\n";
	while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
		if ($row[race_id] == $race_id) {
			$selected = "selected";
		} else{
			$selected = "";
		}
		
		echo "<option VALUE=\"$row[race_id]\" $selected >$row[race_date] : $row[race_name] ($row[association_name])</option>\n";
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
<div>
<ol id="toc">
	<li><a href=#Maintenance> Race Maintenance </a></li>
	<li><a href=#Create> Create Race </a></li>
	<li><a href=#Skater> Skater </a></li>
	<li><a href=#Enable> Enable/Disable </a></li>
	<li><a href=#Association> Association </a></li>
	<li><a href=#DeveloperNote> Developer </a></li>
</ol><br>
</div>




<div class="content" id="Maintenance">
<h2>Race Maintenance</h2>
<form action="OpenRace.php" name="OpenRace" method="post"
		 enctype="multipart/form-data" 
		 target="_parent">
<table class="main_table">
<tr>
<td class="l_info"> Select Race To Manage</td>
<td>
<?php
	DisplayRaces($race_id,"open");
?>
</td>

</tr>

<tr>
<tr><td class="l_info"> Create Divisions/Add-Edit Skaters/Set Distance/Enter Results</td>
<td><input type="BUTTON" name="open" value="Open Race    "
		 onclick=Openrace();></td>
</tr>
<tr><td class="l_info"> Helmet Numbers</td>
<td><input type="BUTTON" name="open" value="Helmet #           "
		 onclick=Helmets();></td>
</tr>



<tr>
<td class="l_info"> Enter Results For All Heats</td>
<td> <input type="BUTTON" name="enter_results" 
		value="Enter Results"
		 onclick=EnterResultsValidate()>
</td>
</tr>


<tr>

<td class="l_info">Virtual Race Helper </td>
<td> <input type="BUTTON" name="race_helper" 
		value="Age Results  "
		 onclick=RaceHelper();>
</td>
</tr>

<!--<tr>
<td class="l_info"> <strike>Enter Results For All Heats No Validate</strike></td>
<td> <input type="BUTTON" name="enter_results" 
		value="Emergency Only"
		 onclick=EnterResults()>
</td>
</tr>-->



</table>
</form>
</table>
</div>


<div class="content" id="Create">
<h2>Create Race</h2>
<table border=0>
<?php
echo "<form action=\"CreateRace.php\" method=\"post\"\n
	 enctype=\"multipart/form-data\" name=\"CreateRace\"\n
	 target=\"_parent\"> ";
  echo "<tr><td class=\"title\">Name</td>\n";
 echo    "<td  class=\"input\" colspan=4><input name=\"RACE_NAME\"\n
	 type=\"text\" size=\"30\" maxlength=\"50\"\n
	 value=\"$_POST[RACE_NAME]\"></input></td></tr>\n";
  echo "<tr><td class=\"title\">Location</td>\n";
  echo "<td class=\"input\" colspan=3><input name=\"RACE_LOCATION\"\n
	 type=\"text\" size=\"30\" maxlength=\"50\"\n
	 value=\"$_POST[RACE_LOCATION]\"></input></td></tr>\n";
#
  echo "<tr> <td class=\"title\">Race Date (mmddyy)</td>\n";
  echo " <td class=\"info\">
	<input name=\"RACE_MON\" type=\"text\" size=\"2\"\
	 maxlength=\"2\" value=\"$_POST[RACE_MON]\">
	<input name=\"RACE_DAY\" type=\"text\" size=\"2\" maxlength=\"2\"\
	 value=\"$_POST[RACE_DAY]\"/>
	<input name=\"RACE_YEAR\" type=\"text\" size=\"4\" 
	maxlength=\"4\" value=\"$_POST[RACE_YEAR]\"/></td></tr>\n";
			
	echo "<tr><td class=\"title\">Association</td><td>";
	make_association_combo(1);
	echo "</td>\n";
	echo "</tr>";
	
 echo "<tr><td>&nbsp;</td><td><input name=\"Submit\"\n
	 type=\"submit\" value=\"Create Race\"></td>\n";
 echo "</tr></table>";
 echo "</form>";
 echo "</div>";
?>


<div class="content" id="Skater">
<h2>Skater Maintenance </h2>
<form action="skatermain.php" 
	method="post" enctype="multipart/form-data" name="skatermain" 
	target="_parent"> 
  	<!--input type="BUTTON" name="skatermain" 
		value="Add/Change Skaters"
		 onclick=SkaterMain()-->
  	<input type="BUTTON" name="skaterresults" 
		value="Skaters Result"
		 onclick=SkaterResults()>
  	<input type="BUTTON" name="skatervalid" 
		value="EnableSkater"
		 onclick=SkaterValid()>
	</form>
</div>



<div class="content" id="Enable">
<h2>Enable/Disable Races </h2>

<form action="raceenable.php" 
	method="post" enctype="multipart/form-data" name="raceenable" 
	target="_parent"> 
  	<input name="Submit" type="submit" value="Enable/Disable Races">
	</form>
</div>

<div class="content" id="Association">
<h2>Association Maintenance</h2>
<?php
  	$query = "select association_name, association_url, 
		association_id 
		from associations
		order by association_name desc";
	$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
        mysql_select_db(get_db());
        $result = mysql_query($query);
	mysql_close($conn);

	while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
		echo "$row[association_name]<br>";
	}
?>
<form action="AssociationMaintenance.php" 
	method="post" enctype="multipart/form-data" name="association" 
	target="_parent"> 
  	<input type="BUTTON" name="AssociationMaintenance" 
		value="Associations"
		 onclick=AMaint()>
</form>
</div>
<div class="content" id="DeveloperNote">
<ol>
	<li> Separate skaters by NorCal, SoCal and Both - for easier 
		division building - done</li>
        <li> Home tab does for results entry does not work for Safari </li>
        <li> Hrefs in Safari don't work </li>
	<li> Need way to flag descrepencies in timing/place (when place does not match time)</li>
	<li> Way to print out summary of divisions and distances</li>
	<li> Way to print out the results of a heat so that results can be checkedwithin time window</li>
	<li>Method for merging duplicate skaters</li>
	<li>Method for deleting skaters from results</li>
	<li>Virtual race scoring - done</li>
	<li>Add logo on results - done</li>
	<li>finish adding logos on heat cards - done</li>
	<li>press select start positions when printing heat card - rejected, drawing lanes in part of the racing experience</li>
	<li>Integrate into Content Manager</li>
	<li>Tie Breaking Rules? ...allow to fudge points?</li>
	<li>Make Notes field bigger</li>
	<li>Add general note for division</li>
	<li>Notes not coming out in any particular order</li>
</ol>

</div>
</body>
</html>
