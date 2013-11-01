<?php
require('local_config.php');

session_start();
unset($_SESSION['uid']);
unset($_SESSION['bypass']);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<title>LINCOLN</title>
		<script type="text/javascript">
			function hideAddressBar() {
				if (document.documentElement.scrollHeight < window.outerHeight / window.devicePixelRatio)
					document.documentElement.style.height = (window.outerHeight / window.devicePixelRatio) + 'px';
				setTimeout(function() {window.scrollTo(1, 1);}, 0);
			}
			window.addEventListener("load", function() {
				hideAddressBar();
			});
			window.addEventListener("orientationchange", function() {
				hideAddressBar();
			});
		</script>
        <link href="src/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css"/>
        <link href="src/css/bootstrap-responsive.min.css" media="screen" rel="stylesheet" type="text/css"/>
        <link href="src/css/core.css" media="screen" rel="stylesheet" type="text/css"/>
        <link href="src/css/screen.css" media="screen" rel="stylesheet" type="text/css"/>
    </head>
    <body class="index">
        <div class="container">
            <div class="row">
                <div class="span3 offset3">
                    <a href="<?php echo FB_REGISTER_URL . "?start=true&server=" . SERVER_IP; ?>">
                        <img src="assets/img/btn-fb.png" />
                    </a>
                </div>
                <div class="span3">
                    <a href="<?php echo TWITTER_REGISTER_URL . "?start=true"; ?>">
                        <img src="assets/img/btn-twitter.png" />
                    </a>
                </div>
            </div>
        </div>
		<script src="src/js/jquery-1.10.2.min.js" type="text/javascript"></script>
		<script src="src/js/core.js" type="text/javascript"></script>
    </body>
</html>