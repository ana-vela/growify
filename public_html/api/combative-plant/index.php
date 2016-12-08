<?php


require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__,3)."/php/lib/xsrf.php";
require_once "/etc/apache2/capstone-mysql/encrypted-config.php";

use Edu\Cnm\Growify\CombativePlant;

/**
 * API for the CombativePlant class.
 * @author Rebecca Dicharry
 */

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
	$plantName = filter_input(INPUT_GET, "combativePlantName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


	// handle GET request
	if($method === "GET"){
		// set XSRF Cookie
		setXsrfCookie();

		//get combative plant or all combative plants
		if(empty($plantName)===false){
			$combativePlant = CombativePlant::getAllCombativePlantsByPlantName($pdo, $plantName);
			if($combativePlant !== null){
				$reply->data = $combativePlant->toArray();
			}
		} else {
			$combativePlants = CombativePlant::getAllCombativePlants($pdo);
			if($combativePlants !== null){
				$reply->data = $combativePlants->toArray();
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