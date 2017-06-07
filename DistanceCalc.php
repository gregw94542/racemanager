
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

<title>Time From Video Assistant</title>
<div class="container">

<div class="top">
<h2>Time from Video Assistant</h2>
</div>  <!--top div -->


<div class="side" style="height: 730px;">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body" style="text-align: left; padding: 10px; margin: 10px;">

<table border=0>
<?php

 $starttime = 9;
 $increment = .5;
 $lastdistance = 10.5;

 $timeincrement = .25;
 $lasttime = 16;

#================= header row =============================================
echo "<tr><td></td><td></td><td class=\"tableentry_header\" colspan=8>laptime</td></tr>";
echo "<tr> <td class=\"tableentry_header\">dist from reference</td> <td width=100px>&nbsp;&nbsp;&nbsp </td>";
  for ($timeval = $starttime; $timeval < $lasttime; $timeval += $timeincrement) {
	echo "<td class=\"tableentry_header\">${timeval}s</td>";
 }
echo "</tr>";


#================= Table Body =============================================
 for ($foot = $increment ; $foot < $lastdistance; $foot += $increment) {
	echo "<tr>";
	printf( "<td class=\"tableentry_header_right\">%0.2f'</td><td></td>", $foot);
	for ($timeval = $starttime; $timeval < $lasttime; $timeval += $timeincrement) {
		$myvalue = ($foot*$timeval)/(111.11*3.28);
		printf ("<td class=\"tableentry\"><i>%01.2f</i></td>", $myvalue);
	}
	echo "</tr>";
 }
?>
</table>
<br><br><i>
The above table should be used to when extracting a time from a race video. This should be used when a time is deemed to be inaccurate by the race director.
<br><br>
The top row (x axis) it the reference lap time. Usually this will be extracted from the previous lap or from last lap.
<br><br>
The side row (y axis) is the distance from the reference skater (in feet) to the skater in question.
<br><br>
D = RT<br>
T = D/R<br>
&nbsp;&nbsp;&nbsp  = <u>(distance from reference skater)</u><br>
&nbsp;&nbsp;&nbsp;   (111.11m/ reference lap time) * (3.28 ft/meter)<br><br>
T<sub>diff</sub>  = <u>D<sub>diff in ft</sub></u><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp(364.544)<br>
 
</i>

</div> <!--Body Div -->
</div>  <!--Container Div-->


</div>  
</body>
</html>
