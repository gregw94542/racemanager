<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>View/Change Members</title>
<script type='text/javascript' src='jquery-1.4.2.js'></script>
<script type='text/javascript' src='EditMember.js'></script>
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
	$skater_id = $vars->get_skaterid();

	$database->runsql ("
		select 
			skater_id, skater_first, skater_last, 
			skaters.association_id, association_name, 

			year(skater_dob) as birthyear,
			month(skater_dob) as birthmonth,
			day(skater_dob) as birthday,

			year(skater_joindate) as joinyear,
			month(skater_joindate) as joinmonth,
			day(skater_joindate) as joinday,

			year(skater_renewaldate) as renewalyear,
			month(skater_renewaldate) as renewalmonth,
			day(skater_renewaldate) as renewalday,

			skater_email, 
			skater_address1,
			skater_city,
			skater_state,
			skater_zip,
			skater_sex,
			skater_role,
			skater_phone, 
			skater_mobile,
			title_id,
			skater_enabled
		from skaters, associations
		where skater_id = $skater_id",
		$vars->get_debug());
		$row = $database->getrow();
?>
<div class="container">

<div class="top">
<h2>Edit NCSA Members</h2>
</div>  <!--top div -->

<div class="side">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body">
<!--form action='javascript:void(0);' method='post'-->
<form action='EditMember1.php' method='post' enc-type='multipart/form-data'>
<table border=0>
<tr>
<td class="edittitle">First</td><td class="editfield" colspan=1><input class='editfield' type='text' name='FIRST_NAME' size=32 maxsize=32 id='FIRST_NAME' 
<?php
	echo "value=\"$row[skater_first]\"></td>";
?>

<td class="edittitle">Last</td><td colspan=2 class="editfield"><input class='editfield' type='text' name='LAST_NAME' id='LAST_NAME' size=32 maxsize=32 
<?php
	echo "value=\"$row[skater_last]\"></td>";
?>
</tr>

<tr>
<td class="edittitle">Address</td><td class="editfield"><input class='editfield' type='text' name='SKATER_ADDRESS1' id='SKATER_ADDRESS1' size=32 maxsize=100
<?php
	echo "value='$row[skater_address1]'></td>";
?>
</tr>
<tr>
<td class="edittitle">City</td><td class="editfield"><input class='editfield' type='text' name='SKATER_CITY' id='SKATER_CITY' size=32 maxsize=100
<?php
	echo "value='$row[skater_city]'></td>";
?>
<td class="edittitle">State</td><td class="editfield"><input class='editfield' type='text' name='SKATER_STATE' id='SKATER_STATE' size=4 maxsize=100
<?php
	echo "value='$row[skater_state]'>";
?>

<b>Zip :  </b> <input class='editfield' type='text' name='SKATER_ZIP' id='SKATER_ZIP' size=10 maxsize=20
<?php
	echo "value='$row[skater_zip]'></td>";
?>
</tr>
<tr>
<td class="edittitle">Home Phone</td><td class="editfield"><input class='editfield' type='text' name='SKATER_PHONE' id='SKATER_PHONE' size=32 maxsize=64
<?php
	echo "value='$row[skater_phone]'></td>";
?>
</tr>

<tr>
<td class="edittitle">Mobile Phone</td><td class="editfield"><input class='editfield' type='text' name='SKATER_MOBILE' id='SKATER_MOBILE' size=32 maxsize=64
<?php
	echo "value='$row[skater_mobile]'></td>";
?>
</tr>

<tr>
<td class="edittitle">Email</td><td class="editfield"><input class='editfield' type='text' name='SKATER_EMAIL' id='SKATER_EMAIL' size=32 maxsize=64
<?php
	echo "value='$row[skater_email]'></td>";
?>
</tr>
<tr>
<td  class="edittitle">Birthday:</td><td class="edittitle">
<?php
	echo "<select class='editfield' name='SKATER_MONTH' id='SKATER_MONTH'>";
	create_month_select($row[birthmonth]);
	echo "</select>";

	echo "<select class='editfield' name='SKATER_DAY' id='SKATER_DAY'>";
	create_date_select($row[birthday]);
	echo "</select>";

	echo "<select class='editfield' name='SKATER_YEAR' id='SKATER_YEAR'>";
	create_birthyear_select($row[birthyear]);
	echo "</select>";
?>
</tr>
<tr>
<td class="edittitle">Sex</td><td style="text-align: left;">
<?php
	if ( $row[skater_sex] == 'm') {
		$msel="selected ";
		$fsel=" ";
	} else {
		$fsel="selected";
		$msel=" ";
	}

	echo "<select id='SKATER_SEX' class=\"editfield\" name=\"SKATER_SEX\">";
	echo "<option value=\"m\" $msel>Male</option>";
	echo "<option value=\"f\" $fsel>Female</option>";
	echo "</select>";
	echo "</td></tr><tr>";

	echo "<td class='edittitle'>Assn</td>";
	$database->runsql("select association_name, association_id 
		from associations 
		order by association_name",0);
	echo "<td colspan=1 style='text-align:left;' >
		<select class='editfield' name='ASSOCIATION_ID' id='ASSOCIATION_ID'>\n";
	while ($assn = $database->getrow()){
		echo "<option value='$assn[association_id]'";
		if ($assn[association_id] == $row[association_id]){
			echo ' selected ';
		}

		echo ">$assn[association_name] ";
		echo "</option>\n";
		

	}
	echo "</select></td>";
?>
</tr>


<?php
	echo "<td class='edittitle'>Title</td>";
	$database->runsql("select title, title_id 
		from skater_titles 
		order by title",
		#1);
		$vars->get_debug());
	echo "<td colspan=1 style='text-align:left;' >
		<select class='editfield' name='TITLE_ID' id='TITLE_ID'>\n";
	while ($titles = $database->getrow()){
		echo "<option value='$titles[title_id]'";
		if ($titles[title_id] == $row[title_id]){
			echo ' selected ';
		}

		echo ">$titles[title] ";
		echo "</option>\n";
	}
	echo "<option value='ADD'>Add Title</option>";
	echo "</select></td>";
?>






</tr>
<tr>
<td class="edittitle">Member Since:</td><td class="edittitle">
<?php
	echo "<select class='editfield' name='JOIN_MONTH' id='JOIN_MONTH'>";
	create_month_select($row[joinmonth]);
	echo "</select>";

	echo "<select class='editfield' name='JOIN_DAY' id='JOIN_DAY'>";
	create_date_select($row[joinday]);
	echo "</select>";

	echo "<select class='editfield' name='JOIN_YEAR' id='JOIN_YEAR'>";
	create_birthyear_select($row[joinyear]);
	echo "</select>";
?>
<tr>
<td>
<?php
	$session_id = $vars->get_sessionid();
	echo "<input type=HIDDEN name='SKATER_ID' id='SKATER_ID' value='$skater_id'>";
	echo "<input type=HIDDEN name='session_id' id='SESSION_ID' value='$session_id'>";
?>

<input type='submit' id='EditMember' name='EditMember' value='Change User Info'/></td>
</tr>
</table>
</form>
<hr>
<p name="renewal" id="renewal">
<table>
	<tr>
	<td class="left"><b>Renewal</b></td>
	</tr><tr>
	<td>
<?php
	echo "<select class='editfield' name='RENEWAL_MONTH' id='RENEWAL_MONTH'>";
	create_month_select($row[renewalmonth]);
	echo "</select>";

	echo "<select class='editfield' name='RENEWAL_DATE' id='RENEWAL_DATE'>";
	create_date_select($row[renewalday]);
	echo "</select>";

	echo "<select class='editfield' name='RENEWAL_YEAR' id='RENEWAL_YEAR'>";
	create_birthyear_select($row[renewalyear]);
	echo "</select>";

	echo "&nbsp;<b> Renewal Amount</b> &nbsp";
	echo "<input class='editfield' type='text' name='RENEWAL_AMOUNT' id='RENEWAL_AMOUNT' size=4 maxsize=4></input>";
?>

	</td></tr>
	<tr><td class="left"><button id="renewal" name="renewal" >Renew Member</button></td></tr>
	</table>
</p>
<hr>
<p name="password" id="password">
<table>
	<tr>
	<td class="left"><b>Password Maintenance</b></td>
	</tr><tr>
	<td class="left"> Enter Password (characters will be visible): </td>
	<td class="left"><input type=text size=16 maxsize=16 id="new_password" name="new_password"</td></tr>
	<tr><td class="left"><button id="mypassword" name="mypassword" value="Greg">Change Password </button></td></tr>
	</table>
</p>
<p name="status" id="status"> Javascript is not running </p>

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


