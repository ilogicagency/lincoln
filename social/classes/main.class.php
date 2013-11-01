<?php

class main {
		
	protected $host;
	protected $db_name;
	protected $username;
	protected $password;
	protected $db_link;
		
	function __construct(){
		
		$this->host		= 	DB_HOST;
		$this->db_name	= 	DB_NAME;
		$this->username	= 	DB_LOGIN;
		$this->password	= 	DB_PASS;
		$this->date		= 	date("Y-m-d G:i:s");
		
		//set up the db connection
		try {
		
			$this->db_link = mysql_connect($this->host,$this->username,$this->password) or die(mysql_error());
			mysql_select_db($this->db_name) or die(mysql_error());
			
		} catch(Exception $e) {
			echo "Could not set up database connection.";
		}
	}
	
	private function in_db($id, $type){
		$uid = "";
		$result = mysql_query("SELECT uid FROM users WHERE social_id = '".$id."' AND social_type = '".$type."'");
		while($row = mysql_fetch_array($result)){
		  $uid = $row['uid'];
		}
		return $uid;
	}
	
	public function get_user($id){
		$return_arr = array();
		$result = mysql_query("SELECT * FROM users WHERE uid = ".$id);
		while($row = mysql_fetch_array($result)){
		  $return_arr = $row;
		}
		return $return_arr;
	}
	
	public function save_user($usr_obj=array(), $type){
			if(	
				empty($usr_obj['social_id'])
			  ){
				//something was empty...
				throw new Exception('There was an error with one of the user details. Please retry or use a different account.');  
			}
			//are they in there already?
			$uid = $this->in_db($usr_obj['social_id'], $type);
			if(!empty($uid)){
				return $uid;
			}else{
				if(!isset($usr_obj['age'])){$usr_obj['age'] = '';}
				if(!isset($usr_obj['gender'])){$usr_obj['gender'] = '';}
				mysql_query("INSERT INTO users (
													email, 
													social_id, 
													first_name, 
													last_name, 
													social_token, 
													social_type, 
													meta,
													age,
													gender
												) VALUES (
													'".$usr_obj['email_address']."', 
													'".$usr_obj['social_id']."', 
													'".$usr_obj['first_name']."', 
													'".$usr_obj['last_name']."', 
													'".$usr_obj['token']."', 
													'".$type."', 
													'".$usr_obj['meta']."',
													'".$usr_obj['age']."',
													'".$usr_obj['gender']."'
													)", $this->db_link);
				return mysql_insert_id($this->db_link);
			}
	}
	
			

	
}

?>