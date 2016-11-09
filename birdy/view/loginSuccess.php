<form id="form-login" name="login" method="POST" action="birdy.php?action=login" enctype="multipart/form-data">
	<h3>Se connecter</h3>
	<div id="login-form-element">
		<label>Pseudo</label>
		<input name="login" type="text" placeholder="Pseudo" value="<?php echo $context->login; ?>">
	</div>
	<div id="password-form-element">
		<label>Mot de passe</label>
		<input name="password" type="password" placeholder="Password">
	</div>
	<div id="remember-form-element">
		<input type="checkbox" name="remember-me">
		<label>Rester connecté</label>
	</div>
	<input type="hidden" name="form-name" value="login">
	<div class="error-message"><?php echo $context->errorMessage; ?></div>
	<div id="submit-element">
		<input id="submit-button" class="button" type="submit" name="valider" value="Connexion">
	</div>
</form>
