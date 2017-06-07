<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<?php
include "utility.php"
?>
<?php
	$vars = new VARS();
	$database = new DB();
	$vars->insert_css_file();
?>

<title>Helmet Numbers</title>
<div class="container">

<div class="top">
<h2>Race Manager</h2>
Enter Helmet Numbers
</div>  <!--top div -->


<div class="side">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body">
<?php
	##$keys = array_keys($_POST);
	#foreach ($keys as $vars) {
	#echo "$vars = $_POST[$vars]<br>";
	$raceid = $vars->get_race_id();

	$database->runsql("select 
		division_skaters_id, division_skaters.skater_id, helmet_num,
		skater_first as first, skater_last as last
		from division_skaters, skaters
		where race_id = $raceid and
			skaters.skater_id = division_skaters.skater_id
		order by first, last",
		0);

	$count = 1;


	echo "<form action=\"Helmets1.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"OpenRace\" target=\"_parent\"> ";
	echo "<table>";
	while ($row = $database->getrow()){
		if ($row[helmet_num] == NULL)	{
			$helmet_num = "";
		} else {
			$helmet_num = $row[helmet_num];
		}
		echo "<tr>";

		echo "<td>$count) </td>";
		#echo "<td>$row[division_skaters_id] </td>";
		#echo "<td>$row[skater_id] </td>";
		echo "<td class=\"left\">$row[first] $row[last] </td>";
		echo "<td><input type=\"text\" 
			maxlength=\"3\"
			size=\"3\"
			name=\"$row[division_skaters_id]\"
			value=\"$helmet_num\"></td>";
		$count++;
		echo "</tr>";
	}
	echo "<tr><td colspan=3>";
	echo "<input type=\"hidden\" name=\"RACE_ID\" value=\"$raceid\">";
  	echo "<input name=\"Submit\" type=\"submit\" value=\"Change Helmets\">";
	echo "</td></td>";
	echo "</table>";
?>
</form>
</div> <!--Body Div -->
</div>  <!--Container Div-->


</div>  
</body>
</html>
