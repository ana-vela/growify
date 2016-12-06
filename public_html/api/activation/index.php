<?php


require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__,3)."/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");


use Edu\Cnm\Growify\Profile;

/**
 * API for the activation code check.
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

	//sanitize input
	$activation = filter_input(INPUT_GET, "activation", FILTER_SANITIZE_STRING);

	// check if $activation is valid
	if(strlen($activation) !== 16){
		throw(new InvalidArgumentException("activation has an incorrect length", 405));
	}
	if(ctype_xdigit($activation) === false) {
		throw (new \InvalidArgumentException("activation is empty or has invalid contents", 405));
	}

	// handle GET request
	if($method === "GET"){
		// set XSRF Cookie
		setXsrfCookie();

		//find profile associated with the activation code
		$profile = Profile::getProfileByProfileActivation($pdo, $activation);
		if($profile !== null){
			if($activation === $profile->getProfileActivation()) {
				$profile->setProfileActivation(null);
				$profile->update($pdo);
				$reply->data = "Activation check OK";
			}
		} else {
			throw(new RuntimeException("Profile with this activation code does not exist", 404));
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