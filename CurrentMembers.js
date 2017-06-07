
if ($) {
	$(document).ready (
		function() {
			$('p#test').text('');
			$('#target').submit( function($e) {
					$e.preventDefault();
					var url = 'CurrentMembers2.php?'+
					'&SORT='+$('#SORT').val();

					//alert(url);
					$('#result').load( url);
				}
			);
		}
	 );
}

