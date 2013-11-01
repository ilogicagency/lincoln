<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require('local_config.php');
require('classes/db.class.php');

session_start();

try {
	$local_db = new db(false);
} catch (Exception $e) {
	die("Could not set up LOCAL database connection.");
}

$user_arr = $local_db->get_user($_SESSION['uid']);
if (empty($user_arr)) {
	header("Location: " . REG_URL . "?error=" . urlencode("Error: user not found, please retry..."));
	exit;
}

if (isset($_GET['choices']) && !$_POST) {
	$choices = json_decode(urldecode($_GET['choices']));
	$local_db->profileExperienceUpdate($choices, $_SESSION['profileId']);
}

if (isset($_POST['submit'])) {
	$book = isset($_POST['book']) ? 1 : 0;

	$features = new stdClass();
	$features->mode = isset($_POST['mode']) ? 1 : 0;
	$features->music = isset($_POST['music']) ? 1 : 0;
	$features->lighting = isset($_POST['lighting']) ? 1 : 0;
	$features->traffic = isset($_POST['traffic']) ? 1 : 0;
	$features->shift = isset($_POST['shift']) ? 1 : 0;
	$features->touch = isset($_POST['touch']) ? 1 : 0;
	$features->voice = isset($_POST['voice']) ? 1 : 0;
	$features->lane = isset($_POST['lane']) ? 1 : 0;
	$features->noise = isset($_POST['noise']) ? 1 : 0;
	$features->park = isset($_POST['park']) ? 1 : 0;

	$local_db->profileBookingUpdate($_SESSION['profileId'], $book, $features);
}

if ($_POST) {
	header("Location: thank-you.php");
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
			<div class="row" id="synchronising"<?php if ($_SESSION['bypass'] == 'bypass') { ?> style="display: none"<?php } ?>>
				<div class="span12">
					<p>Synchronising to social media...</p>
				</div>
			</div>
			<div class="row" id="features"<?php if ($_SESSION['bypass'] != 'bypass') { ?> style="display: none"<?php } ?>>
				<form name="form" action="" method="post">
					<div class="span4 offset2">
						<div>
							<input type="checkbox" name="mode" id="mode" class="feature" />
							<label for="mode">Drive Mode Selection</label>
						</div>
						<div>
							<input type="checkbox" name="music" id="music" class="feature" />
							<label for="music">Music Selection</label>
						</div>
						<div>
							<input type="checkbox" name="lighting" id="lighting" class="feature" />
							<label for="lighting">Ambient Light Selection</label>
						</div>
						<div>
							<input type="checkbox" name="traffic" id="traffic" class="feature" />
							<label for="traffic">Cross traffic Alert Feature</label>
						</div>
						<div>
							<input type="checkbox" name="shift" id="shift" class="feature" />
							<label for="shift">Push Button Shift Feature</label>
						</div>
					</div>
					<div class="span6">
						<div>
							<input type="checkbox" name="touch" id="touch" class="feature" />
							<label for="touch">My Lincoln Touch System</label>
						</div>
						<div>
							<input type="checkbox" name="voice" id="voice" class="feature" />
							<label for="voice">Voice Command</label>
						</div>
						<div>
							<input type="checkbox" name="lane" id="lane" class="feature" />
							<label for="lane">Lane Keeping System Feature</label>
						</div>
						<div>
							<input type="checkbox" name="noise" id="noise" class="feature" />
							<label for="noise">Active Noise Control Feature</label>
						</div>
						<div>
							<input type="checkbox" name="park" id="park" class="feature" />
							<label for="park">Active Park Assist Button Feature</label>
						</div>
					</div>
					<div class="span5 offset4">
						<input type="checkbox" name="book" id="book" />
						<label for="book">I would like to book a test drive</label>
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
					$('input[type="submit"]').on('click', function() {
						$(this).hide();
					});

					<?php if ($_SESSION['bypass'] != 'bypass') { ?>
						var scenary = '<?php echo $choices->scenary ?>';

						$.ajax({
							type: "GET",
							url: "sync.php",
							data: {scene: scenary}
						}).fail(function() {
							console.log('Failed social upload');
						}).done(function() {
							$('#synchronising').hide();
							$('#features').fadeIn();
						});
					<?php } ?>
				});
			})(jQuery);
		</script>
	</body>
</html>