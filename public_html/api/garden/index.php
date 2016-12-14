<?php
/**
 * Created by PhpStorm.
 * User: Growify
 * Date: 11/28/2016
 * Time: 12:20 AM
 */


require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__,3)."/php/lib/xsrf.php";
require_once "/etc/apache2/capstone-mysql/encrypted-config.php";

use Edu\Cnm\Growify\Garden;

// Check the session status. If it is not active, start the session.
if(session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
// Here we create a new stdClass named $reply. A stdClass is basically an empty bucket that we can use to store things in.
// We will use this object named $reply to store the results of the call to our API. The status 200 line adds a state variable to $reply called status and initializes it with the integer 200 (success code). The proceeding line adds a state variable to $reply called data. This is where the result of the API call will be stored. We will also update $reply->message as we proceed through the API.


try {
	//grab the mySQL DataBase connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/growify.ini");

	//determines which HTTP Method needs to be processed and stores the result in $method.
	$method = array_key_exists("HTTP_x_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	$plantId = filter_input(INPUT_GET, "plantId", FILTER_VALIDATE_INT);
	// get the profileId for the currently logged-in user

	if(isset($_SESSION["profile"])){
		$profileId = $_SESSION["profileId"];
	} else {
		throw(new \InvalidArgumentException("no session - user is not logged in", 401));

	}

	if($method === "GET"){
		//set XSRF cookie
		setXsrfCookie();
		//get a specific garden or all gardens and update reply
		// only get gardens for currently logged-in user


			$garden = Garden::getGardensByGardenProfileId($pdo, $profileId);
			if($garden !== null) {
				$reply->data = $garden->toArray();
			}


	} else if($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);


		// make sure garden date is accurate (optional field)
		if(empty($requestObject->gardenDatePlanted) === true){
			$requestObject->gardenDatePlanted = new \DateTime();
		}
		//perform the actual put or post
		if($method === "PUT") {
			//TO DO: FINISH SOLUTION TO PUT************
			// retrieve the garden to update
			$plantId = $requestObject->gardenPlantId;

			$garden = Garden::getGardenByProfileIdAndPlantId($pdo, $profileId, $plantId);
			if($garden === null){
				throw(new RuntimeException("Garden(s) does not exist", 404));
			}

				$garden->setGardenDatePlanted($requestObject->gardenDatePlanted);
				$garden->updateGardenDatePlanted($pdo);

			// update reply
			$reply->message = "Garden Entry Updated OK";
		}else if($method === "POST") {
			// create new garden and insert into the database
			$garden = new Garden($requestObject->gardenProfileId, $requestObject->gardenDatePlanted, $requestObject->gardenPlantId);
			$garden->insert($pdo);
			// update reply
			$reply->message = "Garden created OK";
		}

	} else if($method === "DELETE") {
		verifyXsrf();
		$garden = Garden::getGardenByProfileIdAndPlantId($pdo,$profileId,$plantId);
		if($garden === null) {
			throw(new RuntimeException("Garden does not exist", 404));
		}else{
			$garden->delete($pdo);
			$reply->message = "Garden deleted OK";
		}
	} /*else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}*/

	// update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);

?>