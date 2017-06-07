<?php
include "utility.php"
?>
<?php
	$vars = new VARS();
	$database = new DB();

	$skater_id = $vars->get_skaterid();

	$first = $vars->get_firstname();
	$last = $vars->get_lastname();
	$address = $vars->get_skater_address();
	$city = $vars->get_skater_city();
	$state = $vars->get_skater_state();
	$zip = $vars->get_skater_zip();
	$email = $vars->get_skater_email();
	$mon = $vars->get_skater_month();
	$day = $vars->get_skater_day();
	$year = $vars->get_skater_year();
	$sex = $vars->get_skater_sex();
	$assoc = $vars->get_skater_association();
	$rmon = $vars->get_renewal_month();
	$rday = $vars->get_renewal_day();
	$ryear = $vars->get_renewal_year();

	$jmon = $vars->get_join_month();
	$jday = $vars->get_join_day();
	$jyear = $vars->get_join_year();

	$phone = $vars->get_phone();
	$mobile = $vars->get_mobile();

	$title_id = $vars->get_titleid();

	$birthdate = date("$year-$mon-$day");
	$renewal = date("$ryear-$rmon-$rday");
	$join = date("$jyear-$jmon-$jday");


	$sql = "update skaters
	   set skater_first='$first',
	       skater_last='$last',
	       skater_address1='$address',
	       skater_city='$city',
	       skater_state='$state',
	       skater_zip='$zip',
	       skater_email='$email',
	       skater_dob='$birthdate',
	       skater_joindate='$join',
	       skater_sex='$sex',
		   skater_phone='$phone',
		   skater_mobile='$mobile',
	       association_id='$assoc',
		   title_id = '$title_id'
	where skater_id = '$skater_id'";

	#echo "$sql";
	echo "The database entry for $first $last has been updated";
	$database->runsql($sql, 
		#1);
		$vars->get_debug());
	
?>
