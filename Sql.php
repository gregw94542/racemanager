<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Sql Worksheet</title>
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
<h2>Sql Worksheet </h2>
</div>  <!--top div -->

<div class="side">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body">
<table>
<tr><td>Enter Sql</td></tr>
<tr><td>
	<form  id="sqlform"  action="Sql.php" method="post"  enctype="multipart/form-data" name="Sql" target="_parent">
<textarea name="SQL" id="SQL"  cols=100 rows="8">
<?php
	$foo = $vars->get_sql();
	echo $foo;
?>
</textarea>
</td></tr>
<tr><td><input type='submit' id='sqlsubmit' name='sqlsubmit' value='Run SQL'></td></tr>

<tr> <td>Results</td></tr>

<tr><td>
	<!--textarea name="Result" cols="100" rows="40"-->
	<table>
<?php
	$sql = $vars->get_sql();
	if ($sql != "") {
		$database->runsql ($sql, $vars->get_debug());
		$count = 1;
		while ($row = $database->getrow()) {
				echo "<tr>";
			$keys =  array_keys($row);
			$array_count = count ($keys);
			for ($x = 0; $x < $array_count; $x++) {
				$column = $keys[$x];
				echo  "<td class=\"left_sm_sql\">$row[$column]</td>";
			}
			echo "</tr>";
		}
	}

?>
	</table>
	
	<!--/textarea-->
	</td></tr>
</table>
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


