<?php
/**
 * login api
 */

require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__,3)."/php/lib/xsrf.php";
require_once "/etc/apache2/capstone-mysql/encrypted-config.php";

use Edu\Cnm\Growify\Profile;

// Check the session status. If it is not active, start the session.
if(session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {

	verifyXsrf();

	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/growify.ini");

	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	if($method === "POST") {
		// retrieveds json package from front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// check username & password available and sanitize
		if(empty($requestObject->userName) === true) {
			throw(new \InvalidArgumentException("Must enter a username", 405));
		} else {
			$userName = filter_var($requestObject->userName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		}

		if(empty($requestObject->userPassword) === true) {
			throw(new \InvalidArgumentException("must enter a password", 405));
		} else {
			$password = filter_var($requestObject->userPassword, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		}

		// create a user object
		$profile = Profile::getProfileByProfileUsername($pdo, $userName);

		if(empty($user)) {
			throw(new \InvalidArgumentException("username or password incorrct", 401));
		}

		// check for activation token - it would indicate account not activated yet
		if($profile->getProfileActivation() !== null) {
			throw(new \InvalidArgumentException("account not yet activated, please activate", 402));
		}

		$hash = hash_pbkdf2("sha512", $password, $profile->getProfileSalt(), 262144);

		if($hash !== $user->getUserHash()) {
			throw(new \InvalidArgumentException("username or password is inocrrect", 401));
		}

		// add info to session so we can track who is logged in
		$_SESSION["profile"] = $profile;
		// TODO do we need to store any other info in the session? maybe not?
		$reply->message = "Successfully logged in!";
	} else {
		throw(new \InvalidArgumentException("Invalid HTTP method request"));
	}
} catch(Exception $e){
	$reply->status = $e->getCode();
	$reply->message = $e->getMessage();
} catch(TypeError $te){
	$reply->status = $te->getCode();
	$reply->message = $te->getMessage();
}

header("Content-type: application/json");

// encode & return reply
echo json_encode($reply);

