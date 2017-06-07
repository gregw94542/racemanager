<?php
function debug($str)
{
	print "<br>=$str=<br>";
}

function make_association_combo($association)
{
$conn = mysql_connect(get_host(), get_user(), get_pass()) or 
	die ('Error connecting to mysql');
mysql_select_db(get_db());

$query = "select association_name, association_id 
   	from associations
	order by association_name";

	$result = mysql_query($query);
	echo "<select NAME=\"ASSOCIATION_ID\" ID=\"ASSOCIATION_ID\">\n";
	while ($row = mysql_fetch_array($result,MYSQL_ASSOC)){
		if ($row[association_id] == $association) {
			$selected = "selected";
		} else{
			$selected = "";
		}
		
		echo "<option VALUE=\"$row[association_id]\" $selected >$row[association_name]</option>\n";
	}
	echo "</select>";
}


class VARS
{
	
	private $user_id;
	private $session_id;
	private $race_id;
	private $division_id;

	private $birth_year;
	private $birth_mon;
	private $birth_day;

	private $first_race;
	private $second_race;
	private $third_race;
	private $fourth_race;

	private $first_name;
	private $last_name;

	private $debug;
	private $skater_association;
	private $skater_id;



	private $skater_address;
	private $skater_city;
	private $skater_state;
	private $skater_zip;
	private $skater_email;
	private $skater_month;
	private $skater_day;
	private $skater_year;
	private $skater_sex;
	private $skater_mobile;
	private $skater_phone;

	private $renewal_month;
	private $renewal_day;
	private $renewal_year;
	private $renewal_amount;

	private $join_month;
	private $join_day;
	private $join_year;

	private $title_id;
	private $sort;

	private $sql;
	




	private $invalid;

	function __construct()
	{
		$this->invalid="deadbeefstinkysocks";
		$this->session_id = $this->invalid;
		$this->debug = $this->invalid;
		$this->first_name = $this->invalid;
		$this->last_name = $this->invalid;
		$this->skater_association = $this->invalid;
		$this->skater_id = $this->invalid;

		$this->skater_address = $this->invalid;
		$this->skater_city = $this->invalid;
		$this->skater_state = $this->invalid;
		$this->skater_zip = $this->invalid;
		$this->skater_email = $this->invalid;
		$this->skater_month = $this->invalid;
		$this->skater_day = $this->invalid;
		$this->skater_year = $this->invalid;
		$this->renewal_month = $this->invalid;
		$this->renewal_day = $this->invalid;
		$this->renewal_year = $this->invalid;
		$this->renewal_amount = $this->invalid;
		$this->join_month = $this->invalid;
		$this->join_day = $this->invalid;
		$this->join_year = $this->invalid;
		$this->skater_sex = $this->invalid;
		$this->skater_association = $this->invalid;

		$this->skater_phone = $this->invalid;
		$this->skater_mobile = $this->invalid;
		$this->sort = $this->invalid;


	#$keys = array_keys($_POST);
	#foreach ($keys as $vars) {
		#echo "$vars = $_POST[$vars]<br>";
	#}




		if ($_POST[eid] != NULL) {
			$this->user_id = $_POST[eid];
		} else if ($_GET[eid] != NULL) {
			$this->user_id = $_GET[eid];
		} else {
			$this->user_id = $invalid;
		}

		if ($_POST[RACE_ID] != NULL) {
			$this->race_id = $_POST[RACE_ID];
		} else if ($_GET[RACE_ID] != NULL) {
			$this->race_id = $_GET[RACE_ID];
		} else {
			$this->race_id = 5;
		}

		if ($_POST[DEBUG] != NULL) {
			$this->debug = 1;
		} else if ($_GET[DEBUG] != NULL) {
			$this->debug = 1;
		} else {
			$this->debug = 0;
		}

		if ($_POST[SORT] != NULL) {
			$this->sort = $_PORT[SORT];
		} else if ($_GET[SORT] != NULL) {
			$this->sort = $_GET[SORT];
		} 

		if ($_POST[FIRST_NAME] != NULL) {
			$this->first_name = $_POST[FIRST_NAME];
		} else if ($_GET[FIRST_NAME] != NULL) {
			$this->first_name = $_GET[FIRST_NAME];
		} else {
			$this->first_name = $invalid;
		}

		if ($_POST[LAST_NAME] != NULL) {
			$this->last_name = $_POST[LAST_NAME];
		} else if ($_GET[LAST_NAME] != NULL) {
			$this->last_name = $_GET[LAST_NAME];
		} else {
			$this->last_name = $invalid;
		}

		if ($_POST[TITLE_ID] != NULL) {
			$this->title_id = $_POST[TITLE_ID];
		} else if ($_GET[TITLE_ID] != NULL) {
			$this->title_id = $_GET[TITLE_ID];
		} else {
			$this->title_id = $invalid;
		}


		if ($_POST[DIVISION_ID] != NULL) {
			$this->division_id = $_POST[DIVISION_ID];
		} else if ($_GET[RACE_ID] != NULL) {
			$this->division_id = $_GET[DIVISION_ID];
		} else {
			$this->division_id = 0;
		}

		if ($_POST[BIRTH_YEAR] != NULL) {
			$this->birth_year = $_POST[BIRTH_YEAR];
		} else if ($_GET[BIRTH_YEAR] != NULL) {
			$this->birth_year = $_GET[BIRTH_YEAR];
		} else {
			$this->birth_year = 0;
		}

		if ($_POST[BIRTH_MON] != NULL) {
			$this->birth_mon = $_POST[BIRTH_MON];
		} else if ($_GET[BIRTH_MON] != NULL) {
			$this->birth_mon = $_GET[BIRTH_MON];
		} else {
			$this->birth_mon = 0;
		}

		if ($_POST[BIRTH_DAY] != NULL) {
			$this->birth_day = $_POST[BIRTH_DAY];
		} else if ($_GET[BIRTH_DAY] != NULL) {
			$this->birth_day = $_GET[BIRTH_DAY];
		} else {
			$this->birth_day = 0;
		}

		if ($_POST[first_race] != NULL) {
			$this->first_race = $_POST[first_race];

		} else if ($_GET[first_race] != NULL) {
			$this->first_race = $_GET[first_race];
		} else {
			$this->first_race = 0;
		}

		if ($_POST[second_race] != NULL) {
			$this->second_race = $_POST[second_race];

		} else if ($_GET[second_race] != NULL) {
			$this->second_race = $_GET[second_race];
		} else {
			$this->second_race = 0;
		}

		if ($_POST[third_race] != NULL) {
			$this->third_race = $_POST[third_race];

		} else if ($_GET[third_race] != NULL) {
			$this->third_race = $_GET[third_race];
		} else {
			$this->third_race = 0;
		}

		if ($_POST[fourth_race] != NULL) {
			$this->fourth_race = $_POST[fourth_race];

		} else if ($_GET[fourth_race] != NULL) {
			$this->fourth_race = $_GET[fourth_race];
		} else {
			$this->fourth_race = 0;
		}

		if ($_POST[SKATER_ASSOCIATION] != NULL) {
			$this->skater_association = $_POST[SKATER_ASSOCIATION];
		} else if ($_GET[SKATER_ASSOCIATION] != NULL) {
			$this->skater_association = $_GET[SKATER_ASSOCIATION];
		} else {
			$this->skater_association = $invalid;
		}

		if ($_POST[SKATER_ID] != NULL) {
			$this->skater_id = $_POST[SKATER_ID];
		} else if ($_GET[SKATER_ID] != NULL) {
			$this->skater_id = $_GET[SKATER_ID];
		} else {
			$this->skater_id = $invalid;
		}

		if ($_POST[SQL] != NULL) {
			$this->sql = $_POST[SQL];
		} else if ($_GET[SQL] != NULL) {
			$this->sql = $_GET[SQL];
		} else {
			$this->sql = $invalid;
		}


		if ($_POST[ADDRESS] != NULL) {
			$this->skater_address = $_POST[ADDRESS];
		} else if ($_GET[ADDRESS] != NULL) {
			$this->skater_address = $_GET[ADDRESS];
		} else {
			$this->skater_address = $invalid;
		}

		if ($_POST[CITY] != NULL) {
			$this->skater_city = $_POST[CITY];
		} else if ($_GET[CITY] != NULL) {
			$this->skater_city = $_GET[CITY];
		} else {
			$this->skater_city = $invalid;
		}

		if ($_POST[STATE] != NULL) {
			$this->skater_state = $_POST[STATE];
		} else if ($_GET[STATE] != NULL) {
			$this->skater_state = $_GET[STATE];
		} else {
			$this->skater_state = $invalid;
		}

		if ($_POST[ZIP] != NULL) {
			$this->skater_zip = $_POST[race_id];
		} else if ($_GET[ZIP] != NULL) {
			$this->skater_zip = $_GET[ZIP];
		} else {
			$this->skater_zip = $invalid;
		}

		if ($_POST[EMAIL] != NULL) {
			$this->skater_email = $_POST[EMAIL];
		} else if ($_GET[EMAIL] != NULL) {
			$this->skater_email = $_GET[EMAIL];
		} else {
			$this->skater_email = $invalid;
		}

		if ($_POST[SKATER_MONTH] != NULL) {
			$this->skater_month = $_POST[SKATER_MONTH];
		} else if ($_GET[SKATER_MONTH] != NULL) {
			$this->skater_month = $_GET[SKATER_MONTH];
		} else {
			$this->skater_month = $invalid;
		}

		if ($_POST[SKATER_DAY] != NULL) {
			$this->skater_day = $_POST[SKATER_DAY];
		} else if ($_GET[SKATER_DAY] != NULL) {
			$this->skater_day = $_GET[SKATER_DAY];
		} else {
			$this->skater_day = $invalid;
		}

		if ($_POST[SKATER_YEAR] != NULL) {
			$this->skater_year = $_POST[SKATER_YEAR];
		} else if ($_GET[SKATER_YEAR] != NULL) {
			$this->skater_year = $_GET[SKATER_YEAR];
		} else {
			$this->skater_year = $invalid;
		}

		if ($_POST[RENEWAL_MONTH] != NULL) {
			$this->renewal_month = $_POST[RENEWAL_MONTH];
		} else if ($_GET[RENEWAL_MONTH] != NULL) {
			$this->renewal_month = $_GET[RENEWAL_MONTH];
		} else {
			$this->renewal_month = $invalid;
		}

		if ($_POST[RENEWAL_DATE] != NULL) {
			$this->renewal_day = $_POST[RENEWAL_DATE];
		} else if ($_GET[RENEWAL_DATE] != NULL) {
			$this->renewal_day = $_GET[RENEWAL_DATE];
		} else {
			$this->renewal_day = $invalid;
		}

		if ($_POST[RENEWAL_YEAR] != NULL) {
			$this->renewal_year = $_POST[RENEWAL_YEAR];
		} else if ($_GET[RENEWAL_YEAR] != NULL) {
			$this->renewal_year = $_GET[RENEWAL_YEAR];
		} else {
			$this->renewal_year = $invalid;
		}

		if ($_POST[RENEWAL_AMOUNT] != NULL) {
			$this->renewal_amount = $_POST[RENEWAL_AMOUNT];
		} else if ($_GET[RENEWAL_AMOUNT] != NULL) {
			$this->renewal_amount = $_GET[RENEWAL_AMOUNT];
		} else {
			$this->renewal_amount = $invalid;
		}


		if ($_POST[JOIN_MONTH] != NULL) {
			$this->join_month = $_POST[JOIN_MONTH];
		} else if ($_GET[JOIN_MONTH] != NULL) {
			$this->join_month = $_GET[JOIN_MONTH];
		} else {
			$this->join_month = $invalid;
		}

		if ($_POST[JOIN_DAY] != NULL) {
			$this->join_day = $_POST[JOIN_DAY];
		} else if ($_GET[JOIN_DAY] != NULL) {
			$this->join_day = $_GET[JOIN_DAY];
		} else {
			$this->join_day = $invalid;
		}

		if ($_POST[JOIN_YEAR] != NULL) {
			$this->join_year = $_POST[JOIN_YEAR];
		} else if ($_GET[JOIN_YEAR] != NULL) {
			$this->join_year = $_GET[JOIN_YEAR];
		} else {
			$this->join_year = $invalid;
		}
		if ($_POST[SKATER_PHONE] != NULL) {
			$this->skater_phone = $_POST[SKATER_PHONE];
		} else if ($_GET[SKATER_PHONE] != NULL) {
			$this->skater_phone = $_GET[SKATER_PHONE];
		} else {
			$this->skater_phone = $invalid;
		}

		if ($_POST[SKATER_MOBILE] != NULL) {
			$this->skater_mobile = $_POST[SKATER_MOBILE];
		} else if ($_GET[SKATER_MOBILE] != NULL) {
			$this->skater_mobile = $_GET[SKATER_MOBILE];
		} else {
			$this->skater_mobile = $invalid;
		}


		if ($_POST[SKATER_SEX] != NULL) {
			$this->skater_sex = $_POST[SKATER_SEX];
		} else if ($_GET[SKATER_SEX] != NULL) {
			$this->skater_sex = $_GET[SKATER_SEX];
		} else {
			$this->skater_sex = $invalid;
		}

		if ($_POST[SKATER_ASSOCIATION] != NULL) {
			$this->skater_association = $_POST[SKATER_ASSOCIATION];
		} else if ($_GET[SKATER_ASSOCIATION] != NULL) {
			$this->skater_association = $_GET[SKATER_ASSOCIATION];
		} else {
			$this->skater_association = $invalid;
		}

		if ($_SERVER[HTTP_USER_AGENT] != NULL) {
			$this->user_agent = $_SERVER[HTTP_USER_AGENT];
		}

		if ($_SERVER[REMOTE_ADDR] != NULL) {
			$this->remote_addr = $_SERVER[REMOTE_ADDR];
		}






#	$keys = array_keys($_GET);
#	foreach ($keys as $var) {
#		echo "$var = $_GET[$var]<br>";
#	}



	}

	function insert_raceid()
	{
		echo "RACE_ID=$this->race_id";
	}

	function get_race_id()
	{
		return $this->race_id;
	}

	function get_raceid()
	{
		return  $this->race_id;
	}

	function get_sessionid() {return $this->session_id; }	

	function get_divisionid()
	{
		return  $this->division_id;
	}
	function get_division_id()
	{
		return  $this->division_id;
	}

	function get_skaterid()
	{		
		if ($this->skater_id != $this->invalid)
			return $this->skater_id;
		else
			return "";
	}	

	function get_sql()
	{		
		if ($this->sql != $this->invalid)
			return $this->sql;
		else
			return "";
	}	


	function get_birth_year()
	{
		return  $this->birth_year;
	}
	function get_birth_mon()
	{
		return  $this->birth_mon;
	}
	function get_birth_day()
	{
		return  $this->birth_day;
	}

	function get_first_race()
	{
		return  $this->first_race;
	}
	function get_second_race()
	{
		return  $this->second_race;
	}
	function get_third_race()
	{
		return  $this->third_race;
	}
	function get_fourth_race()
	{
		return  $this->fourth_race;
	}

	function get_skater_association()
	{		
		if ($this->skater_association != $this->invalid)
			return $this->skater_association;
		else
			return "";
	}	


	function add_userid_field()
	{
	}	

	function insert_css_file()
	{
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"networkistics.css\"/>";
		#$b = $this->get_browser();
		#echo "I got: $b<br>";
	}

	function get_debug() {	return $this->debug; }	
	function get_sort() {	return $this->sort; }	
	function get_firstname()
	{		
		if ($this->first_name != $this->invalid)
			return $this->first_name;
		else
			return "";
	}	

	function get_lastname()
	{		
		if ($this->last_name != $this->invalid)
			return $this->last_name;
		else
			return "";
	}	



	function get_skater_address()
	{		
		if ($this->skater_address != $this->invalid)
			return $this->skater_address;
		else
			return "";
	}	

	function get_skater_city()
	{		
		if ($this->skater_city != $this->invalid)
			return $this->skater_city;
		else
			return "";
	}	

	function get_skater_state()
	{		
		if ($this->skater_state != $this->invalid)
			return $this->skater_state;
		else
			return "";
	}	

	function get_skater_zip()
	{		
		if ($this->skater_zip != $this->invalid)
			return $this->skater_zip;
		else
			return "";
	}	


	function get_skater_email()
	{		
		if ($this->skater_email != $this->invalid)
			return $this->skater_email;
		else
			return "";
	}	

	function get_skater_month()
	{		
		if ($this->skater_month != $this->invalid)
			return $this->skater_month;
		else
			return "";
	}	

	function get_skater_day()
	{		
		if ($this->skater_day != $this->invalid)
			return $this->skater_day;
		else
			return "";
	}	

	function get_skater_year()
	{		
		if ($this->skater_year != $this->invalid)
			return $this->skater_year;
		else
			return "";
	}	

	function get_skater_sex()
	{		
		if ($this->skater_sex != $this->invalid)
			return $this->skater_sex;
		else
			return "";
	}	

	function get_titleid() {return $this->title_id; }	

	function get_mobile() { return $this->skater_mobile; }
	function get_phone() { return $this->skater_phone; }

	function get_renewal_month() { return $this->renewal_month; }
	function get_renewal_day() { return $this->renewal_day; }
	function get_renewal_year() { return $this->renewal_year; }
	function get_renewal_amount() { return $this->renewal_amount; }

	function get_join_month() { return $this->join_month; }
	function get_join_day() { return $this->join_day; }
	function get_join_year() { return $this->join_year; }

	function get_remote_addr()
	{
		return	$this->remote_addr;
	}

}


class DB
{

	private $host;
	private $user;
	private $pass;
	private $database;
	private $sqlstatement;
	private $conn;
	private $row;
	private $result;
	
	function __construct()
	{
		//print "<br>in DB constructor<br>";
		$this->host="localhost";
		$this->user="networki_ncsa";
		$this->pass="06ncsa17";
		$this->database="networki_ncsa";
		$this->sqlstatement="";
		
		$this->conn = mysql_connect($this->host, $this->user, $this->pass) or die ('Error connecting to mysql');
		mysql_select_db($this->database);
	}

	
	function __destruct()
	{
		//print "<br>in DB deconstructor<br>";
		//mysql_close($this->conn);
	}
	
	public function getsql()
	{
		return  $this->sqlstatement;
	}
	
	public function runsql($msg, $debug)
	{
		$this->sqlstatement = $msg;
		if ($debug){
			print "<br>$this->sqlstatement<br>";
		}
		$this->result = mysql_query($this->sqlstatement );
	}
	

	public function getrow()
	{
		$this->row = mysql_fetch_array($this->result,MYSQL_ASSOC);
		return $this->row;
	}

	public function getcurrentyear()
	{
		$this->sqlstatement = "select year(now()) as year from dual";
		$this->result = mysql_query($this->sqlstatement );
		$this->row = mysql_fetch_array($this->result,MYSQL_ASSOC);
		return $this->row[year];
	}

	public function getcurrentmonth()
	{
		$this->sqlstatement = "select month(now()) as month from dual";
		$this->result = mysql_query($this->sqlstatement );
		$this->row = mysql_fetch_array($this->result,MYSQL_ASSOC);
		return $this->row[month];
	}

	public function getcurrentdate()
	{
		$this->sqlstatement = "select day(now()) as d from dual";
		$this->result = mysql_query($this->sqlstatement );
		$this->row = mysql_fetch_array($this->result,MYSQL_ASSOC);
		return $this->row[d];
	}
		
	public function getnow()
	{
		$this->sqlstatement = "select now() as d from dual";
		$this->result = mysql_query($this->sqlstatement );
		$this->row = mysql_fetch_array($this->result,MYSQL_ASSOC);
		return $this->row[d];
	
	}

	public function get_racename($raceid)
	{
		$this->sqlstatement = "select race_name from
			races where race_id = $raceid";
		$this->result = mysql_query($this->sqlstatement );
		$this->row = mysql_fetch_array($this->result,MYSQL_ASSOC);
		return $this->row[race_name];
	}


	public function get_divisionname($divisionid)
	{
		$this->sqlstatement = "select division_name from
			divisions where division_id = $divisionid";
		$this->result = mysql_query($this->sqlstatement );
		$this->row = mysql_fetch_array($this->result,MYSQL_ASSOC);
		return $this->row[division_name];
	}

	public function display_division($id, $rid) {

		$sqlstatement = "select skater_first, skater_last, 
			skater_id 
           		from skaters 
	    		where skater_id in
				(select skater_id 
					from division_skaters
					where division_id = '$id')
	   		order by skater_last, skater_first";

		$result = mysql_query($sqlstatement);
		echo "<table>";
		while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
	  		$national = get_age_group($row[skater_id], $rid);
	   		echo "<tr><td>";
	   		echo "<td class=\"left\" width=200px>$row[skater_first] $row[skater_last]</td>";
	   		echo "<td>&nbsp;&nbsp</td>";
	   		echo "<td class=\"left\" width=100px>$national</td></tr>";
		}
		echo "</table>";

	}

	function	display_distances($id)
	{
	$sqlstatement = "select division_distance1, 
			division_distance2, division_distance3, 
			division_distance4
		from divisions where division_id = $id";

	#echo "$query<br>";
	$result = mysql_query($sqlstatement);
	while ( $row = mysql_fetch_array($result,MYSQL_ASSOC)){
	   echo "<table><tr>";
	   if ($row[division_distance1] != "0" && 
		$row[division_distance1] != "9999"){
	   	echo "<td><b>&nbsp;&nbsp;Race 1:</b> $row[division_distance1] meters</td> ";
	   }
	   if ($row[division_distance2] != "0" &&
		$row[division_distance2] != "9999"){
	   	echo "<td><b>&nbsp;&nbsp; Race 2:</b> $row[division_distance2] meters</td>";
	   }
	   if ($row[division_distance3] != "0" &&
		$row[division_distance3] != "9999"){
	   	echo "<td><b>&nbsp;&nbsp; Race 3:</b> $row[division_distance3] meters</td>";
	   }
	   if ($row[division_distance4] != "0" &&
		$row[division_distance4] != "9999"){
	   	echo "<td><b>&nbsp;&nbsp; Race 4:</b> $row[division_distance4] meters</td>";
	   }
	}
	}
	



}

function create_month_select($month)
{
$months = array(0, "Jan", "Feb", "Mar", "Apr", "May", "Jun", 
	"Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

	for ($x = 1; $x < 13; $x++) {
		if ($x == $month) {
			echo "<option value=\"$x\" selected>$months[$x]</option>";
		} else {
			echo "<option value=\"$x\" >$months[$x]</option>";
		}
	}
}
function create_date_select($d)
{
	for ($x = 1 ; $x < 32; $x++) {
		if ($x == $d) {
			print ("<option value=\"$x\" selected>$x</option>");
		} else {
			print ("<option value=\"$x\">$x</option>");
		}
	}
}

function create_year_select($yr)
{
	for ($x = 2008 ; $x < 2020; $x++) {
		if ($x == $yr) {
			print ("<option value=\"$x\" selected>$x</option>");
		} else {
			print ("<option value=\"$x\">$x</option>");
		}
	}
}


function create_birthyear_select($yr)
{
	for ($x = 1930 ; $x < 2020; $x++) {
		if ($x == $yr) {
			print ("<option value=\"$x\" selected>$x</option>");
		} else {
			print ("<option value=\"$x\">$x</option>");
		}
	}
}


function write_head_tag($vars){
	echo "<head>";
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\">";
	echo "<script language=\"JavaScript\">";
	echo "var time = null
	 ";
	echo "function move() { ";
	$session = $vars->get_sessionid();
	echo "window.location = 'Timeout.php?session_id=$session'";
	echo "}";
	echo "</script>";
	echo "</head>";
}

function write_body_tag($vars, $database) {
	echo "<body>";
}

//***************** fix raw - cleans up raw_table for incorrect distances and times 

###################################################
function get_raw_distance($division, $heat)
{
        $conn = mysql_connect(get_host(), get_user(), get_pass()) ;
        mysql_select_db(get_db());
	$column = "division_distance".$heat;
	$query = "select " . $column  . " as distance from divisions where division_id = $division";
        $s_result = mysql_query($query);
	$distance = null;
        while ( $row = mysql_fetch_array($s_result,MYSQL_ASSOC)){
		$distance = $row[distance];
	}
	return $distance;
}
###################################################


function fixraw_sub($heat) {
	$sql = "select raw_id, 
		divisions.division_id as did , 
		distance,
		heatnum
	from raw_results , divisions
	where distance is null
		and raw_results.division_id = divisions.division_id
		and heatnum = $heat
	order by divisions.division_id ";
	//echo "$sql<br>";
        $conn = mysql_connect(get_host(), get_user(), get_pass()) ;
        mysql_select_db(get_db());
        $results = mysql_query($sql);

        while ( $row = mysql_fetch_array($results,MYSQL_ASSOC)){
		$did = $row[did];
		$distance = get_raw_distance($did,$heat);
		$sql = "update raw_results 
			set distance=($distance) 
			where raw_id = $row[raw_id]";
		mysql_query($sql);
	}
}

function fix_raw()
{
	for ($x = 1; $x < 7; $x++){
		//echo "Fixing Heat $x<br>";
		fixraw_sub($x);
	}

	//echo "normalizing minutes<br>";
	$sql = "update raw_results set min=\"0\" where min=\"00\"";
	mysql_query($sql);
	//echo "normalizing seconds<br>";
	$sql = "update raw_results set sec=\"0\" where sec=\"00\"";
	mysql_query($sql);
	
	//echo "normalizing hundredths<br>";
	$sql = "update raw_results set hun=\"0\" where hun=\"00\"";
	mysql_query($sql);
}

	
?>

