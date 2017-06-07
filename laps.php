<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>fastest time calculator</title>
<script type='text/javascript' src='jquery-1.4.2.js'></script>
<script type='text/javascript' src='laps.js'></script>
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
<h2>fastest time  Worksheet </h2>
</div>  <!--top div -->

<div class="side">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body">
<!--form  id="sqlform" action='javascript:void(0);' method='post'-->
<form  id="sqlform"  action='' method='post'>
<textarea name="SQL" id="SQL"  cols=80 rows="16">
select 
	distance, min, sec, hun ,
	race_enable, races.race_id,
	race_name, race_date
from raw_results, divisions, races
where skater_id = 1
	and distance = '500'
        and raw_results.division_id = divisions.division_id
	and divisions.race_id = races.race_id
	and ( (hun != 0) and (sec != 0) and (hun != 0))
	and race_date < ('2010-10-08')
order by min, sec, hun
limit   2
;
</textarea>

<br>
<input type='submit' id='sqlsubmit' name='sqlsubmit' value='Run SQL'>
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


