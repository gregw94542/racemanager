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
	$datadir = "/home/networki/NcsaRawTimes";
	
?>

<?php
function display_times($file, $dir){
	$filepath = $dir . "/" . $file;
	$got_results = 0;
	
	if (($handle = fopen($filepath, "r"))){
		while (!feof($handle)){
			$buffer = fgets($handle);
			#echo "====$buffer====<br>";

			if (strpos($buffer,"From") !== false) {
				$from = $buffer;
			} else if (strpos($buffer, "Date") !== false) {
				$date = $buffer;
			} else if (strpos($buffer, "Subject") !== false) {
				$subject = $buffer;
			} else {
				if ($got_results == 0) {
					$results = $buffer;
					$times = explode(",",$buffer);
					$got_results = 1;
				}
			}
		} 
		
		fclose($handle);


		$x = count($times);

		echo "$date<br>";
		echo "$from<br>";
		echo "$subject<br>";
		echo "<table border=1>";
		echo "<tr>";
		for ($x = 0 ; $x < count($times)-1; $x++){
			echo "<td>$times[$x]</td>";
		}
		echo "</tr>";
		echo "</table>";
	}
}
?>


<title>Timer Display </title>
<div class="container">

<div class="top">
<h2>Timer Display Manager</h2>
Timer Display
</div>  <!--top div -->


<div class="body" style="text-align: left; padding: 10px; margin: 10px; left: 10px;">
<?php
	#if ($handle = opendir ("/home/networki/NcsaRawTimes")){
	if ($handle = opendir ($datadir)){
		#echo "Directory handle: $handle\n";
		#echo "Entries:\n";

		while (false != ($entry = readdir($handle))) {
			if (strpos($entry, '.ncsa') !== false) {
				#echo "$entry<br>";
				display_times($entry, $datadir);
			}
		}
	}
	closedir($handle);

?>
</div> <!--Body Div -->
</div>  <!--Container Div-->


</div>  
</body>
</html>
