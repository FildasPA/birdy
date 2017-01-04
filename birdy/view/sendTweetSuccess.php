<form id="form-send-tweet" name="send-tweet" method="POST" action="sendTweet" enctype="multipart/form-data">
	<h3>Poster un tweet</h3>
	<div id="wrap">
	<div id="text-form-element">
		<label>Texte du tweet</label>
		<textarea id="tweet-text" name="text" type="text/html" placeholder="Poster un tweet" maxlength="140" rows="5" cols="45" ></textarea>
		<div id="error-text" class="error-message"></div>
	</div>
	<div id="media-form-element">
		<label>Ajouter un media (<= 50 Mb)</label>
		<input id="max-file-size" name="max-file-size" type="hidden" value="52428800" />
		<input id="media" name="media" type="file">
		<div id="error-media" class="error-message"></div>
	</div>
	<div id="submit-element">
		<input type="submit" id="submit-button" name="valider" value="Poster">
	</div>
	</div>
</form>

<script type="text/javascript" src="js/submitForm.js"></script>
