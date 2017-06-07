
<hr>
<h3>Race Manager</h3>
<?php
	$raceid = $vars->get_race_id();
	$racename=$database->get_racename($raceid);
	echo "$racename";
?>
<hr>

<br>
<br>
 <?php
 echo "<li class=\"sidemenu\"><a href=\"racemanager.php?";
 $vars->insert_raceid();
  echo "\">Home</a>";

 echo "<li class=\"sidemenu\"><a href=\"changerace.php?";
 $vars->insert_raceid();
  echo "\">Change Race</a>";

# echo "<li class=\"sidemenu\"><a href=\"createdivision.php?";
# $vars->insert_raceid();
#  echo "\">Division Editor</a>";

 echo "<li class=\"sidemenu\"><a href=\"printhelmetnumbers.php?";
 $vars->insert_raceid();
  echo "\">list of helmet #'s</a>";

 echo "<li class=\"sidemenu\"><a href=\"GenerateRace.php?";
 $vars->insert_raceid();
  echo "\">heat cards</a>";

 //echo "<li class=\"sidemenu\"><a href=\"ScribeCards.php?";
 //$vars->insert_raceid();
 // echo "\">Cards for Scribe</a>";

 echo "<li class=\"sidemenu\"><a href=\"GenerateResults.php?";
 $vars->insert_raceid();
 echo "&resultmode=NONE";
  echo "\">Generate Results</a>";

 echo "<li class=\"sidemenu\"><a href=\"GenerateResultsPR.php?";
 $vars->insert_raceid();
  echo "\">Generate PR Results</a>";
  
   echo "<li class=\"sidemenu\"><a href=\"GenerateResults.php?";
 $vars->insert_raceid();
echo "&resultmode=USS";
  echo "\">Generate USS Results</a>";

 echo "<li class=\"sidemenu\"><a href=\"GenerateCertificates.php?";
 $vars->insert_raceid();
  echo "\">Generate Certificates</a>";

 #echo "<li class=\"sidemenu\"><a href=\"ftp://ncsa@ftp.networkistics.com/Certificate_Template.pdf\">";
  #echo "Certificate Template</a>";

 echo "<li class=\"sidemenu\"><a href=\"GenerateResultsForLabelmaker.php?";
 $vars->insert_raceid();
  echo "\">Labelmaker Results</a>";

# echo "<li class=\"sidemenu\"><a href=\"laps.php?";
# $vars->insert_raceid();
#  echo "\">PR</a>";


 echo "<li class=\"sidemenu\"><a href=\"ScheduleOfEvents1.php?";
 $vars->insert_raceid();
  echo "\">Schedule of Events</a>";
 echo "<li class=\"sidemenu\"><a href=\"Checklist.php?";
 $vars->insert_raceid();
  echo "\">Checklist</a>";
   echo "<li class=\"sidemenu\"><a href=\"JobDescription.php?";
 $vars->insert_raceid();
  echo "\">Race Day Job Descriptions</a>";
 echo "<li class=\"sidemenu\"><a href=\"TimingSlip.php?";
 $vars->insert_raceid();
  echo "\">Timing Slips</a>";
 echo "<li class=\"sidemenu\"><a href=\"GenerateBlank.php?";
 $vars->insert_raceid();
  echo "\">Blank Heat Cards</a>";
	
  echo "<hr>";
 echo "<li class=\"sidemenu\"><a href=\"ViewMember.php?";
 $vars->insert_raceid();
  echo "\">Edit/View Member</a>";
 echo "<li class=\"sidemenu\"><a href=\"CreateSkater.php?";
 $vars->insert_raceid();
  echo "\">Create Member</a>";
 echo "<li class=\"sidemenu\"><a href=\"CurrentMembers1.php?";
 $vars->insert_raceid();
  echo "\">Current Members<a/>";

 echo "<li class=\"sidemenu\"><a href=\"One%20Day%20US%20Speedskating%20Membership.pdf\">";
  echo "One Day USS Membership</a>";


 echo "<li class=\"sidemenu\"><a href=\"Membercards.php?";
 $vars->insert_raceid();
  echo "\">Print Current Membership Cards </a>";


 echo "<li class=\"sidemenu\"><a href=\"RacerEmail.php?";
 $vars->insert_raceid();
  echo "\">Racer Email </a>";

 echo "<li class=\"sidemenu\"><a href=\"NcsaEmail.php?";
 $vars->insert_raceid();
  echo "\">Ncsa Email </a>";


 echo "<li class=\"sidemenu\"><a href=\"CurrentMembersForWeb.php?";
 $vars->insert_raceid();
  echo "\">Web Members  </a>";

 echo "<li class=\"sidemenu\"><a href=\"ExpiredMembers.php?";
 $vars->insert_raceid();
  echo "\">Expired Members</a>";

 #echo "<li class=\"sidemenu\"><a href=\"SyncMemberRenewal.php?";
 #$vars->insert_raceid();
  #echo "\">Sync Members Renewal Dates With USS</a>";
 echo "<li class=\"sidemenu\"><a href=\"timerdisplay.php?";
 $vars->insert_raceid();
  echo "\">Display TImer Results</a>";

 echo "<li class=\"sidemenu\"><a href=\"DistanceCalc.php?";
 $vars->insert_raceid();
  echo "\">Video Time Calc</a>";
#
 echo "<li class=\"sidemenu\"><a href=\"Sql.php?";
 $vars->insert_raceid();
  echo "\">SQL Worksheet </a>";

 echo "<li class=\"sidemenu\"><a href=\"fixraw.php?";
 $vars->insert_raceid();
  echo "\">repair raw results </a>";
  
   echo "<li class=\"sidemenu\"><a href=\"divisionhelper.php?"; 
 $vars->insert_raceid();
  echo "\">Division Helper</a>";
  
?>
<br><br>
</div>
