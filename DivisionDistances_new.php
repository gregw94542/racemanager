<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager Set Up Distances</title>
<body>
<? include ("ncsadb.php")?>
<? include ("utility.php")?>

<?php
	$vars = new VARS();
	$database = new DB();
	$vars->insert_css_file();
?>

<div class="container">

<div class="top">
<h2>Race Manager</h2>
Create/Edit Division -- Configure Race Distances
</div>  <!--top div -->


<div class="side">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body">

<?php

function populate_select($distance)
{

#	echo "distance = $distance<br>";

	if (!strcmp($distance,"0")) {
		$selected = "selected";
	} else {
		$selected = "";
	}
	echo "<option Value=\"0\" $selected>Not Run</option>\n";

	if (!strcmp($distance,"111")) {
		$selected = "selected";
	} else {
		$selected = "";
	}
	echo "<option Value=\"111\" $selected>111 meters</option>\n";


	if (!strcmp($distance,"222")) {
		$selected = "selected";
	} else {
		$selected = "";
	}
	echo "<option Value=\"222\" $selected>222 meters</option>\n";


	if (!strcmp($distance, "333")) {
		$selected = "selected";
	} else {
		$selected = "";
	}
	echo "<option Value=\"333\" $selected>333 meters</option>\n";

	if (!strcmp($distance, "444")) {
		$selected = "selected";
	} else {
		$selected = "";
	}
	echo "<option Value=\"444\" $selected>444 meters</option>\n";

	if (!strcmp($distance, "500")) {
		$selected = "selected";
	} else {
		$selected = "";
	}
	echo "<option Value=\"500\" $selected>500 meters</option>\n";
	
	if (!strcmp($distance,"611")) {
		$selected = "selected";
	} else {
		$selected = "";
	}
	echo "<option Value=\"611\" $selected>611 meters</option>\n";


	if (!strcmp($distance,"777")) {
		$selected = "selected";
	} else {
		$selected = "";
	}
	echo "<option Value=\"777\" $selected>777 meters</option>\n";

	if (!strcmp($distance,"1000")) {
		$selected = "selected";
	} else {
		$selected = "";
	}
	echo "<option Value=\"1000\" $selected>1000 meters</option>\n";


	if (!strcmp($distance,"1500")) {
		$selected = "selected";
	} else {
		$selected = "";
	}
	echo "<option Value=\"1500\" $selected>1500 meters</option>\n";


	if (!strcmp($distance,"3000")) {
		$selected = "selected";
	} else {
		$selected = "";
	}
	echo "<option Value=\"3000\" $selected>3000 meters</option>\n";



	if (!strcmp($distance,"999")) {
		$selected = "selected";
	} else {
		$selected = "";
	}
	echo "<option Value=\"9999\" $selected>ice cut</option>\n";
}

	$keys = array_keys($_POST);
	foreach ($keys as $vars) {
#	echo "$vars = $_POST[$vars]<br>";
	}
?>

<?php
$conn = mysql_connect(get_host(), get_user(), get_pass()) 
	or die ('Error connecting to mysql');
mysql_select_db(get_db());
$query = "select 
           division_distance1,
               division_distance2,
               division_distance3,
               division_distance4,
	       division_name
	from divisions 
	where division_id = \"$_POST[DIVISION_ID]\"";

#echo "$query<br>";

$result = mysql_query($query);
$row = mysql_fetch_array($result,MYSQL_ASSOC);
mysql_close($conn);
#echo "got $row[division_distance1] $row[division_distance2] $row[division_distance3] $row[division_distance4]<br>";

?>

<div class="inputbox">
<?php
echo "<h2>$row[division_name] : </h2>";
?>
<form action="DivisionDistances1.php" method="post" enctype="multipart/form-data" name="CreateRace" target="_parent">

<table><tr>
<td>First Race</td>
<td>Second Race</td>
<td>Third Race</td>
<td>Fourth Race</td></tr>
<?php

#	echo "$row[division_distance1]<br>"; 
#	echo "$row[division_distance2]<br>"; 
#	echo "$row[division_distance3]<br>"; 
#	echo "$row[division_distance4]<br>"; 
	echo "<td>";
	echo "<select name=first_race>";
	
	populate_select($row[division_distance1]);
?>
<td><select name=second_race>
<?php
	populate_select($row[division_distance2]);
?>
<td><select name=third_race>
<?php
	populate_select($row[division_distance3]);
?>
<td><select name=fourth_race>
<?php
	populate_select($row[division_distance4]);
	echo "</select>";

	$vars = new VARS();

	$raceid = $vars->get_raceid();
	$division_id = $vars->get_divisionid();

	#echo "raceid: $raceid divisionid: $$division_id";


  echo "<input type=\"hidden\" name=\"DIVISION_ID\" value=\"$division_id\">\n";
  echo "<input type=\"hidden\" name=\"RACE_ID\" value=\"$raceid\">\n";
  echo "<input name=\"Submit\" type=\"submit\"
  		value=\"Change Distances Skated\">";
?>
</form>
</div> <!-- body -->
</div> <!-- container -->

</body>
</html>
