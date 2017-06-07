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
include "ncsadb.php"
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
<h2>Membership Card </h2>
</div>  <!--top div -->

<div class="side">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body">
<?php
	$session_id = $vars->get_sessionid();
	echo "<input type=HIDDEN name='session_id' id='SESSION_ID' value='$session_id'>";
	$skater_id = $vars->get_skaterid();

	$sql = "select skater_first,
		skater_last, skater_id, month(skater_dob) as bmonth, 
		day(skater_dob) as bday, year(skater_dob) as byear,
		day(skater_renewaldate) as rday, month(skater_renewaldate) as rmonth,
		year(skater_renewaldate) as ryear,
		year(skater_joindate) as jyear,
		title
	from skaters, skater_titles
	where 
	skater_id = '$skater_id'
		and skaters.title_id = skater_titles.title_id"
	;
	$database->runsql($sql, 
	$vars->get_debug());
	$row = $database->getrow();
?>

<div id="card" class="membercard">

	<div class="membercardexpires">Expires: 
<?php
	$expire_year=$row[ryear];
	$expire_year++;
	echo "$row[rmonth]/$row[rday]/$expire_year";
?>
	</div>

	<div class="membercardsince">Member Since: 
<?php
	echo " $row[jyear]";
?>
	</div>

	
	<div class="membercardbirthday">National Class:
<?php
	$age_group = calc_age_group($row[bmonth],$row[byear],7, 2012);
	#echo "$row[bmonth]/$row[bday]/$row[byear]";
	echo "$age_group";
?>

</div>
	<div class="membercardnumber">Member Number: 

<?php
	printf("%05d",$row[skater_id]);
?>
</div>
	<div class="membercardtitle">Northern California Speedskating Association </div>
<?php
	echo "<div class=\"membercardtitle1\">$row[title]</div>";
?>
	<div class="membercardname">
<?php
	echo "Member: $row[skater_first] $row[skater_last]";
?>
</div>
	<div class="membercarduss"><image src="cardlogo.png" height="75" width="80"/> </div>
	<div class="membercardlogo"><image src="ncsa_logo_for_membercard.jpg"/> </div>
	<div class="membercardurl">www.ncsa.us</div>
</div>  <!-- div id="membercard" -->




</div> <!--Body Div -->
</div>  <!--Container Div-->
</body>
</html>


