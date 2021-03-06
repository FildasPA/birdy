<form id="form-inscription" name="inscription" method="POST" action="register" enctype="multipart/form-data">

<h3>Inscription</h3>
	<div id="wrap">
	<div id="login-form-element">
		<label>Pseudo</label>
		<input id="login" name="login" type="text/html" placeholder="Pseudo" onblur="checkLogin()" value="mdr">
		<div id="error-login" class="error-message"></div>
	</div>
	<div id="password-form-element">
		<label>Mot de passe</label>
		<input id="password" name="password" type="password" placeholder="Mot de passe" onblur="checkPassword()" value="123">
		<div id="error-password" class="error-message"></div>
	</div>
	<div id="name-form-element">
		<label>Identité</label>
		<input id="firstname" name="firstname" type="text/html" placeholder="Prénom" onblur="checkFirstname()" value="lol">
		<input id="name" name="name" type="text/html" placeholder="Nom" onblur="checkName()" value="xd">
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
		<input id="submit-button" class="button" type="submit" name="valider" value="Inscription">
	</div>
	</div>
</form>

<!-- <script type="text/javascript" src="js/checkInscriptionForm.js"></script> -->
<script type="text/javascript" src="js/submitForm.js"></script>

