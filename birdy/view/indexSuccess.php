<div id="content">
	<div id="wrap">
		<h1>Index</h1>
		<?php
			if(empty($context->getSessionAttribute('nom')))
				echo "Bienvenue, invité!<br>";
			else
				echo "Bienvenue, " . $context->getSessionAttribute('prenom') . " !<br>";
		?>
	</div>
</div>
<!-- Liste des tweets -->
<?php
	if($context->tweets !== false) {
		foreach($context->tweets as $tweet) {
			include("viewTweetSuccess.php");
		}
	}
?>
