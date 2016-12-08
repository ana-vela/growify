<?php

require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__,3)."/php/lib/xsrf.php";
require_once "/etc/apache2/capstone-mysql/encrypted-config.php";

use Edu\Cnm\Growify\CompanionPlant;

/**
 * API for the CompanionPlant class
 * @author Ana Vela avela7@cnm.edu
 **/

// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try{

	// get mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/growify.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$plantName = filter_input(INPUT_GET, "companionPlantName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

// handle GET request
	if($method === "GET"){
		// set XSRF Cookie
		setXsrfCookie();

		//get companion plant or all companion plants
		if(empty($plantName)===false){
			$companionPlant = CompanionPlant::getCompanionPlantsByPlantName($pdo, $plantName);
			if($companionPlant !== null){
				$reply->data = $companionPlant;
			}
		} else {
			$companionPlants = CompanionPlant::getAllCompanionPlants($pdo);
			if($companionPlants !== null){
				$reply->data = $companionPlants;
			}
		}
	} else {
		throw(new InvalidArgumentException("Invalid HTTP method request"));
	}

} catch (Exception $exception){
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError){
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");
if($reply->data === null){
	unset($reply->data);
}

echo json_encode($reply);