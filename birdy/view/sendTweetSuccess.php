<form id="form-inscription" name="inscription" method="POST" action="birdyAjax.php?action=sendTweet" enctype="multipart/form-data">

<h3>Poster un tweet</h3>
	<div id="wrap">
	<div id="text-form-element">
		<label>Texte du tweet</label>
		<textarea id="tweetText" name="tweetText" type="text/html" maxlength="140"  rows="5" cols="45" placeholder="Poster un Tweet" onblur="checkLogin()" value="<?php echo $context->login; ?>"></textarea>
		<div id="error-login" class="error-message"></div>
	</div>
	<div id="avatar-form-element">
		<label>Ajouter un media <= 50 Mb</label>
		<input id="max-file-size" name="max-file-size" type="hidden" value="52428800" />
		<input id="avatar" name="avatar" type="file">
		<div id="error-avatar" class="error-message"></div>
	</div>
	<div id="submit-element">
		<input type="submit" id="submit-button" name="valider" value="Poster">
	</div>
	</div>
</form>