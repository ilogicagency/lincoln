<?php

class db {

	protected $host;
	protected $db_name;
	protected $username;
	protected $password;
	protected $db_link;
	protected $team_id;
	protected $team_name;
	protected $date;
	public $insert_id;

	function __construct($live) {
		if ($live) {
			$this->host = LIVE_DB_HOST;
			$this->db_name = LIVE_DB_NAME;
			$this->username = LIVE_DB_LOGIN;
			$this->password = LIVE_DB_PASS;
		} else {
			$this->host = LOCAL_DB_HOST;
			$this->db_name = LOCAL_DB_NAME;
			$this->username = LOCAL_DB_LOGIN;
			$this->password = LOCAL_DB_PASS;
		}

		//set up the db connection
		try {
			$this->db_link = mysql_connect($this->host, $this->username, $this->password) or die(mysql_error());
			mysql_select_db($this->db_name) or die(mysql_error());
		} catch (Exception $e) {
			echo "Could not set up database connection.";
		}
	}

	public function query($sql) {
		$result = mysql_query($sql, $this->db_link);
		$this->insert_id = mysql_insert_id($this->db_link);
		return mysql_affected_rows();
	}

	public function get_user($user_id) {
		$return = array();
		$result = mysql_query("SELECT * FROM users WHERE uid = " . $user_id . " LIMIT 1", $this->db_link);
		while ($row = mysql_fetch_assoc($result)) {
			$return = $row;
		}
		return $return;
	}

	public function update_user($usr_arr) {
		mysql_query("UPDATE users SET
			first_name 		= '" . mysql_real_escape_string($usr_arr['first_name']) . "',
			last_name 		= '" . mysql_real_escape_string($usr_arr['last_name']) . "',
			email 			= '" . mysql_real_escape_string($usr_arr['email']) . "',
			contact_number 	= '" . mysql_real_escape_string($usr_arr['contact_number']) . "',
			receive_info	= '" . mysql_real_escape_string($usr_arr['info']) . "'
			WHERE uid = " . mysql_real_escape_string($usr_arr['uid']), $this->db_link);
	}

	public function profileBookingUpdate($userId = null, $booking = 0, $features) {
		mysql_query("UPDATE profiles SET
			feature_mode = $features->mode,
			feature_music = $features->music,
			feature_lighting = $features->lighting,
			feature_traffic = $features->traffic,
			feature_shift = $features->shift,
			feature_touch = $features->touch,
			feature_voice = $features->voice,
			feature_lane = $features->lane,
			feature_noise = $features->noise,
			feature_park = $features->park,
			booking = $booking
			WHERE id = " . $userId, $this->db_link);
	}

	public function profileBookingUpdateStandalone($userId = null, $booking = 0) {
		mysql_query("UPDATE profiles SET
			booking = $booking
			WHERE id = " . $userId, $this->db_link);
	}

	public function profileExperienceUpdate($choices = null, $userId = null) {
		foreach ($choices as &$val)
			$val = mysql_real_escape_string($val);

		mysql_query("UPDATE profiles SET
			scenary = '$choices->scenary', drive_style = '$choices->driveStyle', music = '$choices->music', lighting = '$choices->lighting'
			WHERE id = " . $userId, $this->db_link);
	}

	public function profileSave($data, $book = 0) {
		mysql_query("INSERT INTO profiles (
			name,
			surname,
			email_address,
			mobile_number,
			preferred_language,
			country_of_residence,
			emirate_uae_only,
			designation,
			current_car,
			model_of_current_car,
			booking
			) VALUES (
			'" . mysql_real_escape_string($data['first_name']) . "',
			'" . mysql_real_escape_string($data['last_name']) . "',
			'" . mysql_real_escape_string($data['email']) . "',
			'" . mysql_real_escape_string($data['contact_number']) . "',
			'" . mysql_real_escape_string($data['language']) . "',
			'" . mysql_real_escape_string($data['country']) . "',
			'" . mysql_real_escape_string($data['emirate']) . "',
			'" . mysql_real_escape_string($data['designation']) . "',
			'" . mysql_real_escape_string($data['car']) . "',
			'" . mysql_real_escape_string($data['model']) . "',
			$book
			)", $this->db_link);
	}

	public function profileExists($email = '') {
		$query = mysql_query("SELECT * FROM profiles WHERE email_address = '$email' ORDER BY id DESC", $this->db_link);

		if (mysql_num_rows($query) != 0) {
			$data = mysql_fetch_assoc($query);

			return $data;
		}
	}

	public function save_user($usr_arr) {
		$in_db_user = $this->userExists($usr_arr['email']);

		if (empty($in_db_user)) {
			if (!isset($usr_arr['age'])) {
				$usr_obj['age'] = '';
			}

			if (!isset($usr_arr['gender'])) {
				$usr_obj['gender'] = '';
			}

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
				'" . $usr_arr['email'] . "', 
				'" . $usr_arr['social_id'] . "', 
				'" . $usr_arr['first_name'] . "', 
				'" . $usr_arr['last_name'] . "', 
				'" . $usr_arr['social_token'] . "', 
				'" . $usr_arr['social_type'] . "', 
				'" . $usr_arr['meta'] . "',
				'" . $usr_arr['age'] . "',
				'" . $usr_arr['gender'] . "'
				)", $this->db_link);
		}
	}

	public function userTokenUpdate($usr_arr) {
		mysql_query("UPDATE users SET
				social_id = '" . $usr_arr['social_id'] . "',
				social_token = '" . $usr_arr['social_token'] . "', 
				social_type = '" . $usr_arr['social_type'] . "'
				WHERE email = '" . $usr_arr['email'] . "'", $this->db_link);
	}

	public function userSaveBypassSocial($usr_arr) {
		mysql_query("INSERT INTO users (
				email,
				first_name,
				last_name,
				contact_number,
				social_id
				) VALUES (
				'" . $usr_arr['email'] . "',
				'" . $usr_arr['first_name'] . "',
				'" . $usr_arr['last_name'] . "',
				'" . $usr_arr['number'] . "',
				'bypass'
				)", $this->db_link);
	}

	public function userExists($email = '') {
		$query = mysql_query("SELECT * FROM users WHERE email = '$email'", $this->db_link);

		if ($query) {
			$data = mysql_fetch_assoc($query);

			return $data;
		}
	}

	public function sql_query($sql) {
		return mysql_query($sql, $this->db_link);
	}

}

?>