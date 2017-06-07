<?php
include "utility.php"
?>
<?php
	$vars = new VARS();
	$database = new DB();

	$skater_id = $vars->get_skaterid();

	$first = $vars->get_firstname();
	$last = $vars->get_lastname();
	$email = $vars->get_skater_email();
	$mon = $vars->get_skater_month();
	$day = $vars->get_skater_day();
	$year = $vars->get_skater_year();
	$sex = $vars->get_skater_sex();
	$assoc = $vars->get_skater_association();


	$title_id = $vars->get_titleid();

	$birthdate = date("$year-$mon-$day");

	
	$query = "select year(now()) as yr, 
			month(now()) as mn,
			day(now()) as dy
		from dual";

	$database->runsql($query, 
		#1);
		$vars->get_debug());
	$row = $database->getrow();

	$join = date("$row[yr]-$row[mn]-$row[dy]");




	$sql = "insert into  skaters
	  	(skater_first, skater_last,
	         skater_email, skater_dob,
		 skater_sex,
	       skater_joindate, association_id,
		   title_id)
		values (
			\"$first\",\"$last\", \"$email\", \"$birthdate\",
			\"$sex\",
			 \"$join\", $assoc, $title_id
		)";


	#echo "$sql";
	echo "The database entry for $first $last has been updated";
	$database->runsql($sql, 
		1);
		#$vars->get_debug());
	
?>
