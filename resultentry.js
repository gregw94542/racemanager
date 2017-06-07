
  

function hintbox (widget, msg) {
    widget.text(msg);
  };
 

var tmpExample = {
  
	validate: function(e, el){
		var minutes = $(el).find('.min'),
			seconds = $(el).find('.sec'),
			ms = $(el).find('.hun');
		$(minutes).each(function(){
			var hintbox;
			
			if ($(this).val() >= 60){
				hintbox = $(this)
					.parents('tr')
						.first()
							.find('.hintbox')
							.text('too high');
			}
			console.log($(this).val());
		});

		//console.log(minutes, seconds, ms);
		return true;//neuter submission
	},
  ready : function() {
      // cache references to these elements
      var hintbox_element = $('#hint');
      var textid_element = $('#textid');
      var self = this;
      $('p').text('');
      //$("input#heat_submit").attr("disabled",true);   /* ???? future grief */
      $('#btn').click(function(){
          hintbox_element.text("");
          textid_element.val('');
      });

      // binding these to the 'body' tag lets you add more rows to the table during runtime
      $('body')
        .on('keyup', '#textid', function(e){
          var s = 'Current Value: ' + textid_element.val() + String.fromCharCode(e.which);
          hintbox_element.text(s);
        })
        
	.on('submit', '.input_times_form', function(e){
                //alert("got submit");
		var validated = self.validate(e, e.target);
		if(validated){
			// submit form	
		}
		else{
			e.preventDefault();
		}
	})
        
        // insert client side validation here
 /* 
        .on('click', '#heat_submit', function(e){
          var allInputs = $(this).find(":input#min.min");
          var msg = "";
	$(this).find('.min')
          .each(function(i) {
            msg = msg + "-" + $(this).val();
            console.log(msg);
          });
          console.log(msg);
         alert(msg);
        })
  */      
/*
	.on('submit', '.input_times_form', function(e){
		var passed_validation = false;
		var minutes, seconds, milliseconds;
		e.preventDefault();
//var minutesForThisForm = $(this).find('.min');
		$(this).find('.min').each(function(el){
			var el = $(this);
			el.val(parseInt(el.val()));
			//var value = $(this).val();
			
		});

		if(passed_validation){
			this.submit();
		} 

	})
*/
        .on('keyup', 'td.time', function(e){

          // the "this" keyword in a callback refers to the element that triggered the callback. So here, "this" refers to each <td> in the table.

          // need to go up to the parent, then back down to the sibling <td>, because the .hintbox for this row is in a different cell.
          var my_hintbox = $(this).parent().find('.hintbox');

          // for any keyup event on a <td>, $(this).find() looks for the relevant inputs within that <td>. Capture their values and assemble an output string.
          var my_sec = $(this).find('.sec').first().val();
          var my_min = $(this).find('.min').first().val();
          var my_hun = $(this).find('.hun').first().val();
          var err_field = "";
          var badentry = false;
          
          


          
         
          // check minute field,
         
          my_min = $.trim(my_min);
          if (my_min.length) {
            if (isNaN(my_min)) { 
              badentry = true;
              err_field = err_field + "[min:not number]";
            }

            if (isNaN(my_min) == false) {
              if (my_min < 0 || my_min > 59) {
                err_field = err_field + "[min:range]";
                badentry = true;
              }
              if (my_min.indexOf("+") != -1 || my_min.indexOf(".") != -1) {
                badentry = true;
                err_field = err_field + " [min:illegal char]";
              }
            }
          }
          
          // check seconds field for
          my_sec = $.trim(my_sec);
          if (isNaN(my_sec)) {
              err_field = err_field + "[sec:not number]";
               badentry = true;
          } else {
            if (my_sec < 0 || my_sec > 59) {
                err_field = err_field + "[sec:range]";
               badentry = true;
            }
            if (my_sec.length < 2) {
                badentry = true;
                err_field = err_field + "[sec:to few digits]";
            }
              if (my_sec.indexOf("+") != -1 || my_sec.indexOf(".") != -1) {
                badentry = true;
                err_field = err_field + "[sec:illegal char]";
            }
          }
            
          // check second field
          my_hun = $.trim(my_hun);
          if (isNaN(my_hun)) {
              err_field = err_field + "[hun:not number]";
               badentry = true;
          }
          // check for short hundredth's field
          if (my_hun.length < 2) {
                badentry = true;
                err_field = err_field + " [hun:to few digits]";
          }
          if (my_hun.indexOf("+") != -1 || my_hun.indexOf(".") != -1) {              
              badentry = true;
              err_field = err_field + " [hun:illegal char]";
          }
          
          // then write that string to the hintbox for this row.
          var s = my_min + ":" + my_sec + "." + my_hun;          
          if (err_field.length) { 

            s = s + " " + err_field ;
          } else {
            s = ""
          }
          
          //set the submit button accordingly
            $(this).parents("form").find('[type="submit"]').attr("disabled",badentry);
            if (badentry == true) {
              my_hintbox.css("color","red");

            } else {
              my_hintbox.css("color","green");

            }
            my_hintbox.text(s);

        });
  },
};


$(document).ready(function(){
	tmpExample.ready();
});

