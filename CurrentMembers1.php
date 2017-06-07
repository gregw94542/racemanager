<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Current Member Information</title>
<script type='text/javascript' src='jquery-1.4.2.js'></script>
<script type='text/javascript' src='CurrentMembers.js'></script>
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
<h2>Current Member Information</h2>
</div>  <!--top div -->

<div class="side">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body">
<form id="target" action='javascript:void(0);' method='post'>
<!---form action="foo.php" method="post" enctype="multipart/form-data" name="OpenRace" target="_parent"-->

<table>
<tr>
<td>

  Sort By: 
  <select name='SORT' id='SORT' class='SORT'>
	<option value='first'>First Name</option>
	<option value='last'>Last Name</option>
	<option value='birth'>Birth Date</option>
	<option value='renewal'>NCSA Renewal</option>
	<option value='gender'>Gender/DOB </option>
  </select>

<?php
	##### don't think I need this filter ########################
	if (0) {
  		echo "Association</td><td><select name='SKATER_ASSOCIATION' ";
		echo "id='SKATER_ASSOCIATION'>";
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
		echo "</select>";
	}
	
?>
</td>
<td>


<input type='submit'  value='search'>
</td>
</tr>
</table>
<p id='test'>Javascript code did not run...something is wrong...email greg@networkistics.com</p>
<p id='result'></p> 
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


