
if ($) {
	$(document).ready (
		function() {
			$('p#test').text('');
			$('p#result').text('');
			$('#sqlform').submit (
				function($e) {
					$e.preventDefault();
					//var url = 'Sql1.php?' + "SQL=" +  encodeURI($('#SQL').val()) ; 
					var url = 'Sql1.php?' + "SQL=" +  escape($('#SQL').val()) ; 
					alert ($('#SQL').val + url);
					$('#result').load( url);

					return true;
				}
			);
		}
	 );
}

