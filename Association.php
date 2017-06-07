<html>
<link rel="stylesheet" href="ncsa.css" type="text/css">
<title> NCSA Race Manager - Enable/Disable Races</title>
<body>
<? include ("ncsadb.php")?>

<script language=javascript>
function CreateAssn( )
{
	var xx = document.CreateAssociation.ASSOCIATION_NAME.value;
	var x = xx.length;
	if (x > 0) {
		alert ("create association")
		document.CreateAssociation.action="Association.php";
		document.CreateAssociation.submit();
	} else {
		document.CreateAssociation.action="racemanager.php";
		document.CreateAssociation.submit();
	}
	
	
}

</script>

<?php


$keys = array_keys($_POST);
foreach ($keys as $vars) {
echo "$vars = $_POST[$vars]<br>";
}

echo "<div class=\"story1\"><table>";
echo "<h3 width=75%>RACE: Associations Maintenance </h3>";
echo "<hr  class=\"hline\">";
###########################################################################

 if ($_POST[CREATE_ASSOCIATION] <>  "TRUE") {
	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
        mysql_select_db(get_db());

	##################################################
	#  Create Table if necessary
	##################################################
	$query = "create table if not exists associations (
			association_id int auto_increment primary key,
			association_name varchar(50),
			association_url  varchar(50)
		)";

	$result = mysql_query($query);
	mysql_close($conn);
?>
 	<h2>Add Association ! </h2>
 	<form action="Association.php" 
	      name="CREATE_ASSOCIATION"
              method="post" enctype="multipart/form-data" name="add_association" 
              target="_parent">
  	<table border=0>
  	<tr><td class=\"title\">Association Name</td>
		<td  class="input" colspan=2><input name="ASSOCIATION_NAME" type="text" 
              size="30" maxlength="50" value=""</input></td>
		<td class="title">URL</td>
		<td  class="input" colspan=2><input name="ASSOCIATION_URL" type="text" 
              size="32" maxlength="32" value="" </input>

		<input type="hidden" name="CREATE_ASSOCIATION" value="TRUE"></input></td>
		<td><input type="Submit" name="Submit" value="Create Association">
	</td></tr></table>
	</form>
<?php
  } else {
	$conn = mysql_connect(get_host(), get_user(), get_pass()) 
		or die ('Error connecting to mysql');
       	mysql_select_db(get_db());

	##################################################
	#  Create Table if necessary
	##################################################
	$query = "insert into associations 
		( association_name, association_url )
		values
		(\"$_POST[ASSOCIATION_NAME]\", \"$_POST[ASSOCIATION_URL]\")
		";
	echo "$query<br>";

	$result = mysql_query($query);
	mysql_close($conn);
	echo "<META HTTP-EQUIV=\"Refresh\" 
	CONTENT=\"1; URL=racemanager.php\">";

  }
?>
</body>
</html>
