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
		<link href='//fonts.googleapis.com/css?family=Raleway:400,300,600' rel='stylesheet' type='text/css'>

		<!-- CSS
		–––––––––––––––––––––––––––––––––––––––––––––––––– -->
		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/skeleton.css">
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
		
	</head>

	<body>
	<div class="container">
	<?php

	$room = $_GET["room"];
	$start = $_GET["start"];
	$end = $_GET["end"];

	$string = file_get_contents(__DIR__.'/config.json');
	$config = json_decode($string, true);
	$totalRooms = count($config);

	for ($x = 0; $x < $totalRooms; $x++) {
    	if($config[$x]["room_id"] == $room){
			$event = new Google_Service_Calendar_Event(array(
			'summary' => 'Reserved',
			'start' => array(
				'dateTime' => $start,
				'timeZone' => 'Asia/Hong_Kong',
			),
			'end' => array(
				'dateTime' => $end,
				'timeZone' => 'Asia/Hong_Kong',
			),
			 'attendees' => array(
    			array('email' => 'kl2482@nyu.edu'), // fill from shibolith
 			),
		));
		
		$calendarId = $config[$x]["calendar_id"];
		$optionalArguments = array("sendNotifications"=>true);
		$event = $service->events->insert($calendarId, $event, $optionalArguments);

		print ("<div id=\"reservation_title\">Your Reservation</div>");
		print ("<div id=\"reservation_content\">");
		print ("<div><br />Your reservation has been successfully booked! Please tap check-in
		on the iPad outside of your reserved room when your session begins. Your session
		time will be given up if you fail to do this within 10 minutes of the start of
		your reservation.<br /><br /></div>");
		print ("<div><b>Reserved for:</b> kl2482</div>");
		print ("<div><b>Room Number:</b> $room</div>");
		print ("<div><b>Time Reserved:</b> 60 minutes</div>");
		print ("<div><b>Start Time:</b> $start</div>");
		print ("<div><b>End Time:</b> $end</div>");
		print ("</div>");

	}
}
?>
	</div>
</body>

</html>