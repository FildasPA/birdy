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
			<?php if($context->isOwner == true) { ?>
				<a href="birdy.php?action=modifyProfile&login=Naruto42">Modifier profil</a>
			<?php	}	?>
		</div>
	</div>
</div>
