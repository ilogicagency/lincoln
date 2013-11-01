<?php

require '../config.php';

session_start();

$uid = $_SESSION['user']['online_uid'];

$server = SERVER_IP;

//session_destroy();

if(empty($uid)){
	header("Location: ".REG_URL."?error=".urlencode("Error: user was not stored or retreived, please retry..."));
}

header("Location: http://".$server."/lincoln/server/register.php?live_id=".$uid);

?>