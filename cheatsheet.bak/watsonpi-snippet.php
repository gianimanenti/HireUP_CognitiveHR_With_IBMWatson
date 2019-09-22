<?php
	// VCAP_SERVICES extraction and retrieval of Watson PI credentials
	$services_json = json_decode(getenv('VCAP_SERVICES'), true);
	$watsonPi = $services_json["personality_insights"][0]["credentials"];

	// Extract the VCAP_SERVICES variables for Watson PI connection.
  // i.e. username, password and url
	$username = $watsonPi["username"];
	$password = $watsonPi["password"];
	$url = $watsonPi["url"] . "/v2/profile";

	// Curl initialization to make REST call to Watson service
	$curl = curl_init();

	// Get textarea field from POST request
	$data = $_POST["txtarea"];

	// Set post arguments for call
	$post_args = array(
    	'body' => $data
	);

  // Set header arguments for call
	$header_args = array(
    	'Content-Type: text/plain',
    	'Accept: application/json'
	);

  // Set options for REST call via curl
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post_args);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $header_args);
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	// Actual REST call via curl and cleanup (closing) of curl call
	$result = curl_exec($curl);
	curl_close($curl);

  // Decode JSON object for furhter usage. Only used here to pretty print JSON object
	$decoded = json_decode($result, true);

  // Echo result as pretty printed JSON
	echo json_encode($decoded, JSON_PRETTY_PRINT);
?>
