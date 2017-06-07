<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>What US Speedskating Age Division Am I In? </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="/include/emx_nav_left.css" type="text/css">
<link rel="stylesheet" href="../include/networkistics.css" type="text/css">
</head>

<?include ("SpeedskatingRecords.php")?>
<?include ("../dev/surveydb.php")?>

<body>
<br><h1>What is my US Speedskating National Age Class?</h1><br>
<form action="http://www.networkistics.com/ncsa/getdiv.php" method="post" enctype="multipart/form-data" name="SignUp" target="_parent">
<h2>Birthday</h2>
<table border=0>
<tr> <td class=extra>&nbsp;</td><td class="name">Month</td> <td class="name">Day</td> <td class="name">Year</td></tr>
<tr> <td>&nbsp;</td><td class="combo"><select NAME="Month">
<?php
	$monthArray;
	$monthArray[1] = "January";
	$monthArray[2] = "February";
	$monthArray[3] = "March";
	$monthArray[4] = "April";
	$monthArray[5] = "May";
	$monthArray[6] = "June";
	$monthArray[7] = "July";
	$monthArray[8] = "August";
	$monthArray[9] = "September";
	$monthArray[10] = "October";
	$monthArray[11] = "November";
	$monthArray[12] = "December";

	for ($x = 1 ; $x < 13; $x++){
		if ($_POST[Month] == $x) {
				echo "<option VALUE=\"$x\" selected\">$monthArray[$x]";
		} else {
			echo "<option VALUE=\"$x\">$monthArray[$x]";
		}
	}
	echo "</select></td>";
	
?>



<?php
	#########################################################
        # handle combo box for data                            #
	$DATE = $_POST[Date];
	#########################################################
 	echo "<td class=\"combo\"><select NAME=\"Date\">";
	for ($x = 1; $x < 32; $x += 1){
		if ($_POST[Date] == $x) {
			echo "<option VALUE=\"$x\" selected\">$x";
		} else {
			echo "<option VALUE=\"$x\">$x";
		}
	}
	echo " </select> </td>";

	#########################################################
        # handle combo box for data                            #
	#########################################################
 	echo "<td class=\"combo\"><select NAME=\"Year\">";
	$my_t = getdate(date("U"));
	for ($x = $my_t[year]; $x > ($my_t[year]-80); $x -= 1){
		if ($_POST[Year] == $x) {
			echo "<option VALUE=\"$x\" selected\">$x";
		} else {
			echo "<option VALUE=\"$x\">$x";
		}
	}
	echo " </select> </td>";

	echo "</tr>";
	echo "<tr><td colspan=1>&nbsp;</td><td colspan=4>";
	if ($_POST[gender] == "m") {
		echo "Male<input type=\"radio\" name=\"gender\" value=\"m\" checked>";
		echo "Female<input type=\"radio\" name=\"gender\" value=\"f\">";
	} else {
		echo "Male<input type=\"radio\" name=\"gender\" value=\"m\">";
		echo "Female<input type=\"radio\" name=\"gender\" value=\"f\" checked>";
	} 
	echo "</td></tr>"
?>
</table>
	<input type="hidden" name="customer_hidden_name" value="NCSA">
	<input name="Submit" type="submit" value="submit">
</form>

<?php

############### end of functions main line starts here #####################

	#echo "-------POST<br>";
	#$keys = array_keys($_POST);
	#foreach ($keys as $vars){
		#echo "$vars = $_POST[$vars]<br>";
	#}

	#echo "-------SERVER<br>"; 
	#$keys = array_keys($_SERVER); 
	#foreach ($keys as $vars){ 
		#echo "$vars = $_SERVER[$vars]<br>";
	#}

	#echo "-------ENV<br>"; 
	#$keys = array_keys($_ENV);
	#foreach ($keys as $vars){
		#echo "$vars = $_ENV[$vars]<br>";
	#}

	$MONTH = $_POST[Month];
	$YEAR = $_POST[Year];
	$DATE = $_POST[Date];

	#echo "We got $MONTH, $DATE, $YEAR<br>";

	############################################################
	#  if birthmonth is June or earlier, calc on this year
        #  else, use next year for calculation
	############################################################
	if ($MONTH > 6) {	
		$CALCYEAR=$YEAR+1;
	} else {
		$CALCYEAR=$YEAR;
	}

	$my_t = getdate(date("U"));

	#echo "We got $MONTH, $DATE, $YEAR, $CALCYEAR<br>";
	#echo "Now - $my_t[month], $my_t[mday], $my_t[year]<br>";
	$NATIONALS_AGE=$my_t[year]-$CALCYEAR;
	#echo "Nationals Age = $NATIONALS_AGE<br>";

	if ($NATIONALS_AGE <= 10 ) {
		$NATIONAL_CLASS = "Pony";
	} elseif ($NATIONALS_AGE >= 11 && $NATIONALS_AGE <= 12){
		$NATIONAL_CLASS = "Midget";
	} elseif ($NATIONALS_AGE >= 13 && $NATIONALS_AGE <= 14){
		$NATIONAL_CLASS = "Juvenile";
	} elseif ($NATIONALS_AGE >= 15 && $NATIONALS_AGE <= 16){
		$NATIONAL_CLASS = "Junior";
	} elseif ($NATIONALS_AGE >= 17 && $NATIONALS_AGE <= 18){
		$NATIONAL_CLASS = "Intermediate";
	} elseif ($NATIONALS_AGE >= 19 && $NATIONALS_AGE <= 29){
		$NATIONAL_CLASS = "Senior";
	} elseif ($NATIONALS_AGE >= 30 && $NATIONALS_AGE <= 39){
		$NATIONAL_CLASS = "Masters 30";
	} elseif ($NATIONALS_AGE >= 40 && $NATIONALS_AGE <= 49){
		$NATIONAL_CLASS = "Masters 40";
	} elseif ($NATIONALS_AGE >= 50 && $NATIONALS_AGE <= 59){
		$NATIONAL_CLASS = "Masters 50";
	} elseif ($NATIONALS_AGE >= 60 && $NATIONALS_AGE <= 69){
		$NATIONAL_CLASS = "Masters 60";
	} elseif ($NATIONALS_AGE >= 70 ){
		$NATIONAL_CLASS = "Masters 70";
	}

	#################################################################
	# don't print stuff out if first time through
	#################################################################
	if (strlen($YEAR)){


	$keys = array_keys($_POST);
	#foreach ($keys as $vars){
	#	echo "$vars = $_POST[$vars]<br>";
	#}

	#####################################################################
	#### get customer_id based on customer_hidden_name post value    ####
	#####################################################################
	$cust_id = get_customer_id($_POST["customer_hidden_name"]);

	#####################################################################
	#### Concatinate all post variables together                     ####
	#####################################################################
	$postvars = "";

	$keys = array_keys($_POST);
	foreach ($keys as $vars){
		if ($vars != "Submit"){
			$postvars .= $vars . "=" . $_POST[$vars] . get_delimiter();
		}
	}

	$rightnow = time();

	#####################################################################
	#### create raw_data row to reference all data used in this post ####
	#### don't log if executing from dev directory                   ####
	#####################################################################

	$pwd = exec("pwd");
	if ($pwd != "/home/networki/public_html/dev") {
		$query = "insert into raw_data 
           	(ip_addr, port, customer_id, server_time, postvars, referer, user_agent, deleted)
	   values
	   (\"$_ENV[REMOTE_ADDR]\", \"$_ENV[REMOTE_PORT]\",
             \"$cust_id\", \"$rightnow\", \"$postvars\", 
	     \"$_SERVER[HTTP_REFERER]\",\"$_ENV[HTTP_USER_AGENT]\",
	     \"n\")";
		$conn = mysql_connect(get_host(), get_user(), get_pass()) or die ('Error connecting to mysql');
		mysql_select_db(get_db());
		$result = mysql_query($query);


		$query = "select last_insert_id() from dual";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$keys = array_keys($row);
		mysql_close($conn);
	}

	echo "<hr width=80%>";
	echo "<br><h2>How would I have done at the 2007 Short Track National?</h2>";
	echo "<br><b>Age on June 30 $my_t[year] : $NATIONALS_AGE Years Old";
	echo     "<br>National Class             : ";
	if ($_POST[gender] == "m") {
		$NATIONAL_CLASS = $NATIONAL_CLASS . " Men";
	} else {
		$NATIONAL_CLASS = $NATIONAL_CLASS . " Women";
	}
	echo "$NATIONAL_CLASS</b><br><br>";
	echo "Times from 2007 US National Short Track Championships<br>";

	showrecords($NATIONALS_AGE, $NATIONAL_CLASS, $_POST[gender]);

	echo "<hr width=80%>";
	echo "<h3>References</h3>";
	echo "<div class=\"reference_links\">";
	echo "Senior Times: <a href=http://www.ohiospeedskating.com/documents/pdf/senior_time_results_final.pdf>http://www.ohiospeedskating.com/documents/pdf/senior_time_results_final.pdf</a>";
	echo "<br>";
	echo "Age Group Times: <a href=http://www.ohiospeedskating.com/documents/pdf/age_group_time_results_final.pdf>http://www.ohiospeedskating.com/documents/pdf/age_group_time_results_final.pdf</a>";
	echo "<br>";
	echo "Masters Times: <a href=http://www.ohiospeedskating.com/documents/pdf/masters_time_results_final.pdf>http://www.ohiospeedskating.com/documents/pdf/masters_time_results_final.pdf</a>";
	echo "<br><br>";
	echo "Comments, corrections, requests for additions: " ;
	echo "<a href=\"mailto:greg@networkistics.com?subject=Age%20Calculator%20\"> <u>greg@networkistics.com</u></a>";
	echo "</div>";
	echo "<br>";
	}
		
?>


</body>


</body>
</html>
