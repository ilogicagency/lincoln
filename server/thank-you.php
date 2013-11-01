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
			a{
				display: block;
				height: 400px;
			}

			a:hover{
				text-decoration: none;
			}
		</style>
    </head>
    <body class="thank-you">
        <div class="container">
			<div class="row">
				<a href="index.php">&nbsp;</a>
			</div>
        </div>
        <script src="src/js/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="src/js/core.js"></script>
        <script src="src/js/jquery.validationEngine-en.js"></script>
        <script src="src/js/jquery.validationEngine.js"></script>
        <script type="text/javascript">
			(function($) {
				$(document).ready(function() {
					setTimeout(function() {
						window.location = 'index.php';
					}, 20000);
				});
			})(jQuery);
        </script>
    </body>
</html>