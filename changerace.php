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

<title>Change Race</title>
<div class="container">

<div class="top">
<h2>Race Manager</h2>
Change Active Race
</div>  <!--top div -->


<div class="side" style="height: 300px;">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body">
<?php
	$raceid = $vars->get_race_id();

	$database->runsql("select race_name, race_id, race_date, association_name
	from races, associations
		where 
	race_enable <> 0 and
	races.association_id = associations.association_id
	order by race_date desc;", 0);


	echo "<form action=\"changerace.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"OpenRace\" target=\"_parent\"> ";

	echo "<select name=\"RACE_ID\" ID=\"RACE_ID\">";

	while ($row = $database->getrow()){
		if ($row[race_id] == $raceid)	{
			$selected = "selected";
		} else {
			$selected = "";
		}
		echo "<option VALUE=\"$row[race_id]\"
			$selected >$row[race_date] : $row[race_name] ($row[association_name])</option>";
	}
	echo "</select>";
?>
	<input name="Submit" type="Submit" value="Change Race">
</form>
</div> <!--Body Div -->
</div>  <!--Container Div-->


</div>  
</body>
</html>
