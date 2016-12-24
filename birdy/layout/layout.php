<!doctype html>
<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>Birdy</title>
	  <link rel="stylesheet" href="css/main.css">
		<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="js/display_hide.js"></script>
		<script type="text/javascript" src="js/updateView.js"></script>
	</head>
	<body>
		<?php include("navMenu.php"); ?>
		<div id="alert-container"></div>
		<div id="container">
			<?php include($template_view); ?>
		</div>
	</body>
</html>
