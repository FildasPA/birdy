<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Birdy</title>
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
	<div id="main-container">
		<?php include($template_view); ?>
		<ul>
			<li><a href="birdy.php?action=index">Index</a></li>
			<li><a href="birdy.php?action=register">Inscription</a></li>
			<li><a href="birdy.php?action=login">Connexion</a></li>
			<li><a href="birdy.php?action=displayUsers">Liste utilisateur</a></li>
			<li><a href="birdy.php?action=superTest&par1=mdr&par2=lol">SuperTest</a></li>
			<li><a href="birdy.php?action=helloWorld">helloWorld</a></li>
			<li><a href="birdy.php?action=logout">Déconnexion</a></li>
		</ul>

	</div>
</body>
</html>
