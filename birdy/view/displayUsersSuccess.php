<h3>Liste des utilisateurs</h3>
<table>
	<tr>
		<th>Pseudo</th>
		<th>Nom</th>
		<th>Prénom</th>
	</tr>

<?php

foreach($context->users as $user) {
	echo "<tr class='user' onclick=\"window.document.location=birdy.php?action=viewProfile&login='".$user->identifiant."\">";
	echo "<td>".$user->identifiant."</td>";
	echo "<td>".$user->nom."</td>";
	echo "<td>".$user->prenom."</td>";
	echo "</tr>";
}

?>

</table>
