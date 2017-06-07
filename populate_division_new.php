<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<link href="design.css" rel="stylesheet" type="text/css"/>
<title> NCSA Race Manager - Open Race</title>
<body>
<? include ("ncsadb.php")?>
<? include "utility.php" ?>
<?php
	$vars = new VARS();
	$database = new DB();
	$vars->insert_css_file();


	$raceid = $vars->get_raceid();
	$divisionid = $vars->get_divisionid();
?>

<script src="tabs.js" type="text/javascript"></script>


<?php

function check_selected($id, $div)
{
$check_conn = mysql_connect(get_host(), get_user(), get_pass()) 
	or die ('Error connecting to mysql');
mysql_select_db(get_db());

$check_query = "select count(*) cnt from division_skaters
	where skater_id = '$id' and 
	 division_id = '$div'";
$check_result = mysql_query($check_query);
mysql_close($check_conn);
$check_row = mysql_fetch_array($check_result,MYSQL_ASSOC);

  if ($check_row[cnt] == 0){
  	$checked="";
  }else{
  	$checked = "checked";
  }
  return $checked;

}
function display_ncsa($msg) {
	$query = "select skater_first, skater_last, skater_id from skaters
		where association_id = 
			(select association_id from associations 
			where association_name = 'NCSA'
			  and is_active=1)
		order by skater_first, skater_last";	
	display_sub($query, $msg);
}

function display_scssa($msg){
	$query = "select skater_first, skater_last, skater_id from skaters
		where association_id = 
			(select association_id from associations 
			where association_name = 'SCSSA' 
			 and is_active=1)
		order by skater_first, skater_last";	
	display_sub($query, $msg);
}
function display_all($msg){
	$query = "select skater_first, skater_last, skater_id from skaters
		order by skater_first, skater_last";	
	display_sub($query, $msg);
}

function display_sub($query, $msg){

$vars = new VARS();
$database = new DB();
$raceid = $vars->get_raceid();
$RACE = $database->get_racename($raceid);

$divisionid = $vars->get_division_id();
$GROUP = $database->get_divisionname($divisionid);
echo "<div class=\"story1\"><table>";
echo "<h3 width=75%>$RACE - $GROUP ($msg)</h3>";
echo "<hr  class=\"hline\">";
###########################################################################




$database->runsql($query, 0);

$skaternames = array();
$array_index = 0;
 echo "<form action=\"populate_division1.php\" 
        method=\"post\" enctype=\"multipart/form-data\" 
	name=\"popdivision\" target=\"_parent\"> ";

while ( $row = $database->getrow()){
	$checked = check_selected($row[skater_id], $_POST[DIVISION_ID]);
	$skaternames[$array_index] = 
		"<input type=\"checkbox\" name='SELECTED_$array_index'
		  value=\"$row[skater_id]\" $checked
		>
		$row[skater_first] 
		$row[skater_last]
		";
	$array_index++;
}


$colcount = 4;			## number of columns
$num_rows = $array_index;	## rows in table = number skaters/columns
$display_rows = $array_index;	## rows in table = number skaters/columns
$display_rows /= $colcount;
$col_offset = $num_rows/$colcount;
if ($display_rows % $colcount) {	## if any remainder, add another row
	$display_rows ++;
}

echo "<table border=0>";

for ($x = 0; $x < $display_rows; $x++ ){
        $col1 = $x+(1*$col_offset);
        $col2 = $x+(2*$col_offset);
        $col3 = $x+(3*$col_offset);
        $col4 = $x+(4*$col_offset);
	echo "<tr>";
	echo "<td class=\"skater\">$skaternames[$x] </td>";
	echo "<td class=\"skater\">$skaternames[$col1] </td>";
	echo "<td class=\"skater\">$skaternames[$col2] </td>";
	echo "<td class=\"skater\">$skaternames[$col3] </td>";
	#echo "<td class=\"email\">$skaternames[$col4] </td>";
	echo "</tr>";
}
echo "</table>";

echo "<br>";
echo "<input type=\"hidden\" name=\"DIVISION_ID\" value=\"$_POST[DIVISION_ID]\">\n";
echo "<input type=\"hidden\" name=\"RACE_ID\" value=\"$_POST[RACE_ID]\">\n";
echo "<input name=\"Submit\" type=\"submit\"
  value=\"Update Division\"></form>" ;
echo "</div>";
}


$RACE = $vars->get_raceid();
$GROUP = $vars->get_divisionid();
?>

<div class="container">

<div class="top">
<h2>Race Manager</h2>
Select Competitors
</div>  <!--top div -->

<div class="side">
<?php
include "sidemenu.php"
?>
</div> <!--- class="side"> -->


<div class="body">

<ol id="toc">
	<li><a href=#NCSA> NCSA Only </a></li>
	<li><a href=#ALL> Select From All Skaters</a></li>
	<li><a href=#SCSSA> SCSSA Only </a></li>
</ol><br>

<div class="content" id="NCSA">
<?php
display_ncsa("NCSA Skaters");
?>
</div>

<div  class="content" id="ALL">
<?php
display_all("All Skaters");
?>
</div>




<div class="content" id="SCSSA">
<?php
display_scssa("SCSSA Skaters");
?>
</div>
</div> <!-- body  ---->
</div> <!-- container -->



</body>
</html>
