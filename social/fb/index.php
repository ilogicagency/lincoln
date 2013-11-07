<?php

function fb_url_direct($facebook) {
	$loginUrl = $facebook->getLoginUrl(array(
		"canvas" => 1,
		"fbconnect" => 0,
		"display" => "page",
		"redirect_uri" => APP_CANVAS_URL,
		"scope" => "status_update,offline_access,publish_stream,user_photos,email,photo_upload,user_birthday",
		"cancel_url" => APP_CANVAS_URL
	));
	return "<script>window.top.location='" . $loginUrl . "';</script>";
}

function error_redirect($error) {
	die("<script>window.top.location='" . REG_URL . "?error=" . urlencode($error->getMessage()) . "';</script>");
}

function error_redirect_string($error) {
	die("<script>window.top.location='" . REG_URL . "?error=" . urlencode($error) . "';</script>");
}

function log_everyone_out($facebook) {
	$logout_array = array();
	$logout_array["next"] = APP_SOURCE_URL . "redirect.php";
	$logoutUrl = $facebook->getLogoutUrl($logout_array);
	die("<script>window.top.location='" . $logoutUrl . "';</script>");
}

session_start();

require '../config.php';
require '../libs/facebook/src/facebook.php';
require '../classes/main.class.php';


$main = new main();
$facebook = new Facebook(array('appId' => APP_ID, 'secret' => APP_SECRET));

// get the users unique FB ID // get these details first else the other methods will overwrite ;)
$fb_id = $facebook->getUser();
$access_token = $facebook->getAccessToken();



//1st check if this is the first step, if so make sure everything else is cleared...including loggin anyone out if they are logged in...
if (!empty($_REQUEST['start'])) {
	session_destroy();
	session_start();
	if (!empty($fb_id)) {
		$facebook->destroySession();
		error_redirect_string("Some users where not logged out please retry...");
		//log_everyone_out($facebook);	
	}
}

echo "You will be redirected shortly. If not then please restart the registration process as their was a network error.";


if (!$fb_id) {
	echo fb_url_direct($facebook);
	die;
}

//the users details should be here by now...
$user_profile = $facebook->api('/me');
$logout_array = array();
if (empty($_SESSION['user'])) {
	//get the extended token
	$token_url = "https://graph.facebook.com/oauth/access_token?"
			. "client_id=" . APP_ID
			. "&client_secret=" . APP_SECRET
			. "&grant_type=fb_exchange_token"
			. "&fb_exchange_token=" . $access_token;
	$response = file_get_contents($token_url);
	$params = NULL;
	parse_str($response, $params);
	//---------------------

	$_SESSION['user'] = array();
	$_SESSION['user']['social_id'] = $fb_id;
	$_SESSION['user']['token'] = $params['access_token'];
	$_SESSION['user']['first_name'] = $user_profile['first_name'];
	$_SESSION['user']['last_name'] = $user_profile['last_name'];
	$_SESSION['user']['email_address'] = $user_profile['email'];
	$_SESSION['user']['meta'] = "";
	$_SESSION['user']['gender'] = (isset($user_profile['gender'])) ? $user_profile['gender'] : "";
	$_SESSION['user']['age'] = (isset($user_profile['birthday'])) ? (date("Y") - date("Y", strtotime($user_profile['birthday']))) : "";

	$tokenData = [];
	$tokenData['social_id'] = $fb_id;
	$tokenData['social_type'] = 'facebook';
	$tokenData['social_token'] = $params['access_token'];
	$tokenData['email'] = $user_profile['email'];

	$main->userTokenUpdate($tokenData);
}

//only store if both users have been logged and the team still exists...
if ($_SESSION['user']) {
	//
	try {
		$uid = $main->save_user($_SESSION['user'], "facebook");
	} catch (Exception $e) {
		error_redirect($e);
	}

	$_SESSION['user']['online_uid'] = $uid;

	$logout_array["next"] = APP_SOURCE_URL . "redirect.php?ip=" . SERVER_IP;
	//
}

//now log the user out and redirect them
$logoutUrl = $facebook->getLogoutUrl($logout_array);
$facebook->destroySession();
die("<script>window.top.location='" . $logoutUrl . "';</script>");
?>