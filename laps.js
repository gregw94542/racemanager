
if ($) {
	$(document).ready (
		function() {
			$('p#test').text('');
			$('p#result').text('');
			$('#sqlform').submit (
				function($e) {
					$e.preventDefault();
					var url = 'laps1.php?' + "SQL=" +  encodeURI($('#SQL').val()) ; 
					$('#result').load( url);
					return true;
				}
			);
		}
	 );
}

