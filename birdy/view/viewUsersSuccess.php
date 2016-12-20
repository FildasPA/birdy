<div id="content">
	<div id="wrap">
		<h1>Liste des utilisateurs</h1>
		<table style="margin: auto;">
			<tr>
				<th>Pseudo</th>
				<th>Nom</th>
				<th>Prénom</th>
			</tr>
		<?php
		foreach($context->users as $user) {
			echo "<tr class=\"user\" onclick=\"updateView('viewProfile&login=".$user->identifiant."','#container')\" title=\"Voir le profil de ".$user->identifiant."\">";
			echo "<td>".$user->identifiant."</td>";
			echo "<td>".$user->nom."</td>";
			echo "<td>".$user->prenom."</td>";
			echo "</tr>";
			echo "
";
		}
		?>
		</table>
	</div>
</div>
