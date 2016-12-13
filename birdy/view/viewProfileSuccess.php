<!-- Informations utilisateur -->
<div id="user-profile">
	<h3>Profil de <?php echo $context->user->identifiant; ?></h3>
	<div id="user-info-block">
		<div class="info-element">
			<div class="info-label">Prénom:</div>
			<div id="user-firstname"><?php echo $context->user->prenom; ?></div>
		</div>
		<div class="info-element">
			<div class="info-label">Nom:</div>
			<div id="user-name"><?php echo $context->user->nom; ?></div>
		</div>
		<div class="info-element">
			<div class="info-label">Avatar:</div>
			<img id="user-avatar-image" src="images/avatars/<?php echo $context->user->avatar; ?>">
		</div>
		<div class="info-element">
			<?php if($context->isOwner) { ?>
				<a href="birdyAjax.php?action=modifyProfile&login=<?php echo $context->user->identifiant ?>">Modifier profil</a>
			<?php	}	?>
		</div>
	</div>
</div>


<!-- Liste des tweets postés -->
<?php
	if($context->tweets !== false) {
		foreach($context->tweets as $tweet) {
?>
<div class="tweet">
	<?php
		// Affiche qui a retweeté
		if($tweet->emetteur->id != $tweet->parent->id) {
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
				<a href="birdyAjax.php?action=viewProfile&login=<?php echo $tweet->parent->identifiant; ?>">
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
