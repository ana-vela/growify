<?php


require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/util/mailer.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\Growify\Profile;

/**
 * API for the Profile class.
 * @author Greg Bloom
 */

// Check the session. If it is not active, start the session.
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {

	// get mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/growify.ini");

	//check which HTTP method was used
	$method = array_key_exists("HTTP_x_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize input
	$profileUserInput = filter_input(INPUT_GET, "profileUserInput", FILTER_SANITIZE_EMAIL);
	$profilePasswordInput = filter_input(INPUT_GET, "profilePasswordInput", FILTER_SANITIZE_STRING);

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
						$reply->message = "Profile Login OK";
					} else {
						$reply->message = "Profile password doesn't match";
					}
				} else {
					throw(new InvalidArgumentException("profile password is empty or invalid input", 405));
				}
			} elseif($profileByEmail !== null) {
				if(!empty($profilePasswordInput)) {
					if($profileByEmail->checkHash($profilePasswordInput)) {
						$reply->data = $profileByEmail;
						$reply->message = "Profile Login OK";
					} else {
						$reply->message = "Profile password doesn't match";
					}
				} else {
					throw(new InvalidArgumentException("profile password is empty or invalid input", 405));
				}
			} else {
				$reply->data = "No profile found";
			}
		} else {
			throw(new InvalidArgumentException("profile username or email is empty or invalid input", 405));
		}
	} elseif($method == "PUT" || $method == "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//make sure profileUsername is available
		if(empty($requestObject->profileUsername)) {
			throw(new \InvalidArgumentException ("No profile username", 405));
		}
		//make sure profileEmail is available
		if(empty($requestObject->profileEmail)) {
			throw(new \InvalidArgumentException ("No profile email", 405));
		}
		//make sure profileZipCode is available
		if(empty($requestObject->profileZipCode)) {
			throw(new \InvalidArgumentException ("No profile zipcode", 405));
		}
		if(empty($requestObject->profilePassword)) {
			throw(new \InvalidArgumentException ("No profile password", 405));
		}
		//perform the actual put or post
		if($method === "PUT") {

			$profile = Profile::getProfileByProfileUsername($pdo, $requestObject->profileUsername);
			if($profile === null) {
				throw(new RuntimeException("Profile does not exist", 404));
			}
			$profile->setProfileEmail($requestObject->profileEmail);
			$profile->setProfileZipCode($requestObject->profileZipCode);
			if(!$profile->checkHash($requestObject->profilePassword)) {
				$salt = bin2hex(random_bytes(16));
				$profile->setProfileHash(hash_pbkdf2("sha512", $requestObject->profilePassword, $salt, 262144));
				$profile->setProfileSalt($salt);
			}
			$profile->update($pdo);
			// update reply
			$reply->message = "Profile Entry Updated OK";
		} elseif($method === "POST") {
			// create new tweet and insert into the database
			$salt = bin2hex(random_bytes(32));
			$profile = new Profile(null, $requestObject->profileUsername, $requestObject->profileEmail, $requestObject->profileZipCode, hash_pbkdf2("sha512", $requestObject->profilePassword, $salt, 262144), $salt, bin2hex(random_bytes(8)));
			$profile->insert($pdo);
			//generate and send activation email

			// update reply
			$reply->message = "Profile Created OK";
		}
	}
	if($method == "DELETE") {
		$profile = Profile::getProfileByProfileUsername($pdo, $profileUserInput);
		if($profile !== null) {
			$profile->delete($pdo);
			//update reply
			$reply->message = "Profile Deleted OK";
		} else {
			throw(new RuntimeException("Profile does not exist", 404));
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