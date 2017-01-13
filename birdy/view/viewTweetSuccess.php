<div class="tweet">
	<?php
		// Affiche qui a retweeté
		if($tweet->emetteur->id != $tweet->parent->id) {
	?>
	<div class="context">
		Retweeté par <a href="viewProfile&login="<?php echo $tweet->emetteur->identifiant;?>"><?php echo $tweet->emetteur->prenom . " " . $tweet->emetteur->nom; ?></a>
	</div>
	<?php } ?>

	<div class="post">
		<div class="post-meta">
			<div class="author">
				<a class="ajax-nav" href="viewProfile&login=<?php echo $tweet->parent->identifiant; ?>">
					<?php echo $tweet->parent->prenom . " " . $tweet->parent->nom ?>
				</a>
			</div>
			<div class="date"><?php echo $tweet->post->date; ?></div>
		</div>
		<?php
			if($tweet->post->texte != '') {  // Post
		?>
		<div class="post-text"><?php echo protectedMethods::testInput($tweet->post->texte); ?></div>
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
		<div class="retweet">
			<a class="ajax-nav" href="reTweet&postId=<?php echo $tweet->post->id . "&parentId=" . $tweet->parent->id;?>">Re-Tweeter!</a>
		</div>
	</div>
</div>
