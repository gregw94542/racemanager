<?php
include "utility.php"
?>
<?php
	$vars = new VARS();
	$database = new DB();
	$first = $vars->get_firstname();
	$last = $vars->get_lastname();
	$association = $vars->get_skater_association();


	$database->runsql ("
		select 
			skater_id, skater_first, skater_last, 
			skaters.association_id, association_name, 
			year(skater_joindate) as jyear, 
			day(skater_renewaldate) as rday,
			month(skater_renewaldate) as rmon,
			year(skater_renewaldate) as ryear,
			day(skater_dob) as bday,
			month(skater_dob) as bmon,
			year(skater_dob) as byear,
			skater_email, 
			skater_address1,
			skater_city,
			skater_state,
			skater_zip,
			skater_sex,
			skater_role,
			title,
			skater_enabled
		from skaters, associations, skater_titles
		where skater_first like '$first%' and
                      skater_last like '$last%' and
		      skaters.association_id = associations.association_id and
			  #skaters.association_id = $association and
			  skaters.title_id = skater_titles.title_id
			
		order by association_name, skater_first, skater_last",
		#1);
		$vars->get_debug());

	echo "<table border=0>";
	$count = 1;
	while ($row = $database->getrow()) {
		echo "<tr>";
		echo "<td class=\"left_sm\"><b>$count</b></td>";
		echo "<td class=\"left_sm\"><b>Name:</b> 
			<a href=EditMember.php?SKATER_ID=$row[skater_id]";
		echo ">$row[skater_first]
			$row[skater_last]</a></td>";
		$count++;
		echo "<td class=\"left_sm\"><b>Assn:</b> $row[association_name]</td>";
		echo "<td class=\"left_sm\"><b>Member Since:</b> $row[jyear]</td>";
		echo "<td class=\"left_sm\"><b>Renewal Date: </b>";
		printf("%02d-%02d-%04d</td>", $row[rmon],$row[rday],$row[ryear]);
		echo "</tr>";

		echo "<tr>";
		echo "<td class=\"left_sm\"$</td>";
		echo "<td class=\"left_sm\"><b>m/f:</b> $row[skater_sex]</td>";
		echo "<td class=\"left_sm\"><b>Birthdate: </b>";
		printf("%02d-%02d-%04d</td>", $row[bmon],$row[bday],$row[byear]);
		echo "<td class=\"left_sm\"><b>email:</b> $row[skater_email]</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td class=\"left_sm\"$</td>";
		echo "<td class=\"left_sm\"><b>Address:</b> $row[skater_address1]</td>";
		echo "<td class=\"left_sm\"><b>City:</b> $row[skater_city]</td>";
		echo "<td class=\"left_sm\"><b>State:</b> $row[skater_state]</td>";
		echo "<td class=\"left_sm\"><b>Zip Code:</b> $row[skater_zip]</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td class=\"left_sm\"$</td>";
		#echo "<td class=\"left_sm\"><b>Role:</b> $row[skater_role]</td>";
		echo "<td class=\"left_sm\"><b>Title:</b> $row[title]</td>";
		echo "<td class=\"left_sm\"><b>Enabled:</b> $row[skater_enabled]</td>";
		echo "<td class=\"left_sm\"><b>Member#:</b> $row[skater_id]</td>";
		echo "</tr>";

		### kind of a hack, only printout membership cards for NCSA Association
		### this is association #1
		if ($association == 1 ) {
			echo "<tr>";
			echo "<td></td><td colspan=1 class=\"left_sm\"><a href=\"membershipcard.php?";
			echo "SKATER_ID=$row[skater_id]\">Print Membership Card</a>";
			echo "<td  colspan=2 class=\"left_sm\"><a href=\"memberhistory.php?";
			echo "SKATER_ID=$row[skater_id]\">Display Payment History </a>";
			echo "</td></tr>";
		}



		echo "<tr><td colspan=5><hr></td></tr>";
	}
	echo "</table>";
		
?>
