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
	if(isset($context->tweets)) {
		foreach($context->tweets as $tweet) {
?>
<div class="tweet">
	<?php
		// Affiche qui a retweeté
		if($tweet->emetteur->getId() != $tweet->parent->getId()) {
	?>
	<div class="context">
		Retweeté par <a href=""><?php echo $tweet->emetteur->prenom . " " . $tweet->emetteur->nom; ?></a>
	</div>
	<?php
		}
	?>
	<div class="post">
		<div class="post-meta">
			<div class="author">
				<a href="birdy.php?action=viewProfile&login=<?php echo $tweet->parent->identifiant; ?>">
					<?php echo $tweet->parent->prenom . " " . $tweet->parent->nom ?>
				</a>
			</div>
			<div class="date"><?php echo $tweet->post->date; ?></div>
		</div>
		<?php
			if($tweet->post->texte != '') {  // Post
		?>
		<div class="post-text"><?php echo $tweet->post->texte; ?></div>
		<?php
			}
		?>
		<?php
			if($tweet->post->image != '') { // Image
		?>
		<div class="post-image"><img src="images/picture-post/<?php echo $tweet->post->image; ?>"></img></div>
		<?php
			}
		?>
		<div class="votes-number">
			<?php
				if($context->isUserLoged) {
					echo "<a ";
					if(!$context->haveUserVoted) {
						echo "title=\"Voter pour ce contenu\"";
					} else {
						echo "title=\"Annuler le vote\"";
					}
					echo ">";
				}
				echo "Voté " . $tweet->nbvotes . " fois";
				if($context->isUserLoged) {
					echo "</a>";
				}
			?>
		</div>
	</div>
</div>
<?php
		}
	}
?>
