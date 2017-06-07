<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<?php
include "ncsadb.php"
?>
<?php
include "utility.php"
?>
<?php
	$vars = new VARS();
	$database = new DB();
	$vars->insert_css_file();
	
?>

<?php
function print_slip() {
	echo "<div style=\" border-style: solid; 
		border-color:blue; border-width:1px;
		width:350px; height:200px;
		font-size: 20px;
		font-weight: normal;
		padding: 20px;
		\"
	>";
	echo "<table border=0>";
	echo "<tr height=20px><td></td><td></td></tr>";
	echo "<tr ><td class=\"timing\" colspan=1 >Event #:</td><td class=\"timing\">________</td></tr>";
	echo "<tr><td class=\"timing\">Helmet#:</td><td class=\"timing\">_______</td></tr>";
	echo "<tr><td class=\"timing\" colspan=1>Place:</td>";
	echo "<td class=\"timing_place\"> 1 2 3 4 5 6 7 8 dnf  </td></tr>";
	echo "<tr><td colspan=1 class=\"timing\">Time:</td>";
	echo "<td class=\"timing\">_____:_____:_____</td></tr>";
	echo "<tr><td class=\"timing\"  colspan=1 >Initials :</td><td class= \"timing\">__________________</td></tr>";
	echo "</table>";
	echo "</div>";
}
?>

<title>Change Race</title>
<div class="container">

<div class="top">
<h2>Race Manager</h2>
Timing Slips
</div>  <!--top div -->


<div class="body" style="text-align: left; padding: 10px; margin: 10px; left: 10px;">
<table border=0>
 <?php
	for ($x = 0; $x < 4; $x++) {
		echo "<tr><td width=350px height=200px>";
		print_slip();
		echo "</td><td width=350px height=100px>";
		print_slip();
		echo "</td></tr>";
	}
?>
</table>
</div> <!--Body Div -->
</div>  <!--Container Div-->


</div>  
</body>
</html>
