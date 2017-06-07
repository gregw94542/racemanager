<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
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
	$raceid =$vars->get_raceid();
	$racename = $database->get_racename($raceid);
	echo "<title> NCSA Race Manager - Helmet Numbers $racename </title>";
?>
<body>


<?php



function display_helmets($id, $database) {

			$database->runsql("select association_id from races where race_id = $id", 0);
			$row = $database->getrow();
			## logo div
			if (is_states($row[association_id])){
				echo "<div style=\"float:right;position:absolute; 
						left:250;top:20;width:275;height:125\">";
				echo "<img src=\"NCSA_Logo_2008.jpg\" width=\"100\" height=\"68\">&nbsp;";
				echo "</div>";
				echo "<div style=\"float:right;position:absolute; 
						left:370;top:20;width:400;height:100\">";
				echo "<img src=\"usspeedskating.jpg\" width=\"180\" height=\"72\">";
				echo "</div>";
				echo "<div style=\"float:right;position:absolute; 
						left:570;top:20;width:275;height:125\">";
				echo "<img src=\"scssa_small.gif\" width=\"100\" height=\"68\">";
			} else if (is_ncsa($row[association_id])) {
				echo "<div style=\"float:right;position:absolute; 
					left:300;top:10;width:200;height:100\">";
				echo "<img src=\"usspeedskating.jpg\">";
				echo "</div>";
				echo "<div style=\"float:right;position:absolute; 
					left:700;top:10;width:200;height:100\">";
				echo "<img src=\"NCSA_Logo_2008.jpg\" width=\"150px\" height=\"100px\">";
			} else if (is_scssa($row[association_id])){
				echo "<div style=\"float:right;position:absolute; 
					left:300;top:10;width:200;height:100\">";
				echo "<img src=\"usspeedskating.jpg\">";
				echo "</div>";
				echo "<div style=\"float:right;position:absolute; 
					left:700;top:10;width:200;height:100\">";
				echo "<img src=\"scssa_small.gif\" width=\"150px\" height=\"100px\">";
			}
			echo "</div>";

		### end main div
		echo "<div class=\"body\">";
	    $database->runsql("select race_date, race_name 
			from races 
		where race_id= $id ", 0);
		$row = $database->getrow();
		$rdate = $row[race_date];
	    $rname = $row[race_name];


	    echo "<h1> $rname - Helmet Numbers - $rdate  </h1>";
		echo "<hr>";
		$database->runsql ("select helmet_num, s.skater_id , s.skater_first as first, s.skater_last as last
			from
			division_skaters d, skaters s
			where
				race_id = $id and
				d.skater_id = s.skater_id
			order by helmet_num,
				skater_last, skater_first", 0);
			echo "<table border=0>";
			echo "<tr>";
			echo "<th style=\"text-align: left;\"><u>Helmet</u></th><th style=\"text-align: left;\"><u>Skater</u></th>";
			echo "</tr>";
			while ($row = $database->getrow()){
				echo "<tr>";
				echo "<td class=\"title\" style=\"text-align: left; width: 100px;\">$row[helmet_num]</td>";
				echo "<td style=\"width: 200px;
					text-align: left;\">
					$row[first] $row[last]</td>";
				echo "</tr>";
			}
			echo "</table>";
		echo "</div>";
		echo "</div>";		### end main div

}



$race_id = $vars->get_race_id();
display_helmets($race_id, $database);



?>


</body>
</html>
