
if ($) {
	$(document).ready (
		function() {

			$('input#CreateMember').click (
				function($e) {
					$e.preventDefault();
					var url = 'CreateSkater1.php?FIRST_NAME=' + 
					escape($('#FIRST_NAME').val()) + 
					'&LAST_NAME=' + escape($('#LAST_NAME').val()) +
					'&EMAIL=' + escape($('#SKATER_EMAIL').val()) +
					'&SKATER_MONTH=' + escape($('#SKATER_MONTH').val()) +
					'&SKATER_DAY=' + escape($('#SKATER_DAY').val()) +
					'&SKATER_YEAR=' + escape($('#SKATER_YEAR').val()) +

					'&SKATER_SEX=' + escape($('#SKATER_SEX').val()) +
					'&SKATER_ASSOCIATION=' + escape($('#ASSOCIATION').val()) +
					'&TITLE_ID='+ escape($('#TITLE_ID').val());
					//alert(url);
					$('#status').load( url);
				}
			);
			$('input#FIRST_NAME,#LAST_NAME').keyup (
				function($e) {
					$e.preventDefault();
					var url='CheckSkater.php?FIRST_NAME=' +
					escape($('#FIRST_NAME').val()) + 
					'&LAST_NAME=' + escape($('#LAST_NAME').val());
						
					//alert(url);
					$('#status').load( url);
				}
			);
			$('#status').text('Enter Name of Skater');
		}
	 );
}

