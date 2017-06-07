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

<title>Change Race</title>
<div class="container">

<div class="top">
<h2>Race Manager</h2>
Create/Edit Division
</div>  <!--top div -->


<div class="side">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body">
<?php
	
	$raceid = $vars->get_race_id();
	$race_name = $database->get_racename($raceid);

	echo "<table><tr>";
	echo "<form action=\"OpenRace.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"OpenRace\" target=\"_parent\"> ";
	echo "<td> Create Division for:  $race_name</td>";
	echo  "<td> <input name=\"DIVISION_NAME\" type=\"text\"
              size=\"12\" maxlength=\"32\" value=\"\"</td>";

	echo "<input type=\"hidden\" name=\"RACE_ID\" value=\"$raceid\">\n";
	echo "<input type=\"hidden\" name=\"CREATE_DIVISION\" value=\"TRUE\">\n";

?>
	<td> <input name="Submit" type="Submit" value="Create Division"> </td>
</form>
	</tr></table>
	<hr>

<?php
  	$database->runsql("select division_name, division_start_order, race_id, division_id
	 from divisions 
              where race_id = \"$raceid\"
              order by division_name",0);


	while ( $row = $database->getrow()) {
		#echo "$row[division_start_order] - $row[division_name]";
		echo "<div class=\"story1\">";
		echo "<u><h3><a href=editdivision.php?DIVISION_ID=$row[division_id]&RACE_ID=$raceid>
			$row[division_name]</a>";
		echo "</u></h3>";
		$database->display_division($row[division_id], $raceid);
		$database->display_distances($row[division_id]);
		echo "<table><tr><td>";
		echo "<form action=\"populate_division_new.php\" 
             		 method=\"post\" enctype=\"multipart/form-data\"
			 name=\"popdivision\" target=\"_parent\">";
		echo "<input type=\"hidden\" name=\"DIVISION_ID\" 
			value=\"$row[division_id]\">";
		echo "<input type=\"hidden\" name=\"RACE_ID\" 
			value=\"$raceid\">";
  		echo "<input name=\"Submit\" type=\"submit\"
  			value=\"Add/Change Skaters to $row[division_name]\">";
		echo "</form>\n";
		echo "</td><td>";
		echo "<form action=\"DivisionDistances_new.php\" 
             		 method=\"post\" enctype=\"multipart/form-data\"
			 name=\"division_distances\" target=\"_parent\">";
		echo "<input type=\"hidden\" name=\"DIVISION_ID\" 
			value=\"$row[division_id]\">";
		echo "<input type=\"hidden\" name=\"RACE_ID\" 
			value=\"$raceid\">";
  		echo "<input name=\"Submit\" type=\"submit\"
  			value=\"Add/Change Distances Skated\">";
		echo "</form>\n";
		echo "</td><td>";
		echo "<form action=\"DivisionEnterResults.php\" 
             		 method=\"post\" enctype=\"multipart/form-data\"
			 name=\"division_distances\" target=\"_parent\">";
		echo "<input type=\"hidden\" name=\"DIVISION_ID\" 
			value=\"$row[division_id]\">";
		echo "<input type=\"hidden\" name=\"RACE_ID\" 
			value=\"$raceid\">";

####
## Greg change 1/23/ because of Gene
###
  		#echo "<input name=\"Submit\" type=\"submit\"
  			#value=\"Add/Change Results\">";
		#echo "</form>\n";

		echo "</td></tr></table>";
		echo "</div><hr width=66%>";
	}
?>


</div> <!--Body Div -->
</div>  <!--Container Div-->


</div>  
</body>
</html>
