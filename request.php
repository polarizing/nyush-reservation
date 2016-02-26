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

<?php
	$selectRoom = $_REQUEST['byRoomType'];

	$date = $_REQUEST['date_input'];
	$start = $_REQUEST['start_time'];
	$end = $_REQUEST['end_time'];

	echo $selectRoom, $date, $start, $end;

	// CONVERT TO RFC3339 TIME FORMAT -- YYYY-MM-DDT00:00:00+08:00
	function convertDateToRFC($inputDate, $inputTime) {
		return $inputDate."T".$inputTime.":00+08:00";
	}

	function convertDateToEncodedRFC($inputDate, $inputTime) {
		return $inputDate."T".$inputTime.":00%2B08:00";
	}

	// Start Google Calendar Service
	$service = new Google_Service_Calendar($client);
	
	// Get all indexes of rooms in JSON file matching RoomType from POST variable 'byRoomType' and store in array $key
	$key = array();
	foreach ($allRoomType as $index=>$roomType) {
		if ($roomType == $selectRoom) {
			$key[] = $index;
		}
	}
	print "<div class=\"table-responsive\">";
	print "<table class=\"table\">";
		print "<thead>";
			print "<tr>";
				print "<th>Room #</th>";
			 	print "<th>Room Type</th>";
			 	print "<th>Date Available</th>";
			 	print "<th>Time Available</th>";
			 	print "<th>Reserve</th>";
			 print "</tr>";
		print "</thead>";
		print "<tbody>";
	try {
		for ($x = 0; $x < count($key); $x++) {
			$getCalID = $allCalID[$key[$x]];
			$getRoomID = $allRoomID[$key[$x]];
			$getRoomType = $allRoomType[$key[$x]];
			$getRoomDescription = $allRoomDescription[$key[$x]];
			$optParams = array(
				'maxResults' => 10,
				'orderBy' => 'startTime',
				'singleEvents' => TRUE,
				'timeMin' => convertDateToRFC($date, $start), // change to variable
				'timeMax' => convertDateToRFC($date, $end), // change to variable
				'q' => 'Reserved'
			);

			$results = $service->events->listEvents($getCalID, $optParams);
			if (count($results->getItems()) == 0) {
				print "<tr>";
				print "<td>$getRoomID</td>";
				print "<td>$getRoomType</td>";
				print "<td>$date</td>"; // change to variable
				print "<td>$start - $end</td>"; // change to variable
				print "<td><a href=\"form.php?room=$getRoomID&start=".convertDateToEncodedRFC($date, $start)."&end=".convertDateToEncodedRFC($date, $end)."\">Reserve</a></td>"; // change to variable *note encode of +
				print "</tr>";
			}

		}
	} catch (Google_Service_Exception $e) {
		print "<div>Invalid input. Please try again.</div>";
	}
		
		print "</tbody>";
	print "</table>";
	print "</div>";
	//YYYY-MM-DDT00:00:00+08:00
?>
