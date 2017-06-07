
if ($) {
	$(document).ready (
		function() {
			$('p#test').text('');
			//$('input#membersubmit').keyup (
			$('input').keyup (
				function($e) {
					$e.preventDefault();
					var url = 'ViewMember1.php?FIRST_NAME=' + $('input#FIRST_NAME').val() + 
					'&LAST_NAME=' + $('#LAST_NAME').val() +
					'&SKATER_ASSOCIATION=' + $('#SKATER_ASSOCIATION').val() + 
					'&eid='+ $('#EID').val() +
					'&session_id=' + $('#SESSION_ID').val()
				; 
					//alert(url);
					$('#result').load( url);
				}
			);
		}
	 );
}

