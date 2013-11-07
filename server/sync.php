<?php

session_start();

set_time_limit(0);

error_reporting(E_ALL);
ini_set('display_errors', '1');

require('local_config.php');
require('classes/db.class.php');

try {
	$local_db = new db(false);
} catch (Exception $e) {
	die("Could not set up LOCAL database connection.");
}

switch ($_GET['scene']) {
	case 'Cape Town':
		$image = 'cape-town.png';
		break;

	case 'France':
		$image = 'france.png';
		break;

	case 'London':
		$image = 'london.png';
		break;

	default:
		$image = 'dubai.png';
}

$local_db->sql_query("INSERT INTO photos (user_id, image_name, uploaded, synced) VALUES ('" . $_SESSION['live_id'] . "', '" . $image . "', 'true', 'false')");

//get all the unsynced photos
$photos = json_decode(file_get_contents('http://' . SERVER_IP . '/lincoln/server/sync_server.php?action=photos'));
foreach ($photos as $photo) {
	try {
		//send to social
		$ch = curl_init();
		$data = array(
			'img_id' => $image,
			'owner' => $photo->user_id,
			'scene' => $_GET['scene'],
			'file' => '@' . IMAGE_PATH . $image
		);
		curl_setopt($ch, CURLOPT_URL, 'https://ilogicde.co.za/lincoln/photo_post.php');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$return = curl_exec($ch);
		print_r($return);

		//update local db for stats
		print 'Image '.$image.' uploaded';
	} catch (Exception $e) {
		die("Well that kinda failed");
	}
}
?>