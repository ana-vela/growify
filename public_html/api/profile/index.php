<?php


require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__,3)."/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Growify\Profile;

/**
 * API for the Profile class.
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
	$profileUserInput = filter_input(INPUT_GET, "profileUserInput", FILTER_SANITIZE_EMAIL);
	$profilePasswordInput = filter_input(INPUT_GET, "profilePasswordInput", FILTER_SANITIZE_STRING);

	// check if $profileUserInput is valid
	if(empty($profileUserInput)) {
		throw(new InvalidArgumentException("profile username or email is empty or invalid input", 405));
	} elseif(strlen($profileUserInput) > 24) {
		throw(new RangeException("profile username or email is too long", 405));
	}

	// handle GET request
	if($method === "GET") {
		// set XSRF Cookie
		setXsrfCookie();

		//get profile by username or email
		if(empty($profileUserInput) === false) {
			$profileByUsername = Profile::getProfileByProfileUsername($pdo, $profileUserInput);
			$profileByEmail = Profile::getProfileByProfileEmail($pdo, $profileUserInput);

			if($profileByUsername !== null) {
				//checks if user entered a password
				if(!empty($profilePasswordInput)) {
					//checks hashed password against stored hash
					if($profileByUsername->checkHash($profilePasswordInput)) {
						$reply->data = $profileByUsername;
						echo "Password match";
					} else {
						echo "Password does not match";
					}
				} else {
					throw(new InvalidArgumentException("profile password is empty or invalid input", 405));
				}
			} elseif($profileByEmail !== null) {
				if(!empty($profilePasswordInput)) {
					if($profileByEmail->checkHash($profilePasswordInput)) {
						$reply->data = $profileByEmail;
						echo "Password match";
					} else {
						echo "Password does not match";
					}
				} else {
					throw(new InvalidArgumentException("profile password is empty or invalid input", 405));
				}
			} else {
				$reply->data = "No profile found";
			}
		} else {
			$profiles = Profile::getAllProfiles($pdo);
			if($profiles !== null) {
				$reply->data = $profiles;
			}
		}
	} else {
		throw(new InvalidArgumentException("Invalid HTTP method request"));
	}

} catch
(Exception $exception) {
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

echo json_encode($reply);