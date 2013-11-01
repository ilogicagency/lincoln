<?php
/////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// NEW FB OBJECT ////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////

$facebook = new Facebook(array(
  'appId'  => APP_ID,
  'secret' => APP_SECRET
));

// allow uploads
$facebook->setFileUploadSupport("http://" . $_SERVER['SERVER_NAME']);

$FB_ID = $user['social_id'];
$TOKEN = $user['social_token'];

$img = realpath("images/uploaded/".$img_new_name);
$users_albums = $facebook->api('/'.$FB_ID.'/albums', 'GET', array('access_token'	=> $TOKEN));
$album_count =  count($users_albums['data']);

		
try{
	for($i = 0; $i < $album_count; $i++){
		if($users_albums['data'][$i]['name'] == ALBUM_NAME){
			
			if($users_albums['data'][$i]['count'] < MAX_ALBUM_SIZE){
				$album_check = true;
				$album_num = $users_albums['data'][$i]['id'];
				$album_link = $users_albums['data'][$i]['link'];
				break;
			}
			
		}
	}
} catch(Exception $e) {
	error_log($e);
	echo "Error: Could not check users albums for ".ALBUM_NAME;
	throw $e;
}
		
if(!isset($album_check)) {//create the album
	try {
		$album_params = array(
			'access_token'	=>  $TOKEN,
			'name' 			=>	ALBUM_NAME,
			'message' 		=>	ALBUM_DESCRIPTION
		);
	
		$album_result = $facebook->api('/'.$FB_ID.'/albums','POST',$album_params);
		
		$album_num = $album_result['id'];
		//$album_link = $album_result['link'];
		
	} catch(Exception $e) {
		error_log($e);
		echo "Error: Could not create new album.";
		throw $e;
	}
}

/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////UPLOAD PIC TO USERS PHOTOS//////////////////////////
/////////////////////////////////////////////////////////////////////////////////

try {
	$pic = $facebook->api('/'.$FB_ID.'/photos', 'POST',
		array(
			'access_token'	=>  $TOKEN,
			'source' 		=> '@' . $img,
		)
	);		
} catch(Exception $e) {
	error_log($e);
	echo "Error: ".$e;
	throw $e;
}
//reset variable...
if(isset($album_check)){unset($album_check);}
?>