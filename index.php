<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Needs
		–––––––––––––––––––––––––––––––––––––––––––––––––– -->
		<meta charset="utf-8">
		<title>NYUSH: Room Reservation System</title>
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Mobile Specific Metas
		–––––––––––––––––––––––––––––––––––––––––––––––––– -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- FONTS
		–––––––––––––––––––––––––––––––––––––––––––––––––– -->
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
		<link href='http://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>

		<!-- CSS
		–––––––––––––––––––––––––––––––––––––––––––––––––– -->
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/custom.css">
		<link rel="stylesheet" href="datepicker/default.css">
		<link rel="stylesheet" href="datepicker/default.date.css">
		<link rel="stylesheet" href="datepicker/default.time.css">
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="timepicker/jquery.ui.timepicker.css">

		<!-- Scripts
		–––––––––––––––––––––––––––––––––––––––––––––––––– -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="https://common.olemiss.edu/_js/jquery.js"></script>
		<script src="datepicker/picker.js"></script>
		<script src="datepicker/picker.date.js"></script>
		<script src="datepicker/picker.time.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<script src="timepicker/jquery.ui.timepicker.js"></script>

	</head>
	
	<body>

		<!-- Navigation Bar -->

		<nav class="navbar navbar-default navbar-fixed-top">
  			<div class="container">
    			<div class="navbar-header">
      				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        			<span class="sr-only">Toggle navigation</span>
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>
        			<span class="icon-bar"></span>
      				</button>
      			<a class="navbar-brand" href="http://humansofnyush.com/reservation/index.php">NYUSH Room Reservation</a>
    		</div>
    		<div id="navbar" class="collapse navbar-collapse">
      			<ul class="nav navbar-nav">
        			<li class="active"><a href="http://humansofnyush.com/reservation/index.php">Reserve a Room</a></li>
        			<li><a href="#about">Check Existing Reservations</a></li>
        			<li><a href="#contact">Contact</a></li>
      			</ul>
      			<ul class="nav navbar-nav navbar-right">
        			<li><a href="#">Signup  <i class="fa fa-user-plus"></i></a></li>
        			<li><a href="#about">Login  <i class="fa fa-user"></i></a></li>
      			</ul>
    		</div>
  		</div>
 		</nav>
 		<div id="temppad"></div>
 		<!-- New Sign Up Form -->
      <form id="search_form" action="index.html" method="post">
      
        <fieldset>
        	<legend><span class="number">1</span>Your basic info</legend>
        	<label for="name">Name:</label>
        	<input type="text" id="name" name="user_name">

        	<label for="mail">NYU Email (@nyu.edu):</label>
           <input type="email" id="mail" name="user_email">
        </fieldset>

	    <fieldset>
	    	<legend><span class="number">2</span>Your reservation info</legend>
	    	<label for="rooms">Select Room</label>
	        <select id="rooms" name="byRoomType">
	          <optgroup label="Room Type">
	            <option value="Music Practice Space">Music Practice Space</option>
	            <option value="Conference Room">Conference Room</option>
	            <option value="Group Study Room">Group Study Room</option>
	          </optgroup>
	        </select>
<!-- 	        	<label>Request Length</label>
	          <input type="radio" id="30min" value="30min" name="session_length"><label for="30min" class="light">30 min</label>
	          <input type="radio" id="60min" value="60min" name="session_length"><label for="60min" class="light">60 min</label>
	          <input type="radio" id="90min" value="90min" name="session_length"><label for="60min" class="light">90 min</label> -->
	          	<div id="date_input_container">
					<label id = "date_input_label" for="date_input">Select Date (YYYY-MM-DD)</label>
					<input type="text" id="date_input" name="date_input" placeholder="YYYY-MM-DD" readOnly="readOnly"> 
					<div id="cal" style="display:none;"></div>
				</div>
				<div id="start_time_input_container">
                    <label for="start_time">Session Start Time (24HR)</label>
          			<input type="text" id="start_time" name="start_time" placeholder="HH:MM" readOnly="readOnly">
          			<div id="time1" style="display:none;"></div>
          		</div>
          		<div id="end_time_input_container">
                    <label for="end_time">Session End Time (24HR)</label>
          			<input type="text" id="end_time" name="end_time" placeholder="HH:MM" readOnly="readOnly">
          			<div id="time2" style="display:none;"></div>
          		</div>
	    </fieldset>
	            <button id="search" type="submit" style="cursor:pointer;">Check for Availability</button>

	</form>

	<div class="container">
		<form id="modify_search" action="index.html" method="post" style="display:none;">
			<fieldset>
			    <legend>Modify search</legend>
			    <label for="rooms">Select Room</label>
				<select id="rooms" name="byRoomType">
		          <optgroup label="Room Type">
		            <option value="Music Practice Space">Music Practice Space</option>
		            <option value="Conference Room">Conference Room</option>
		            <option value="Group Study Room">Group Study Room</option>
		          </optgroup>
		        </select>
<!-- 		        <label>Request Length</label>
				<input type="radio" id="30min" value="30min" name="session_length"><label for="30min" class="light">30 min</label>
				<input type="radio" id="60min" value="60min" name="session_length"><label for="60min" class="light">60 min</label>
				<input type="radio" id="90min" value="90min" name="session_length"><label for="60min" class="light">90 min</label> -->
				<label id = "date_input_label" for="date_input">Select Date (YYYY-MM-DD)</label>
				<input type="text" id="date_input" name="date_input" placeholder="YYYY-MM-DD"> 
				<label for="start_time">Session Start Time (24HR)</label>
				<input type="text" id="start_time" name="start_time" placeholder="HH:MM">
				<label for="end_time">Session End Time (24HR)</label>
				<input type="text" id="end_time" name="end_time" placeholder="HH:MM">
			</fieldset>
				<button id="search_again" type="submit">Check for Availability</button>
		</form>
		<div id="loading_container" style="display:none;">
			<div id="loading_text">Filtering results ...</div>
			<div id="loading_spinner_container"><img id="loading_spinner" src="box-loading.gif"></div>
		</div>
		<div class="my_update_panel"></div>
	</div>

	<div class='container'>
		<button id="testing_button" type="submit">Fetch results</button>
		<div id="testing">Test</div>
	</div>

	<script type="text/javascript">
	$(document).ready(function() {
		$('#testing_button').click(function() {
			var data = {url: 'https://www.dropbox.com/s/0d0ca7bu5gcvcy5/test-file.txt?dl=1'}
			setInterval(function() {
				$.ajax({
				url: 'dropbox_request.php',
				// async: false,
				type: 'POST',
				dataType: 'json',
				data: data,
				success : function (data) {
					var s = data.split('\n');
					append_data = "";
					$.each(s, function(idx, val){
						append_data += "<div>" + val + "</div>";
					});
					$('#testing').html(append_data);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr);
					}
				});
			}, 10000);
		});
	});
	</script>
	
	
				<!-- JQUERY TESTING FOR NEW SEARCH -->
				<script>
					// DATE PICKER
					var calShow = false;
					$('#cal').datepicker({
						inline: true,
						altField: '#date_input',
						dateFormat: 'yy-mm-dd',
						minDate: 0,
						onSelect: function(date) {
							$('#cal').toggle('blind');
							$('#date_input').animate({'margin-bottom':'20px'}, 400);
							calShow = false;
						}
					});
					$('#date_input').on('click', function(){
						if (calShow == true) {
							$('#cal').toggle('blind');
							$('#date_input').animate({'margin-bottom':'20px'}, 400);
							calShow = false;
						} else {
							$('#cal').toggle('blind');
							$('#date_input').animate({'margin-bottom':'0'}, 400);
							$('#cal').css('margin-bottom', '20px');
							calShow = true;
						}
					});

					$(document).mouseup(function (e) {
						// http://stackoverflow.com/questions/1403615/use-jquery-to-hide-a-div-when-the-user-clicks-outside-of-it
						var date_input_container = $('#date_input_container');
						if (!date_input_container.is(e.target) && date_input_container.has(e.target).length === 0 && calShow) {
							$('#cal').effect('blind');
							$('#date_input').animate({'margin-bottom':'20px'}, 400);
							calShow = false;
						}

					});

					$('#date_input').change(function(){
					    $('#cal').datepicker('setDate', $(this).val());
					});

					// TIME PICKER
					// START TIME PICKER (TIME1)
					var time1Show = false;
					$('#time1').timepicker({
						minutes: { interval: 15 },
						altField: '#start_time',
						defaultTime: '09:00',
						// onSelect: function(time) {
						// 	$('#time1').toggle('blind');
						// 	$('#start_time').animate({'margin-bottom': '20px'}, 400);
						// 	time1Show = false;
						// }
						onSelect: function(time) {
							$('#time2').timepicker('refresh');
							// $("#end_time").get().reset();

						}
					});

					$('#start_time').on('click', function() {
						if (time1Show == true) {
							$('#time1').toggle('blind');
							$('#start_time').animate({'margin-bottom':'20px'}, 400);
							time1Show = false;
						} else {
							$('#time1').toggle('blind');
							$('#start_time').animate({'margin-bottom':'0'}, 400);
							$('#time1').css('margin-bottom', '20px');
							time1Show = true;
						}
					});

					$(document).mouseup(function (e) {
						// http://stackoverflow.com/questions/1403615/use-jquery-to-hide-a-div-when-the-user-clicks-outside-of-it
						var start_time_input_container = $('#start_time_input_container');
						if (!start_time_input_container.is(e.target) && start_time_input_container.has(e.target).length === 0 && time1Show) {
							$('#time1').effect('blind');
							$('#start_time').animate({'margin-bottom':'20px'}, 400);
							time1Show = false;
						}

					});

					$('#rooms').change(function() {
						alert('test');
						$( '#time2' ).timepicker( 'refresh' );
					});

					// END TIME PICKER (TIME2)
					var time2Show = false;
					$('#time2').timepicker({
						   minutes: { interval: 15 },

						altField: '#end_time',
						defaultTime: '09:00',
						// showPeriod: true,
						onHourShow: OnHourShowCallback,
						onMinuteShow: OnMinuteShowCallback
						// onSelect: function(time) {
						// 	$('#time1').toggle('blind');
						// 	$('#start_time').animate({'margin-bottom': '20px'}, 400);
						// 	time1Show = false;
						// }
					});

					function OnHourShowCallback(hour) {

						if ($("#rooms :selected").text() === "Music Practice Space") {
							var startHour = $('#time1').timepicker('getHour');
					    	var startMinute = $('#time1').timepicker('getMinute');
							if ((hour > startHour) || (hour < startHour)) {
					        	return false; // not valid
					    	}
						}
					    return true; // valid
					}
					function OnMinuteShowCallback(hour, minute) {
					    // if ((hour == 20) && (minute >= 30)) { return false; } // not valid
					    // if ((hour == 6) && (minute < 30)) { return false; }   // not valid
					    var startMinute = $('#time1').timepicker('getMinute');
					    if ((hour == $(this).timepicker('getHour'))) {
					    	if (minute <= startMinute) {
					    		return false;
					    	}
					    }
					    return true;  // valid
					}

					$('#end_time').on('click', function() {
						if (time2Show == true) {
							$('#time2').toggle('blind');
							$('#end_time').animate({'margin-bottom':'20px'}, 400);
							time2Show = false;
						} else {
							$('#time2').toggle('blind');
							$('#end_time').animate({'margin-bottom':'0'}, 400);
							$('#time2').css('margin-bottom', '20px');
							time2Show = true;
						}
					});

					$(document).mouseup(function (e) {
						// http://stackoverflow.com/questions/1403615/use-jquery-to-hide-a-div-when-the-user-clicks-outside-of-it
						var end_time_input_container = $('#end_time_input_container');
						if (!end_time_input_container.is(e.target) && end_time_input_container.has(e.target).length === 0 && time2Show) {
							$('#time2').effect('blind');
							$('#end_time').animate({'margin-bottom':'20px'}, 400);
							time2Show = false;
						}

					});

					// SEARCH -- SEND TO REQUEST.PHP VIA AJAX

					$("#search, #search_again").click(function(){
						// alert('test');
						// var post_form_data = $('#search_form').serialize();

						if ($('#modify_search').css('display') == 'none') {
							var post_form_data = $('#search_form').serialize();
							var form_data = {date: $('#search_form input[name="date_input"').val(), start_time: $('#search_form input[name="start_time"').val(), end_time: $('#search_form input[name="end_time"').val()};
							// alert('test');
							$('#loading_container').slideDown();
							// alert('test2');
							$( "#search_form" ).toggle( "blind", {}, 750);
							// alert('test3');
						} else {
							$('#loading_container').slideDown();
							$('#loading_container').animate({'margin-bottom':'20px', 'margin-top':'20px'}, 300);
							var post_form_data = $('#modify_search').serialize();
							var form_data = {date: $('#modify_search input[name="date_input"').val(), start_time: $('#modify_search input[name="start_time"').val(), end_time: $('#modify_search input[name="end_time"').val()};
						}

						function parseReserveURLDate(d, t) {
							return d + 'T' + t + ':00%2B08:00'
						}
						// alert(post_data);
						$.ajax({
						    url: 'request.php',
						    type: 'POST',
						    data: post_form_data,
						    dataType: 'json',
						    success: function(data) {
						    	var trHTML = '<div class="table-responsive"><table class="table"><thead><tr><th>Room #</th><th>Room Type</th><th>Date</th><th>Start Time</th><th>End Time</th><th>Reserve</th></tr><thead><tbody>'; // begin table
						        $.each(data, function(idx, v) {
						        	var reserve_link = '<a href="form.php?room=' + v[0] + '&start=' + parseReserveURLDate(form_data.date, form_data.start_time) + '&end=' + parseReserveURLDate(form_data.date, form_data.end_time) + '">Reserve</a>' ;
						        	trHTML += '<tr><td>' + v[0] + '</td><td>' + v[1] + '</td><td>' + form_data.date + '</td><td>' + form_data.start_time + '</td><td>' + form_data.end_time + '</td><td>' + reserve_link + '</td></tr>';
						        });
						        trHTML += '</tbody></table></div>';
						        if (data.length === 0) {
						        	$('#modify_search').slideDown('slow');
						        	$('.my_update_panel').hide().html('<div id="no_results">No rooms available for specified time. Please search again.</div>').slideDown('slow');
						        	$('#loading_container').hide();
						        } else {
							        $('#modify_search').slideDown('slow');
							        $('.my_update_panel').hide().html(trHTML).slideDown('slow');
							//Moved the hide event so it waits to run until the prior event completes
							//It hide the spinner immediately, without waiting, until I moved it here
							        $('#loading_container').hide();
						        }
						    },
						    error: function() {
						        alert("Something went wrong!");
						    }
						});
						return false;
					});
				</script>
		<!-- End Document
		–––––––––––––––––––––––––––––––––––––––––––––––––– -->
	</body>
</html>