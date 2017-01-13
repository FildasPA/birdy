<!-- Formulaire d'envoi de tweet -->
<form id="form-send-tweet" name="send-tweet" method="POST" action="sendTweet" enctype="multipart/form-data">
	<h3>Poster un tweet</h3>
	<div id="wrap">
	<div id="text-form-element">
		<label>Texte du tweet</label>
		<textarea id="tweet-text" name="text" type="text/html" placeholder="Poster un tweet" maxlength="140" rows="2" cols="72" ></textarea>
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
<div style="height: 30px; width:100%"></div>

<!-- Informations utilisateur -->
<div id="user-profile">
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
