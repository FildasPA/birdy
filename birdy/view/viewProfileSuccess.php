<!-- Informations utilisateur -->
<div id="user-profile">
	<input id="login" name="login" type="text/html" placeholder="Tweeter quelque chose !">
	<h3>@<?php echo $context->user->identifiant; ?> : <?php echo $context->user->statut; ?></h3>
	<div id="user-info-block">
		<div class="info-element">
			<div id="user-firstname"><?php echo $context->user->prenom; ?></div>
		</div>
		<div class="info-element">
			<div id="user-name"><?php echo $context->user->nom; ?></div>
		</div>
		<div class="info-element">
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
