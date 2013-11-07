<?php
ini_set('max_execution_time', 0);
error_reporting(E_ALL);
ini_set('display_errors', '1');

		if($_FILES["file"]["error"] != '0'){die('error with upoload');}
		if(!isset($_POST['img_id'])){die('error: img_id not specified');}else{$img_id = $_POST['img_id'];}
		if(!isset($_POST['owner'])){die('error: owner not specified');}else{$owner = $_POST['owner'];}
                if(!isset($_POST['scene'])){die('error: owner not specified');}else{$scene = $_POST['scene'];}
		//$img_id = 1090;
		//$owner = 76;
	
		require('config.php');
		require('classes/main.class.php');
		
		/////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////// SAVE IMAGE ///////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////
		$img_new_name = $img_id;
		move_uploaded_file($_FILES["file"]["tmp_name"] , "images/uploaded/".$img_new_name);
		
		//get user details
		$db = new main();
		$user = $db->get_user($owner);
		var_dump($user);
		/////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////// REQUIRE LIBS /////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////
		
		try{
			switch ($user['social_type'])
			{
			case "facebook":
			  require('libs/facebook/src/facebook.php');
			  require('post_pages/facebook.php');
			  echo 'facebook_done';
			  break;
			case "twitter":
			  require_once('libs/twitteroauth/twitteroauth.php');
			  require('post_pages/twitter.php');
			  echo 'twitter_done';
			  break;
			}
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		
		//update database
		
		

		
		
		
	
?>
