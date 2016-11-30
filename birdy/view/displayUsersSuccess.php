<?php
foreach($context->users as $key) {
	echo "<a href=birdy.php?action=viewProfile&login=".$key->identifiant.">".$key->identifiant . "</a><br>";
}
?>