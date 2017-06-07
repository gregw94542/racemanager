<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>View/Change Members</title>
<script type='text/javascript' src='jquery-1.4.2.js'></script>
<script type='text/javascript' src='ViewMember.js'></script>
</head>
<?php
include "utility.php"
?>
<?php
	$vars = new VARS();
	$database = new DB();
	$vars->insert_css_file();
	write_head_tag($vars);
	write_body_tag( $vars, $database);
?>
<div class="container">

<div class="top">
<h2>View NCSA Members</h2>
</div>  <!--top div -->

<div class="side">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body">
<form action='javascript:void(0);' method='post'>
<table>
<tr>
<td>First</td><td><input type='text' name='FIRST_NAME' id='FIRST_NAME' size='32'</td>
<td>Last</td><td><input type='text' name='LAST_NAME' id='LAST_NAME' size='32'</td>
<td>Association</td><td><select name='SKATER_ASSOCIATION' 
	id='SKATER_ASSOCIATION'>
<?php
	$database->runsql("select association_id, association_name 
		from associations", 
		$vars->get_debug());
	while ($row = $database->getrow()){
		if ($row[association_name] == 'NCSA') {
			$selected = "selected";
		} else {
			$selected = "";
		}
		echo "<option value=$row[association_id] $selected>$row[association_name]</option>";
	}
	
?>
	</select>
</td>
<td>


<!--input type='submit' id='membersubmit' name='membersubmit' value='search'-->
</td>
</tr>
</table>
<p id='test'>Javascript code did not run...something is wrong...email greg@networkistics.com</p>
<p id='result'>Enter Name Of Skater </p> 
</form>

<?php
		
?>
<?php
#	$keys = array_keys($_REQUEST);
#	foreach ($keys as $var) {	
#		echo "$var = $_REQUEST[$var]<br>";
#	}
?>

</div> <!--Body Div -->
</div>  <!--Container Div-->
</body>
</html>


