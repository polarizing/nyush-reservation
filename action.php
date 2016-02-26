<?php
	/********************************************
	GOOGLE CALENDAR API
		Authenticates Google Calendar API 
		DO NOT CHANGE VALUES IN THIS SECTION
	********************************************/
	require_once (__DIR__.'/src/Google/autoload.php');
	session_start();	 	
	
	/************************************************	
	The following 3 values an be found in the setting	
	for the application you created on Google 	 	
	Developers console. 
	The Key file should be placed in a location	 
	that is not accessible from the web. outside of 
	web root.	 

	In order to access your GA account you must	
	Add the Email address as a user at the 	
	ACCOUNT Level in the GA admin. 	 	
	************************************************/
	
	$client_id = '626774228193-j4dgsgl6lq1n8grukec71ded3atodcva.apps.googleusercontent.com';
	$Email_address = '626774228193-j4dgsgl6lq1n8grukec71ded3atodcva@developer.gserviceaccount.com';	 
	$key_file_location = (__DIR__.'/MyProject-d2cbe7b38c15.p12');	 	
	
	$client = new Google_Client();	 	
	$client->setApplicationName("Client_Library_Examples");
	$key = file_get_contents($key_file_location);	 

	// separate additional scopes with a comma	 
	$scopes ="https://www.googleapis.com/auth/calendar"; 	
	$cred = new Google_Auth_AssertionCredentials(	 
		$Email_address,	 	 
		array($scopes),
		$key	 	 
		);	 	
	$client->setAssertionCredentials($cred);
	
	if($client->getAuth()->isAccessTokenExpired()) {	 	
		$client->getAuth()->refreshTokenWithAssertion($cred);	 	
	}	
	 	
	$service = new Google_Service_Calendar($client);
	
	/*************************************************
	READS AND PARSES JSON CONFIG FILE
		GETS CALENDAR IDS, ROOM IDS, ROOM TYPES
		STORES IN $allCalID, $allRoomID, $allRoomType
	**************************************************/
	$string = file_get_contents(__DIR__.'/config.json');	// gets JSON contents
	$config = json_decode($string, true); 					// decodes and parses JSON into array
	$totalRooms = count($config);							
	$allCalID = array();
	$allRoomID = array();
	$allRoomType = array();
	for ($x = 0; $x < $totalRooms; $x++) {
		$allCalID[] = $config[$x]["calendar_id"];			// stores all calendar IDS in $allCalID
		$allRoomID[] = $config[$x]["room_id"];				// stores all room IDS in $allRoomID
		$allRoomType[] = $config[$x]["type"];				// stores all room types in $allRoomType
	}
	// gets unique room types, note using only array_unique preserves array keys
	$uniqueRoomType = array_values(array_unique($allRoomType));
?>
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

		<!-- FONT
		–––––––––––––––––––––––––––––––––––––––––––––––––– -->
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
		
		<!-- CSS
		–––––––––––––––––––––––––––––––––––––––––––––––––– -->
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/custom.css">
		<link rel="stylesheet" href="datepicker/default.css">
		<link rel="stylesheet" href="datepicker/default.date.css">
		<link rel="stylesheet" href="datepicker/default.time.css">

		<!-- Scripts
		–––––––––––––––––––––––––––––––––––––––––––––––––– -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="https://common.olemiss.edu/_js/jquery.js"></script>
		<script src="datepicker/picker.js"></script>
		<script src="datepicker/picker.date.js"></script>
		<script src="datepicker/picker.time.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

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

		<!-- Primary Page Layout
		–––––––––––––––––––––––––––––––––––––––––––––––––– -->
		<div class="container">
			<div class="starter-template">
				<h1>NYUSH Room Reservation System</h1>
				<p class="lead">Book study rooms, music practice rooms, and conference rooms!</p>

					<img id="loading_spinner" src="loading-spinner.gif">
					<div class="my_update_panel"></div>

				<script>
						$('#loading_spinner').show();
						var post_data1 = "my_variable=test";
						var post_data = {status: 'status1', name: 'name1'};
						$.ajax({
						    url: 'request.php',
						    type: 'POST',
						    data: post_data,
						    dataType: 'html',
						    success: function(data) {
						        $('.my_update_panel').html(data);
						//Moved the hide event so it waits to run until the prior event completes
						//It hide the spinner immediately, without waiting, until I moved it here
						        $('#loading_spinner').hide();
						    },
						    error: function() {
						        alert("Something went wrong!");
						    }
						});
					</script>

				<?php
	// // Get all POST variables
	// $date1 = htmlspecialchars($_POST['date']);
	// $start2 = htmlspecialchars($_POST['start']);
	// $end3 = htmlspecialchars($_POST['end']);
	// $duration = htmlspecialchars($_POST['duration']);

	// $selectRoom = htmlspecialchars($_POST['byRoomType']);

	// $date = htmlspecialchars($_POST['date_input']);
	// $start = htmlspecialchars($_POST['start_time']);
	// $end = htmlspecialchars($_POST['end_time']);

	// echo $date, $start, $end;


	// // CONVERT TO RFC3339 TIME FORMAT -- YYYY-MM-DDT00:00:00+08:00
	// function convertDateToRFC($inputDate, $inputTime) {
	// 	return $inputDate."T".$inputTime.":00+08:00";
	// }

	// function convertDateToEncodedRFC($inputDate, $inputTime) {
	// 	return $inputDate."T".$inputTime.":00%2B08:00";
	// }

	// print "<div>$datepicker</div>";
	// print "<div>$startTimePicker</div>";
	// print "<div>$endTimePicker</div>";
	// // Start Google Calendar Service
	// $service = new Google_Service_Calendar($client);
	
	// // Get all indexes of rooms in JSON file matching RoomType from POST variable 'byRoomType' and store in array $key
	// $key = array();
	// foreach ($allRoomType as $index=>$roomType) {
	// 	if ($roomType == $selectRoom) {
	// 		$key[] = $index;
	// 	}
	// }
	// print "<table class=\"responsive\">";
	// 	print "<thead>";
	// 		print "<tr>";
	// 			print "<th>Room #</th>";
	// 		 	print "<th>Room Type</th>";
	// 		 	print "<th>Date Available</th>";
	// 		 	print "<th>Time Available</th>";
	// 		 	print "<th>Reserve</th>";
	// 		 print "</tr>";
	// 	print "</thead>";
	// 	print "<tbody>";
	// try {
	// 	for ($x = 0; $x < count($key); $x++) {
	// 		$getCalID = $allCalID[$key[$x]];
	// 		$getRoomID = $allRoomID[$key[$x]];
	// 		$getRoomType = $allRoomType[$key[$x]];
	// 		$getRoomDescription = $allRoomDescription[$key[$x]];
	// 		$optParams = array(
	// 			'maxResults' => 10,
	// 			'orderBy' => 'startTime',
	// 			'singleEvents' => TRUE,
	// 			'timeMin' => convertDateToRFC($date, $start), // change to variable
	// 			'timeMax' => convertDateToRFC($date, $end), // change to variable
	// 			'q' => 'Reserved'
	// 		);

	// 		$results = $service->events->listEvents($getCalID, $optParams);
	// 		if (count($results->getItems()) == 0) {
	// 			print "<tr>";
	// 			print "<td>$getRoomID</td>";
	// 			print "<td>$getRoomType</td>";
	// 			print "<td>$date</td>"; // change to variable
	// 			print "<td>$start - $end</td>"; // change to variable
	// 			print "<td><a href=\"form.php?room=$getRoomID&start=".convertDateToEncodedRFC($date, $start)."&end=".convertDateToEncodedRFC($date, $end)."\">Reserve</a></td>"; // change to variable *note encode of +
	// 			print "</tr>";
	// 		}

	// 	}
	// } catch (Google_Service_Exception $e) {
	// 	print "<div>Invalid input. Please try again.</div>";
	// }
		
	// 	print "</tbody>";
	// print "</table>";
	// //YYYY-MM-DDT00:00:00+08:00
?>
			</div>
		</div>

	</body>
</html>