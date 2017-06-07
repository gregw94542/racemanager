<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Password Checking </title>
<?php
include "utility.php"
?>


<?php
	$vars = new VARS();
	$database = new DB();
	$skater_id = $vars->get_skaterid();

	$rmonth = $vars->get_renewal_month();
	$rday = $vars->get_renewal_day();
	$ryear = $vars->get_renewal_year();
	$ramount = $vars->get_renewal_amount();

	$renewal = date("$ryear-$rmonth-$rday");
	$ip = $vars->get_remote_addr();

	$sql = "update skaters set skater_renewaldate='$renewal'
		where skater_id = '$skater_id'";
	$database->runsql($sql, $vars->get_debug());

	$sql = "insert into renewal_dates (
				skater_id, 
				renewal_date, 
				renewal_entered_date,
				admin_id, renewal_amount, 
				renewal_id_addr)
			values (	
				'$skater_id', 
				'$renewal',
				now(),
				'1',
				'$ramount',
				'$ip'
			)";
	$database->runsql($sql, 
		#1);
		$vars->get_debug());

	echo "Changing Renewal Date To: $rmonth-$rday-$ryear";

?>
