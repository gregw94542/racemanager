<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>View/Change Members</title>
<script type='text/javascript' src='jquery-1.4.2.js'></script>
<script type='text/javascript' src='CreateSkater.js'></script>
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
		echo " <input type=\"radio\" id=\"ASSOCIATION\" name=\"ASSOCIATION_ID\" value=\"$row[association_id]\"";
		if ($id == $row[association_id]){
			echo " checked ";
		}
		echo ">$row[association_name] ";
	}
}

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
?>
<div class="container">

<div class="top">
<h2>Create Members</h2>
</div>  <!--top div -->

<div class="side">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->

<div class="body">
<form action='javascript:void(0);' method='post'>


<!--input type='submit' id='membersubmit' name='membersubmit' value='search'-->
</td>
</tr>
</table >
<?php
  	echo "	<table border=0>";
  	echo "<tr><td class=\"left_bold\">First</td>\n";
  	echo  "<td  class=\"input\" colspan=2><input id=\"FIRST_NAME\" name=\"FIRST_NAME\" type=\"text\" 
              size=\"24\" maxlength=\"32\" value=\"\"</td></tr>";
  	echo "<tr><td class=\"left_bold\">Last</td>\n";
  	echo  "<td  class=\"input\" colspan=2><input id=\"LAST_NAME\" name=\"LAST_NAME\" type=\"text\" 
              size=\"24\" maxlength=\"32\" value=\"\"</td> </tr>\n";
  	echo "<tr> <td class=\"left_bold\">Birthdate (mmddyy)</td>\n";
  	echo " <td class=\"input\"><input id=\"SKATER_MONTH\" name=\"BIRTH_MON\" type=\"text\" size=\"2\" 
		maxlength=\"2\" value=\"\"><input id=\"SKATER_DAY\" name=\"BIRTH_DAY\" type=\"text\" 
		size=\"2\" maxlength=\"2\" value=\"\"><input id=\"SKATER_YEAR\" name=\"BIRTH_YEAR\" 
		type=\"text\" size=\"4\" maxlength=\"4\" value=\"\"></td></tr>\n";
  	echo "<tr><td class=\"left_bold\">Email</td>\n";
  	echo "<td class=\"input\" colspan=4><input id=\"SKATER_EMAIL\" name=\"EMAIL\" type=\"text\" 
		size=\"30\" maxlength=\"100\" value=\"\"</td></tr>\n";
  	echo "<tr><td class=\"left_bold\">Sex (m/f)</td>\n";
  	echo "<td class=\"input\"><input id=\"SKATER_SEX\" name=\"SEX\" type=\"text\" size=\"1\" 
		maxlength=\"1\" value=\"\"</td></tr>\n";


  	echo "<tr>";
	echo "<td class=\"left_bold\">Association</td>";
	echo "<td colspan = 3>";
	display_association(1);
	echo "</td></tr>";

  	echo "<tr>";
	echo "<td class=\"left_bold\">Member Type</td>";
	echo "<td colspan = 3 class=\"input\">";
	display_title(1);
	echo "</td></tr>";

  	echo "<tr><td><input id=\"CreateMember\" name=\"Create Member\" type=\"submit\"" ;
	echo "</tr>";
	echo "</table>";
?>

<p id='status'>Javascript code did not run...something is wrong...email greg@networkistics.com</p>
</form>


</div> <!--Body Div -->
</div>  <!--Container Div-->
</body>
</html>


