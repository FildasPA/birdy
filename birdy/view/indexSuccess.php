<h1>Index</h1>
<?php
	if(empty($context->getSessionAttribute('user')['nom'])) {
		echo "Bienvenue, invité!<br>";
	}	else {
		echo "Bienvenue " . $context->getSessionAttribute('user')['nom'] . " " . $context->getSessionAttribute('user')['prenom'] . "!<br>";
	}
?>
