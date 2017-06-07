<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager Skater Maintenance</title>
<body>
<? include ("ncsadb.php")?>

<?php

function display_title($id)
{

  	$query = "select title, title_id from skater_titles
		order by title";
	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
        mysql_select_db(get_db());
        $result = mysql_query($query);
	mysql_close($conn);

	echo "<select class='edittitle' name='TITLE_ID' id='TITLE_ID'>";
	while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
		echo " <option value=\"$row[title_id]\"";
		if ($id == $row[title_id]){
			echo " selected ";
		}
		echo ">$row[title]</option> ";
	}
	echo "</select>";
}
function display_association($id)
{

  	$query = "select association_name, association_id from associations
		order by association_name";
	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
        mysql_select_db(get_db());
        $result = mysql_query($query);
	mysql_close($conn);

	while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
		echo " <input type=\"radio\" name=\"ASSOCIATION_ID\" value=\"$row[association_id]\"";
		if ($id == $row[association_id]){
			echo " checked ";
		}
		echo ">$row[association_name] ";
	}
}
 



#$keys = array_keys($_POST);
#foreach ($keys as $vars) {
#echo "$vars = $_POST[$vars]<br>";
#}

#$keys = array_keys($_GET);
#foreach ($keys as $vars) {
#echo "$vars = $_GET[$vars]<br>";
#}

if ($_POST[CREATE_SKATER] == TRUE){
	$create_skater = "TRUE";
} else {
	$create_skater = "FALSE";
}

if ($_POST[SKATER_ID] != NULL)
   $skater_id = $_POST[SKATER_ID];

if ($_GET[SKATER_ID] != NULL)
   $skater_id = $_GET[SKATER_ID];

if ($create_skater == "TRUE") {
	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
	mysql_select_db(get_db());
	$birth_date = date("$_POST[BIRTH_YEAR]-$_POST[BIRTH_MON]-$_POST[BIRTH_DAY]");
	$query = "insert into skaters(skater_first, skater_last, skater_dob, 
		skater_email, skater_sex, association_id, title_id) 
		values ('$_POST[FIRST_NAME]', 
		'$_POST[LAST_NAME]', '$birth_date', 
		'$_POST[EMAIL]', '$_POST[SEX]', 
		'$_POST[ASSOCIATION_ID]',
		'$_POST[TITLE_ID]')";
	echo $query;
	$result = mysql_query($query);
}

?>
<div class="inputbox">
<?php

 if ($_GET[SKATER_ID] == NULL) {
 	echo "<h2>Add Skater </h2>";
 	echo "<form action=\"skatermain.php\" 
              method=\"post\" enctype=\"multipart/form-data\" name=\"addskater\" 
              target=\"_parent\"> ";
  	echo "	<table border=0>";
  	echo "<tr><td class=\"title\">First</td>\n";
  	echo  "<td  class=\"input\" colspan=2><input name=\"FIRST_NAME\" type=\"text\" 
              size=\"12\" maxlength=\"32\" value=\"\"</td>";
  	echo "<td class=\"title\">Last</td>\n";
  	echo  "<td  class=\"input\" colspan=2><input name=\"LAST_NAME\" type=\"text\" 
              size=\"12\" maxlength=\"32\" value=\"\"</td> </tr>\n";
  	echo "<tr> <td class=\"title\">Birthdate (mmddyy)</td>\n";
  	echo " <td class=\"info\"><input name=\"BIRTH_MON\" type=\"text\" size=\"2\" 
		maxlength=\"2\" value=\"\"><input name=\"BIRTH_DAY\" type=\"text\" 
		size=\"2\" maxlength=\"2\" value=\"\"><input name=\"BIRTH_YEAR\" 
		type=\"text\" size=\"4\" maxlength=\"4\" value=\"\"></td></tr>\n";
  	echo "<tr><td class=\"title\">Email</td>\n";
  	echo "<td class=\"input\" colspan=4><input name=\"EMAIL\" type=\"text\" 
		size=\"30\" maxlength=\"100\" value=\"\"</td></tr>\n";
  	echo "<tr><td class=\"title\">Sex (m/f)</td>\n";
  	echo "<td class=\"input\"><input name=\"SEX\" type=\"text\" size=\"1\" 
		maxlength=\"1\" value=\"\"</td></tr>\n";


  	echo "<tr>";
	echo "<td class=\"title\">Association</td>";
	echo "<td colspan = 3>";
	display_association(1);
	echo "</td></tr>";

  	echo "<tr>";
	echo "<td class=\"title\">Member Type</td>";
	echo "<td colspan = 3>";
	display_title(1);
	echo "</td></tr>";

	echo "<input type=\"hidden\" name=\"CREATE_SKATER\" value=\"TRUE\">\n";
  	echo "<tr><td>&nbsp;</td><td><input name=\"Submit\" type=\"submit\" 
		value=\"Add Skater\"></td>\n";
  } else {


	echo "<h2>Edit Skater </h2>";
	$query = "select skater_first, skater_last, skater_email, skater_sex, 
		skater_dob, association_id , title_id from skaters where skater_id = '$skater_id'";

	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
  	mysql_select_db(get_db());
  	$result = mysql_query($query);
  	mysql_close($conn);
  	$row = mysql_fetch_array($result,MYSQL_ASSOC);
   	$days = split("-", $row[skater_dob],3); 
	echo "<form action=\"skatermain1.php\" method=\"post\" enctype=\"multipart/form-data\" name=\"addskater\" target=\"_parent\"> ";
  	echo "	<table border=0>";
  	echo "<tr><td class=\"title\">First</td>\n";
  	echo "<td  class=\"input\" colspan=2><input name=\"FIRST_NAME\" 	
	      type=\"text\" size=\"12\" maxlength=\"32\" value=\"$row[skater_first]\"</td>";
  	echo "<td class=\"title\">Last</td>\n";
  	echo "<td  class=\"input\" colspan=2><input name=\"LAST_NAME\" 
	      type=\"text\" size=\"12\" maxlength=\"32\" 
	      value=\"$row[skater_last]\"</td></tr>\n";

  	echo "<tr> <td class=\"title\">Birthdate (mmddyy)</td>\n";
  	echo " <td class=\"info\"><input name=\"BIRTH_MON\" type=\"text\" size=\"2\" 
	     maxlength=\"2\" value=\"$days[1]\"><input name=\"BIRTH_DAY\" 
	     type=\"text\" size=\"2\" maxlength=\"2\" value=\"$days[2]\">
	     <input name=\"BIRTH_YEAR\" type=\"text\" size=\"4\" maxlength=\"4\" 
	     value=\"$days[0]\"></td></tr>\n";

  	echo "<tr><td class=\"title\">Email</td>\n";
  	echo "<td class=\"input\" colspan=4><input name=\"EMAIL\" type=\"text\" 
	      size=\"30\" maxlength=\"100\" value=\"$row[skater_email]\"</td></tr>\n";
  	echo "<tr><td class=\"title\">Sex (m/f)</td>\n";
  	echo "<td class=\"input\">";
	
	if ($row[skater_sex] == "m"){
		$ssex = "m";
	} else {	
		$ssex = "f";
	}
	echo "<input type=\"radio\"  name=\"SEX\"  value = \"m\" ";
	if ($ssex == "m") {
		echo " checked ";
	}
	echo "> M ";
	echo "<input type=\"radio\"  name=\"SEX\"  value = \"f\" ";
	if ($ssex == "f") {
		echo " checked ";
	}
	echo "> F ";
	echo "</td></tr>\n";

	echo "<input type=\"hidden\" name=\"UPDATE_SKATER\" value=\"TRUE\">\n";
	echo "<input type=\"hidden\" name=\"SKATER_ID\" value=\"$skater_id\">\n";

	if ($row[association_id] == NULL) {
		$ASSOCIATION_ID = 1;
	} else {
		$ASSOCIATION_ID = $row[association_id];
	}
	
  	echo "<tr>";
	echo "<td class=\"title\">Association</td>";
	echo "<td colspan = 3>";
	display_association($ASSOCIATION_ID);
	echo "</td></tr>";

  	echo "<tr>";
	echo "<td class=\"title\">Title</td>";
	echo "<td colspan = 3>";
	display_title($row[title_id]);
	echo "</td></tr>";
  	echo "<tr><td>&nbsp;</td><td><input name=\"Submit\" type=\"submit\" 
             value=\"Change\"></td>\n";
  }
?>
</table>
</form>
</div>

<div class="inputbox">
<h2>Skaters</h2>
<?php

	$skaternames = array();
  	$query = "select skater_first, skater_last, skater_id from skaters 
		order by skater_first, skater_last";
	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
        mysql_select_db(get_db());
        $result = mysql_query($query);
	mysql_close($conn);

	$array_index = 0;

	while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
		#echo "<br>";
		#echo "<a href=\"skatermain.php?SKATER_ID=$row[skater_id]&UPDATE_SKATER=TRUE\">$row[skater_first] $row[skater_last]</a>";
		$skaternames[$array_index] = "<a href=\"skatermain.php?SKATER_ID=$row[skater_id]&UPDATE_SKATER=TRUE\">$row[skater_first] $row[skater_last]</a>";
		$array_index++;
	}

	$colcount = 5;			## number of columns
	$num_rows = $array_index;	## rows/table = number skaters/columns
	$display_rows = $array_index;	## 
	$display_rows /= $colcount;
	$col_offset = $num_rows/$colcount;
	if ($display_rows % $colcount) {## if any remainder, add another row
		$display_rows ++;
	}



	echo "<table>";
	for ($x = 0; $x < $display_rows; $x++  ){
        	$col1 = $x+(1*$col_offset);
        	$col2 = $x+(2*$col_offset);
        	$col3 = $x+(3*$col_offset);
        	$col4 = $x+(4*$col_offset);
		echo "<tr>";
		echo "<td class=\"email\">$skaternames[$x] </td>";
		echo "<td class=\"email\">$skaternames[$col1] </td>";
		echo "<td class=\"email\">$skaternames[$col2] </td>";
		echo "<td class=\"email\">$skaternames[$col3] </td>";
		echo "<td class=\"email\">$skaternames[$col4] </td>";
		echo "</tr>";
	}
	echo "</table>";
?>

</div>

<div class="inputbox">
<br>
<a href="racemanager.php">Return to main</a>
&nbsp;&nbsp;&nbsp
</div>
</body>
</html>
