<?php


require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__,3)."/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");


use Edu\Cnm\Growify\Plant;

/**
 * API for the Plant class.
 * @author Greg Bloom
 */

// Check the session. If it is not active, start the session.
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

	//check which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$plantId = filter_input(INPUT_GET, "plantId", FILTER_VALIDATE_INT);
	$plantName = filter_input(INPUT_GET, "plantName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$plantLatinName = filter_input(INPUT_GET, "plantLatinName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);



	// handle GET request
	if($method === "GET"){
		// set XSRF Cookie
		setXsrfCookie();

		//get plant or all plants
		if(empty($plantId)===false){
			// check if $plantId is valid
			if($plantId < 0){
				throw(new InvalidArgumentException("plant Id cannot be negative", 405));
			}
			$plant = Plant::getPlantByPlantId($pdo, $plantId);
			if($plant !== null){
				$reply->data = $plant;
			}
		} else if(empty($plantName)===false){
			$plant = Plant::getPlantByPlantName($pdo, $plantName);
			if($plant !== null){
				$reply->data = $plant->toArray();
			}
		} else if(empty($plantLatinName)===false){
			$plant = Plant::getPlantByPlantLatinName($pdo, $plantLatinName);
			if($plant!==null){
				$reply->data = $plant->toArray();
			}
		}

		else {
			$plants = Plant::getAllPlants($pdo);
			if($plants !== null){
				$reply->data = $plants->toArray();
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