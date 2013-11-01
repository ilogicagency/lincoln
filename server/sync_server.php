<?php

set_time_limit(0);

require('local_config.php');
require('classes/db.class.php');


//get all the unsynced photos

switch ($_REQUEST['action']) {
    case 'photos':
		photos();
        break;
		
}

function photos(){
	try {$local_db = new db(false);} catch(Exception $e) {die("Could not set up LOCAL database connection.");}
	$result = $local_db->sql_query("SELECT * FROM photos WHERE synced = 'false'");
	$ret_arr = array();
	while($row = mysql_fetch_assoc($result)){
			$ret_arr[] = $row;
			$local_db->sql_query("UPDATE photos SET synced='true' WHERE uid=".$row['uid']."");
	}
	echo json_encode($ret_arr);
}




//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


?>