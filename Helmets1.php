<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<?php
include "utility.php"
?>
<?php
	$vars = new VARS();
	$database = new DB();
	$vars->insert_css_file();

         echo "<META HTTP-EQUIV=\"Refresh\"";
         echo "CONTENT=\"0; URL=racemanager.php?";
         $vars->insert_raceid();
         echo "\">";
?>

<?php
	$keys = array_keys($_POST);
	foreach ($keys as $vars1) {
		switch ($vars1){
			case "RACE_ID":
			case "Submit":
			break;
			default:
				$hnum = $_POST[$vars1];
				$database->runsql( "update division_skaters 
					set helmet_num = \"$hnum\"
					where division_skaters_id = $vars1",0);
				
			break;
			
		}
	}
	$raceid = $vars->get_race_id();
?>

</body>
</html>
