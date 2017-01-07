<form id="form-modify-profile" name="modify-profile" method="POST" action="modifyProfile" enctype="multipart/form-data">
	<div id="user-profile">
		<h3>Profil de <?php echo $context->user->identifiant; ?> : <?php echo $context->user->statut; ?></h3>
		<div id="user-info-block">
			<div class="info-element">
				<div class="info-label">Login:</div>
				<div id="user-login">
					<input id="login" name="login" type="text/html" value="<?php echo $context->user->identifiant; ?>">
					<div id="error-login" class="error-message"><?php echo $context->errorMsg['identifiant']; ?></div>
				</div>
			</div>
			<div class="info-element">
				<div class="info-label">Modifier le statut:</div>
				<div id="user-statut">
					<input id="statut" name="statut" type="text/html" maxlength="40" placeholder="Nouveau statut">
					<div id="error-statut" class="error-message"><?php echo $context->errorMsg['statut']; ?></div>
				</div>
			<div class="info-element">
				<div class="info-label">Modifier le mot de passe:</div>
				<div id="user-login">
					<input id="password" name="old-password" type="password" placeholder="Ancien mot de passe" onblur="checkPassword()">
					<div id="error-password" class="error-message"><?php echo $context->errorMsg['old-password']; ?></div>
					<input id="password" name="new-password" type="password" placeholder="Nouveau mot de passe" onblur="checkPassword()">
					<div id="error-password" class="error-message"><?php echo $context->errorMsg['new-password']; ?></div>
				</div>
			</div>
			<div class="info-element">
				<div class="info-label">Prénom:</div>
				<div id="user-firstname">
					<input id="firstname" name="firstname" type="text/html" value="<?php echo $context->user->prenom; ?>">
					<div id="error-firstname" class="error-message"><?php echo $context->errorMsg['firstname']; ?></div>
				</div>
			</div>
			<div class="info-element">
				<div class="info-label">Nom:</div>
				<div id="user-name">
					<input id="name" name="name" type="text/html" value="<?php echo $context->user->nom; ?>">
					<div id="error-name" class="error-message"><?php echo $context->errorMsg['name']; ?></div>
				</div>
			</div>
			<div class="info-element" style="overflow:auto;">
				<div class="info-label">Avatar:</div>
				<img id="user-avatar-image" src="<?php echo $context->user->avatar; ?>" style="float:left;">
				<input id="max-file-size" name="max-file-size" type="hidden" value="10000000" />
				<input id="avatar" name="avatar" type="file" accept="image/x-png,image/gif,image/jpeg" style="float:left;margin-left: 15px;margin-top: 25px;">
				<div id="error-avatar" class="error-message"><?php echo $context->errorMsg['avatar']; ?></div>
			</div>
			<div id="submit-element">
				<input id="submit-button" class="button" name="valider" type="submit" value="Modifier profil">
			</div>
		</div>
	</div>
</form>

<script type="text/javascript" src="js/submitForm.js"></script>
