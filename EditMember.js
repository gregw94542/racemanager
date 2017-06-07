
if ($) {
	$(document).ready (
		function() {

			$('button#mypassword').click (
				function($e) {	
					$e.preventDefault();
					var url = "ChangePassword2.php?" + 
						'new_password='+ escape($('#new_password').val()) +
						'&SKATER_ID='+ escape($('#SKATER_ID').val()) +
					alert(url);
					$('#status').load( url);
				}
			);


			$('button#renewal').click (
				function($e){
					$e.preventDefault();
				    var url = "ChangeRenewal.php"
						+ '?RENEWAL_MONTH='+  escape($('#RENEWAL_MONTH').val()) 
						+ '&RENEWAL_DATE=' +  escape($('#RENEWAL_DATE').val()) 
						+ '&RENEWAL_YEAR=' +  escape($('#RENEWAL_YEAR').val()) 
						+ '&RENEWAL_AMOUNT='+ escape($('#RENEWAL_AMOUNT').val())
						+ '&SKATER_ID='    +  escape($('#SKATER_ID').val()) 
						;
					alert(url);
					$('#status').load( url);
				}
			);

			$('input#EditMember').click (
				function($e) {
					$e.preventDefault();
					var url = 'EditMember1.php?FIRST_NAME=' + 
					escape($('#FIRST_NAME').val()) + 
					'&LAST_NAME=' + escape($('#LAST_NAME').val()) +
					'&ADDRESS=' + escape($('#SKATER_ADDRESS1').val()) +
					'&CITY=' + escape($('#SKATER_CITY').val()) +
					'&STATE=' + escape($('#SKATER_STATE').val()) +
					'&ZIP=' + escape($('#SKATER_ZIP').val()) +
					'&EMAIL=' + escape($('#SKATER_EMAIL').val()) +
					'&SKATER_MONTH=' + escape($('#SKATER_MONTH').val()) +
					'&SKATER_DAY=' + escape($('#SKATER_DAY').val()) +
					'&SKATER_YEAR=' + escape($('#SKATER_YEAR').val()) +

					'&JOIN_MONTH=' + escape($('#JOIN_MONTH').val()) +
					'&JOIN_DAY=' + escape($('#JOIN_DAY').val()) +
					'&JOIN_YEAR=' + escape($('#JOIN_YEAR').val()) +
					'&SKATER_PHONE=' + escape($('#SKATER_PHONE').val()) +
					'&SKATER_MOBILE=' + escape($('#SKATER_MOBILE').val()) +

					'&SKATER_SEX=' + escape($('#SKATER_SEX').val()) +
					'&SKATER_ASSOCIATION=' + escape($('#ASSOCIATION_ID').val()) +
					'&SKATER_ID='+ escape($('#SKATER_ID').val()) +
					'&TITLE_ID='+ escape($('#TITLE_ID').val());
					//alert(url);
					$('#status').load( url);
				}
			);
			$('#status').text('');
		}
	 );
}

