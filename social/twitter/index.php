<?php
//error_reporting(E_ALL);
//ini_set("display_errors",1);

function error_redirect_string($error){
	die("<script>window.top.location='".REG_URL."?error=".urlencode($error)."';</script>");
}

function error_redirect($error){
	die("<script>window.top.location='".REG_URL."?error=".urlencode($error->getMessage())."';</script>");
}

require("../config.php");
require '../classes/main.class.php';
require("../libs/twitteroauth/twitteroauth.php");  
session_start();

if(!empty($_REQUEST['start'])){
	if(isset($_SESSION['user'])){
		unset($_SESSION['user']);	
	}
}

if(!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])){  
    // TwitterOAuth instance, with two new parameters we got in twitter_login.php  
    $twitteroauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);  
    // Let's request the access token  
    $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']); 
    // Save it in a session var 
    $_SESSION['access_token'] = $access_token; 
    // Let's get the user's info 
    $user_info = $twitteroauth->get('account/verify_credentials'); 
//	die("<script>console.log('".$_GET['oauth_verifier']."');console.log('".$_SESSION['oauth_token']."');console.log('".$_SESSION['oauth_token_secret']."');console.log('".$twitteroauth."');console.log('".$access_token."');console.log('".$user_info."');</script>");
	if(empty($user_info->id)){error_redirect_string("Error: User id empty, please retry");}
    //print_r($user_info);die();
	$names = explode(' ', $user_info->name);
	
	$_SESSION['user'] = array();	
	$_SESSION['user']['social_id'] 		= 	$user_info->id;
	$_SESSION['user']['token'] 			= 	json_encode(array('verifier' => $_GET['oauth_verifier'], 'token' => $access_token['oauth_token'], 'token_secret' => $access_token['oauth_token_secret']));
	$_SESSION['user']['first_name'] 	= 	$names[0];
	$_SESSION['user']['last_name'] 		= 	$names[1];
	$_SESSION['user']['meta'] 			= 	json_encode(array('profile_pic' => $user_info->profile_image_url));
	$_SESSION['user']['email_address'] 	= 	"";//can't get it via twitter
	
	$main = new main();
	try{
		$uid = $main->save_user($_SESSION['user'], "twitter");
	}catch(Exception $e){
		error_redirect($e);
	}
	
	unset($_SESSION);
	echo "<script>window.top.location='http://".SERVER_IP."/lincoln/server/register.php?live_id=".$uid."';</script>";
	die();
}

// The TwitterOAuth instance  
$twitteroauth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);  
// Requesting authentication tokens, the parameter is the URL we will be redirected to  
$request_token = $twitteroauth->getRequestToken(TWITTER_REDIRECT_URI);  
  
// Saving them into the session  
$_SESSION['oauth_token'] = $request_token['oauth_token'];  
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];  
  
// If everything goes well..  
if($twitteroauth->http_code==200){  
	// Let's generate the URL and redirect  
	$url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']); 
	header('Location: '. $url.'&force_login=true'); 
} else { 
	// It's a bad idea to kill the script, but we've got to know when there's an error.  
	die('Something wrong happened.');  
} 
?>