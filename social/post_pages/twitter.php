<?php

$tokens = json_decode($user['social_token']);
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $tokens->token, $tokens->token_secret);
$ret = $connection->post('statuses/update', array('status' => 'Lincoln MKZ Virtual Test Drive at '.$scene.': '."https://www.ilogic.co.za/lincoln/images/uploaded/".$img_new_name));

?>