<body onload="checkFormOnLoad()">

<h1>Index</h1>

<form id="form-inscription" name="inscription" method="POST" action="birdy.php?action=register" enctype="multipart/form-data">
	<h3>Inscription</h3>
	<div id="login-form-element">
		<label>Pseudo</label>
		<input id="login" name="login" type="text/html" placeholder="Pseudo" onblur="checkLogin()" value="<?php echo $context->login; ?>">
		<div id="error-login" class="error-message"></div>
	</div>
	<div id="password-form-element">
		<label>Mot de passe</label>
		<input id="password" name="password" type="password" placeholder="Mot de passe" onblur="checkPassword()">
		<div id="error-password" class="error-message"></div>
	</div>
	<div id="name-form-element">
		<label>Identité</label>
		<input id="firstname" name="firstname" type="text/html" placeholder="Prénom" onblur="checkFirstname()" value="<?php echo $context->firstname; ?>">
		<input id="name" name="name" type="text/html" placeholder="Nom" onblur="checkName()" value="<?php echo $context->name; ?>">
		<div id="error-firstname" class="error-message"></div>
		<div id="error-name" class="error-message"></div>
	</div>
	<div id="avatar-form-element">
		<label>Avatar</label>
		<input id="max-file-size" name="max-file-size" type="hidden" value="1000000" />
		<input id="avatar" name="avatar" type="file">
		<div id="error-avatar" class="error-message"></div>
	</div>
	<div id="submit-element">
		<input id="submit-button" class="button" name="valider" value="Inscription" onclick="sendForm()" onkeypress="sendForm()">
	</div>
</form>

<script type="text/javascript" src="js/checkInscriptionForm.js"></script>
