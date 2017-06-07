
<?php
function adjust_times ($mode, $min, $sec, $hun)
{
//  test cases
//    min     sec     hun        results
//   1       0       0           1:00:00 
//   2       0      79           2:00:99    (no carry)
//   2       0      80           2:01:00    (carry)
//   2       0      99           2:01:19    (carry)
//   2       59     00           2:59:00    (no carry)
//   2       59     79           2:59:99    (no carry)
//   2       59     80           3:00:00    (carry, hun, seconds, minutes)
//   2       59     99           3:00:19    (carry, hun, seconds, minutes )
    



    // if USS mode, then make adjustment, otherwise, don't muck with the numbers
    if ($mode == "USS") {
	if (($hun || $sec || $min) ){
	    $hun += 20;
	    
	    // if the hundred field is less than 20, than a carry occured
	    #if ($hun > 100){
	    if ($hun >= 100){
		$hun=$hun-100;
		$sec++;                 // hundredths math forced a carry
		if ($sec > 59) {        // check for the hundredth's carry to force the seconds to carry to minutes
		    $sec = 0;
		    $min++;           
		}       
	    }
	}
    }

        
    // grrrr... gene, the engineer in me knows that the hundreth (.01) value is a bullshit value.
	printf ("<td class=\"info_time\">%d:%02d:%02d</td>", $min, $sec, $hun);

}
?>

