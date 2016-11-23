<h1>Index</h1>
<?php
	if(empty($context->getSessionAttribute('nom'))) {
		echo "Bienvenue, invité!<br>";
	}	else {
		echo "Bienvenue " . $context->getSessionAttribute('prenom') . " " . $context->getSessionAttribute('nom') . "!<br>";
	}
?>
