
var skaterdata = "wifoo";

var tmpExample = {

  
	validate: function(e, el){  

		console.log(minutes, seconds, ms);
		return true;//neuter submission
	},

	get_skaters: function(){
		var raceid = $('p#raceid').text();
		var times_to_analyze=$('#times_to_analyze').val();
		var years_to_analyze=$('#years_to_analyze').val();
		var self = this;
		
		var debugflag = false;
		if ($('#debugflag').is(':checked')){
			debugflag = true;
		}
		var skatersinraceurl = "divisionhelper1.php?RACEID=" + raceid + "&MODE=skaters_in_url&COUNT=" + times_to_analyze +
			"&YEARS=" + years_to_analyze +
			"&DEBUG=" + debugflag;
		var skatersContainer = $('#skatersinrace');
		
		var skatersindebug= "divisionhelper1.php?RACEID=" + raceid + "&MODE=skaters_in_debug&COUNT=" + times_to_analyze +
			"&YEARS=" + years_to_analyze +
			"&DEBUG=" + debugflag;
		
		
		$.when( $.getJSON(skatersinraceurl) )
			.done(function(data){		// done:  takes JSON string and calls this anonymous function with the parsed string as the first argument to that function
				self.skaterdata = data;
				//self.render_skater_data(data);
				self.updateSkatersInRace();
				skaterdata = data;
			})
			.fail(function(data){
				console.log('failed for some reason', data, arguments);		// arguments =~ argv/argc from the "c" world
			}
		);
			
		if (debugflag == true) {
			console.log(skatersindebug);
			$('div#results').load(skatersindebug);
			//code 
		}
		
	},
	

	
	change_check: function (sid, checkval){
		$.each(skaterdata, function (key, value){
			if (value.skater_id == sid) {
				value.checked = checkval;
			}
		});
	},
	
	enable_all: function() {
		$.each(skaterdata, function (key, value){
			value.checked = true;
		});		
	},
	
		
	disable_all: function() {
		$.each(skaterdata, function (key, value){
			value.checked = false;
		});		
	},
	
	toggle_check: function(sid){
		$.each(skaterdata, function (key, value){
			if (value.skater_id == sid) {
				if (value.checked == true) {
					value.checked= false;
				} else {
					value.checked = true;
				}
			}
		});
	},

	
	dump_skaterdata: function() {
		$.each(skaterdata, function (key, val){
			console.log(val.first_name
				    + " " + val.last_name
				    + " " + val.skater_id
				    + " " + val.score
				    + " " + val.division
				    + " " + val.checked  
				     );
		});
	},
	
	
	get_checked: function() {
		var count = 1;
		$('[check_id]').each( function () {
			var checkval = $(this).is(':checked');
			var skaterid = $(this).attr('check_id');
			
			tmpExample.change_check(skaterid, checkval);
			count++;
		})
		
	},
	
	clearColoredDiv: function(){
		var blue = $('#blue');
		var red = $('#red');
		var green = $('#green');
		blue.html("");
		green.html("");
		red.html("");
	},
	
	updateSkatersInRace: function(){
		var skatersContainer = $('#skatersinrace');
		var blue = $('#blue');
		var red = $('#red');
		var green = $('#green');
		skatersContainer.html("");
		skatersContainer.append("<p class=\"small\"> #times:(" + $('#times_to_analyze').val() + ")  #years:" + $('#years_to_analyze').val() + "<\p>");
	


		// this sorts the table by score
		var newdata = $(tmpExample.skaterdata).sort(function(a,b){return a.score-b.score});
		
		
		// iterate through table, display checked items in the appropriate div (red, green, blue)
		
		var redcount = 0;
		var greencount = 0;
		var bluecount = 0;
		var displaycount = 0;
        var tableTemplate = '<h1></h1><table border=0><tbody></tbody></table>';
        
        // build up a new reference element for all skaters
        // no need to redo this work for each iteration of the loop
        var rowTemplate = $(
            '<tr class="inrace">' +
                '<td class="skater_displaycount"></td>' +
                '<td class="skater_firstname"></td>' +
                '<td class="skater_lastname"></td>' +
                '<td class="skater_score"></td>' +
                '<td class="skater_division"></td>' +
            '</tr>');

        // set basic HTML for blue, green, red. Do this outside of the loop.
        // The linebreaks and whitespace here are just for readability, so these are equivalent to foo.html(abc).find('h1').html(defg);
        blue
            .html(tableTemplate)
            .find('h1')
                .html("Group 1(Jr B -> Up)");
        green
            .html(tableTemplate)
            .find('h1')
                .html("Group 2 (Midget -> Jr C)");
        red
            .html(tableTemplate)
            .find('h1')
                .html("Group 3 (Pony, PeeWee, Tiny Tot)");

        // this function gets called from inside the $.each() loop below, for each skater
        // key, val, and displaycount are passed in as arguments
        function makeSkaterRow(key, val, displaycount){
            
            // copy the reference element
            var new_skater_row = rowTemplate.clone();

            // populate the copy with all of this skater's data
            // note that this is all one big chain of method calls... no semicolons until line 79.
            new_skater_row.attr({
                    'data-id': val.skater_id,
                    'color_id': val.color,
                    'class': 'inrace'
                })
                .find('.skater_displaycount')
                    .html(displaycount)
                    .end()              // each end() steps out of the previous find() operation
                .find('.skater_firstname')
                    .html(val.first_name)
                    .attr({
                        'id': key
                    })
                    .end()
                .find('.skater_lastname')
                    .html(val.last_name)
                    .end()
                .find('.skater_score')
                    .html(val.score)
                    .end()
                .find('.skater_division')
                    .html(val.division)
                    .end();
            return new_skater_row;
        }
		$.each(newdata, function (key, val){
			if (val.checked == true) {
				
		                blue.show();
				green.show();
				red.show();
				
				// decide where to put the info
				var destination;
				if (val.color == "red"){
					destination = red;
					redcount++;
					displaycount = redcount;
				} else if (val.color == "blue"){
					destination = blue;
					bluecount++;
					displaycount = bluecount;
				} else {
					destination = green;
					greencount++;
					displaycount =greencount;
				}
				
				if (val.score == 100) {
					val.score = "n/a";
				}
				// call makeSkaterRow() - the function we defined just before this loop was started
				newSkaterRow = makeSkaterRow(key, val, displaycount);

				// put this row into the 
				destination.find('tbody').append(newSkaterRow);
			
			}
		});
		
		
		$('[color_id=red]').css("color","red");
		$('[color_id=green]').css("color","green");
		$('[color_id=blue]').css("color","blue");
		
		red.append("</tbody></table>");		
		green.append("</tbody></table>");		
		blue.append("</tbody></table>");
	},

	
	
  ready : function() {
      // cache references to these elements
      var hintbox_element = $('#hint');
      var textid_element = $('#textid');
      var self = this;
      
      var raceid = $('p#raceid').text();
      var times_to_analyze=$('#times_to_analyze').val();
      var pick_url = "divisionhelper1.php?RACEID=" + raceid + "&MODE=pick";
      var skatersinraceurl = "divisionhelper1.php?RACEID=" + raceid + "&MODE=skaters_in_race&COUNT=" + times_to_analyze;
      var resultsurl = "divisionhelper1.php?RACEID=" + raceid + "&MODE=results";
      

      $('p#raceid').hide();
      $('div#hat').load(pick_url);
      tmpExample.get_skaters();
      $('div#skatersinrace').html("<p>Skaters In Race</p>");
      $('div#results').load(resultsurl);
      
      //$('tbody').sortable();

      $('#btn').click(function(){
          hintbox_element.text("");
          textid_element.val('');
      });

      // binding these to the 'body' tag lets you add more rows to the table during runtime
      $('body')
	
	
	//  if a name is clicked
	.on('click','p', function(e){ 
		
		// find the id of the click element
		var id = $(this).parent().attr('id');
		var color = $('td[hat_id=' + id + ']').css("color");

		// change paragraph colors
		if (color == "rgb(255, 0, 0)"){
			$('td[hat_id=' + id + ']').css("color","black");
			$('input[hat_id=' + id + ']').removeAttr('checked');
		} else {
			$('td[hat_id=' + id + ']').css("color","red");
			$('input[hat_id=' + id + ']').attr('checked', true);
		}

		tmpExample.toggle_check(id);
		tmpExample.updateSkatersInRace();
	})
	
	// refresh...  go back, get all of the checked values and repaint bottom of screen
	.on('click','input#refresh', function(e){
		tmpExample.get_checked();
		tmpExample.updateSkatersInRace();
	})
	
	// enable all skaters... handle screen pretty-ness
	.on('click','input#checkall', function(e){
		$('input[hat_id]').attr('checked', true);
		$('td[hat_id]').css("color","red");
		tmpExample.enable_all();
		tmpExample.updateSkatersInRace();
	})
	
	// disable all skaters... handle screen pretty-ness
	.on('click','input#checknone', function(e){
		$('input[hat_id]').removeAttr('checked');
		$('td[hat_id]').css("color","black");
		tmpExample.disable_all();
		tmpExample.updateSkatersInRace();
	})
	
	// for scoring analysis, regenerate skater scored based on the screen settings
	.on('change','#times_to_analyze', function (e){
		$('div#skatersinrace').html("<p>Regenerating Scores...... please wait.. all selections will be deleted</p>");
		tmpExample.get_skaters();
		$('div#skatersinrace').html("<p>Skaters In Race</p>");
		tmpExample.disable_all();
		$('td[hat_id]').css("color","black");
		tmpExample.clearColoredDiv();
		
	})

	// for scoring analysis, regenerate skater scored based on the screen settings	
	.on('change','#years_to_analyze', function (e){
		$('div#skatersinrace').html("<p>Regenerating Scores...... please wait.. all selections will be deleted</p>");
		tmpExample.get_skaters();
		$('div#skatersinrace').html("<p>Skaters In Race</p>");
		$('td[hat_id]').css("color","black");
		tmpExample.disable_all();
		tmpExample.clearColoredDiv();
		
	})
  },
};


$(document).ready(function(){
	tmpExample.ready();
});

