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
			<img id="user-avatar-image" src="images/<?php echo $context->user->avatar; ?>">
		</div>
		<div class="info-element">
			<?php if($context->isOwner) { ?>
				<a href="birdy.php?action=modifyProfile&login=<?php echo $context->user->identifiant ?>">Modifier profil</a>
			<?php	}	?>
		</div>
	</div>
</div>


<!-- Liste des tweets postés -->

<?php
	foreach($context->tweets as $tweet) {
?>

<div id="tweet">
	<div id="tweet-block">
		<h3>Retweeté par <a href=""><?php echo $tweet['emetteur']->prenom; ?> <?php echo $tweet['emetteur']->nom; ?></a></h3>
		<div id="votes-number"><a href="" title="Voter pour ce contenu">Voté <?php echo $tweet['nbvotes']; ?> fois</a></div>
	</div>
	<div div="post-block">

		<?php if($tweet['post']->image !== '') { // Image
			?>
		<div id="post-image"><img src="images/<?php echo $tweet['post']->image; ?>"></img></div>
		<?php	} ?>

		<?php if($tweet['post']->texte !== '') {  // Post
			?>
		<div id="post-text"><?php echo $tweet['post']->texte; ?></div>
		<?php } ?>

		<div id="post-meta">
			<span id="author"><a href="birdy.php?action=viewProfile&login=<?php echo $tweet['parent']->identifiant; ?>"><?php echo $tweet['parent']->nom ?> <?php echo $tweet['parent']->prenom; ?></a></span>
			<span id="date"><?php echo $tweet['date']; ?></span>
		</div>
	</div>
</div>

<?php
	}
?>
