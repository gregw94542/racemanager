<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="ncsa.css" type="text/css">
	<link href="design.css" rel="stylesheet" type="text/css" />

	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="http://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script src="tabs.js" type="text/javascript"></script>
	<script type="text/javascript" src="tablesorter/jquery.tablesorter.js"></script> 
	
	<script src="divisionhelper.js" type="text/javascript"></script>
	<? include ("ncsadb.php")?>
	<title>NCSA Division Assistant</title>
</head>
<body>
<h1> Division Assistant</h1> 


<?php
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
	echo "<p id=\"raceid\">$RACE_ID</p>";

?>



<div id="controls" class="controls">
	<b>View and sort options</b>
	<table border=0>
		<tr>
			<td class="hat"><b>Skater Scoring Rules - </b></td>
			<td class="hat" colspan=1># times to analyze
				<select id="times_to_analyze">
					<option value="1">1</option>
					<option value="2"  selected>2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6"  >6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					
				</select>
			</td>
			<td class="hat" colspan=1> Number of previous seasons to factor in
					<select id="years_to_analyze">
					<option value="1">1</option>
					<option value="2"  selected>2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6"  >6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="99">All times</option>
		
				</select>
			</td>
		
		</tr>
		<tr>
			<td class="hat"><b>Race Generation Rules</b></td>
			<td class="hat">#events per division
				<select>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3" selected>3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			
			</td>
			<td class="hat">#minutes of ice time
				<select>
					<option value="60">60 min</option>
					<option value="75">75 min</option>
					<option value="90" selected>90 min</option>
					<option value="120">120 min (2 hrs)</option>
					<option value="180">180 min (3 hrs)</option>
					<option value="120">240 min (4 hrs)</option>
				</select>
			
			</td></tr>

		<tr>
			<td colspan=5 class="hat">
			<input type="button" id="refresh" value="Refresh">
				<input type="button" id="checkall" value="Check All">
				<input type="button" id="checknone" value="Check None">
				&nbsp;&nbsp;&nbsp;debug <input type="checkbox" id="debugflag">
			</td>

		</tr>

		
	</table>
</div>
<div id="hat" class="hat">
	All the names in the hat go here
</div>

<div id="skatersinrace" class="skatersinrace">
<div id="blue" class="groups"></div>
<div id="green" class="groups"></div>
<div id="red" class="groups"></div>	
	
	
</div>
<div id="blue" class="groups"></div>
<div id="green" class="groups"></div>
<div id="red" class="groups"></div>	



<div id="results" class="results">
	This is the results div
</div>

</body>
</html>
