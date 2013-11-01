<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require('local_config.php');
require('classes/db.class.php');

try {
	$local_db = new db(false);
} catch (Exception $e) {
	die("Could not set up LOCAL database connection.");
}

if (isset($_POST['submit'])) {
	$profileId = $local_db->profileExists($_POST['email']);
	$book = isset($_POST['book']) ? 1 : 0;

	if (empty($profileId)) {
		$userSave = array();
		$userSave['first_name'] = $_POST['first_name'];
		$userSave['last_name'] = $_POST['last_name'];
		$userSave['email'] = $_POST['email'];
		$userSave['contact_number'] = $_POST['number'];
		$userSave['language'] = $_POST['language'];
		$userSave['country'] = $_POST['country'];
		$userSave['emirate'] = $_POST['emirate'];
		$userSave['designation'] = $_POST['designation'];
		$userSave['car'] = (($_POST['cur_car'] == 'Other')) ? $_POST['other_car'] : $_POST['cur_car'];
		$userSave['model'] = $_POST['model_year'];
		$userSave['del_address'] = $_POST['del_address'];

		$local_db->profileSave($userSave, $book);
	} else {
		$local_db->profileBookingUpdateStandalone($profileId, $book);
	}

	header("Location: book-test-drive.php");
	exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <title>LINCOLN</title>
        <link href="src/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css"/>
        <link href="src/css/bootstrap-responsive.min.css" media="screen" rel="stylesheet" type="text/css"/>
        <link href="src/css/core.css" media="screen" rel="stylesheet" type="text/css"/>
        <link href="src/css/screen.css" media="screen" rel="stylesheet" type="text/css"/>
        <link href="src/css/validationEngine.jquery.css" media="all" rel="stylesheet" type="text/css" />
		<style type="text/css">
			input[type="checkbox"]{
				float: left;
				margin: 15px;
			}

			label{
				padding: 10px 0;
			}

			.span6{
				margin-bottom: 15px;
			}
		</style>
    </head>
    <body class="book">
        <div class="container">
			<div class="row">
				<form method="post" action="" id="f_reg">
					<div class="span6">
						<table>
							<tr><th>Name*</th><td><input class="validate[required]" type="text" name="first_name" id="first_name" value=""></td></tr>
							<tr><th>Surname*</th><td><input class="validate[required]" type="text" name="last_name" id="last_name" value=""></td></tr>
							<tr><th>Email Address*</th><td><input class="validate[required,custom[email]]" type="text" name="email" id="email" value=""></td></tr>
							<tr><th>Mobile Number*</th><td><input class="validate[required]" type="text" name="number" id="number" value=""></td></tr>
							<tr>
								<th>Preferred Language*</th>
								<td>
									<select class="validate[required]" name="language" id="language">
										<option value="">Please select preferred language</option>
										<option value="English">English</option>
										<option value="Arabic">Arabic</option>
									</select>
								</td>
							</tr>
							<tr>
								<th>Country of Residence*</th>
								<td>
									<select class="validate[required]" name="country" id="country">
										<option value="">Please select country of residence</option>
										<option value="UAE">UAE</option>
										<option value="Kuwait">Kuwait</option>
										<option value="Lebanon">Lebanon</option>
										<option value="Bahrain">Bahrain</option>
										<option value="Oman">Oman</option>
										<option value="Qatar">Qatar</option>
										<option value="Saudi Arabia">Saudi Arabia</option>
									</select>
								</td>
							</tr>
						</table> 
					</div>
					<div class="span6">
						<table>
							<tr>
								<th>Emirate (UAE ONLY)</th>
								<td>
									<select name="emirate" id="emirate">
										<option value="">Please select emirate</option>
										<option value="Dubai">Dubai</option>
										<option value="Abu Dabi">Abu Dabi</option>
										<option value="Sharjah">Sharjah</option>
										<option value="Fujarah">Fujarah</option>
										<option value="Ras Al Khaimah">Ras Al Khaimah</option>
										<option value="Ajman">Ajman</option>
										<option value="Umm Al Quwain">Umm Al Quwain</option>
									</select>
								</td>
							</tr>
							<tr><th>Designation/Job Title*</th><td><input class="validate[required]" type="text" name="designation" id="designation" value=""></td></tr>
							<tr>
								<th>Current Car*<br/><span id="other_car" style="display: none">(Please specify)</span></th>
								<td>
									<select class="validate[required]" name="cur_car" id="cur_car">
										<option value="">Please select your current car</option>
										<option value="Lexus">Lexus</option>
										<option value="Cadillac">Cadillac</option>
										<option value="Audi">Audi</option>
										<option value="BMW">BMW</option>
										<option value="Mercedes">Mercedes</option>
										<option value="Other">Other</option>
									</select>
									<input class="validate[required]" type="text" name="other_car" id="other_car" value="" style="display: none">
								</td>
							</tr>
							<tr>
								<th>Model of Current Car*</th>
								<td>
									<select class="validate[required]" name="model_year" id="model_year">
										<option value="">Please select model of your current car</option>
										<option value="2014">2014</option>
										<option value="2013">2013</option>
										<option value="2012">2012</option>
										<option value="2011">2011</option>
										<option value="2010">2010</option>
										<option value="2009">2009</option>
										<option value="older than 2009">Older than 2009</option>
									</select>
								</td>
							</tr>
							<tr><th>Delivery Address (UAE ONLY)</th><td><input type="text" name="del_address" id="del_address" value=""></td></tr>
						</table>
					</div>
					<div class="span12">
						<table style="width: 100%">
							<tr>
								<td style="width: 1%">
									<input type="checkbox" name="book" id="book" />
								</td>
								<td style="width: 99%">
									<label for="book">I would like to book a test drive</label>
								</td>
							</tr>
						</table>
					</div>
					<div class="span2 offset5">
						<input type="submit" value="Submit" name="submit" class="submit_btn">
					</div>
				</form>
			</div>
		</div>
		<script src="src/js/jquery-1.10.2.min.js" type="text/javascript"></script>
		<script src="src/js/core.js"></script>
		<script src="src/js/jquery.validationEngine-en.js"></script>
		<script src="src/js/jquery.validationEngine.js"></script>
		<script type="text/javascript">
			(function($) {
				$(document).ready(function() {
					$("#f_reg").validationEngine('attach');

					$('input[type="submit"]').on('click', function() {
						if ($("#f_reg").validationEngine('validate'))
							$(this).hide();
					});
				});
			})(jQuery);
		</script>
	</body>
</html>