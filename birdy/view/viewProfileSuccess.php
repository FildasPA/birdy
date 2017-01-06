<!-- Informations utilisateur -->
<div id="user-profile">
	<h3>Profil de <?php echo $context->user->identifiant; ?> : <?php echo $context->user->statut; ?></h3>
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
			<img id="user-avatar-image" src="<?php echo $context->user->avatar; ?>">
		</div>
		<div class="info-element">
			<?php if($context->isProfileOwner) { ?>
				<a class="ajax-nav" href="modifyProfile">Modifier profil</a>
			<?php	}	?>
		</div>
	</div>
</div>
<!-- Liste des tweets postés -->
<?php
	if($context->tweets !== false) {
		foreach($context->tweets as $tweet) {
			include("viewTweetSuccess.php");
		}
	}
?>
