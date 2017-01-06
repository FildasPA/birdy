<?php

//=============================================================================
// ▼ Protected methods
// ----------------------------------------------------------------------------
// Méthodes protégées utilisées dans mainController.php (non-actions)
//=============================================================================
class protectedMethods {
	//---------------------------------------------------------------------------
	// * Is user loged
	//---------------------------------------------------------------------------
	public static function isUserLoged($context)
	{
		return (!empty($context->getSessionAttribute('nom')));
	}

	//------------------------------------------------------------------------------
	// * Log user
	// Enregistre l'utilisateur en session et le redirige vers l'index, tout en
	// mettant à jour le menu de navigation.
	//------------------------------------------------------------------------------
	public static function logUser($request,$context,$user)
	{
		foreach($user->getData() as $key => $value)
			$context->setSessionAttribute($key,$value);
		self::updateNavMenu();
		return mainController::index($request,$context);
	}

	//---------------------------------------------------------------------------
	// * Unconnected error
	// Si l'utilisateur n'est pas connecté, définit un message d'erreur et
	// renvoie faux.
	//---------------------------------------------------------------------------
	public static function unconnectedError($context)
	{
		if(!self::isUserLoged($context)) {
			$context->setErrorMessage("Erreur: vous devez être connecté pour effectuer cette action!");
			return true;
		}
		return false;
	}

	//------------------------------------------------------------------------------
	// * Update navMenu view
	// Appel en Javascript demandant une mise à jour du menu de navigation en AJAX.
	//------------------------------------------------------------------------------
	public static function updateNavMenu()
	{
		echo '<script>updateView("_navMenu","#nav-menu");</script>';
	}
	//------------------------------------------------------------------------------
	// * Update alertBox view
	// Appel en Javascript demandant une mise à jour des messages d'alerte en AJAX.
	//------------------------------------------------------------------------------
	public static function updateAlertBox()
	{
		echo '<script>updateView("_alertBox","#alert-container");</script>';
	}

	//------------------------------------------------------------------------------
	// * Get tweet data
	// Récupère les données (objets utilisateur, post, ...) associés au tweet.
	//------------------------------------------------------------------------------
	public static function getTweetData($tweet) {
		$tweet->parent     = $tweet->getParent();
		$tweet->emetteur   = $tweet->getSender();
		$tweet->post       = $tweet->getPost();
		if($tweet->post) {
			$tweet->post->date = new DateTime($tweet->post->date);
			$tweet->post->date = $tweet->post->date->format('d/m/Y');
		}
		return $tweet;
	}

	//------------------------------------------------------------------------------
	// * Get tweets posted by a user
	// Récupère les tweets postés par l'utilisateur et en rassemble toutes les
	// informations (post, utilisateur) (voir la fonction getTweetData).
	// Puis ajoute la liste de ces tweets à la variable contexte.
	//------------------------------------------------------------------------------
	public static function getTweetsPostedBy($context,$userId)
	{
		$listTweets = tweetTable::getTweetsPostedBy($context->user->id);

		if($listTweets === false) {
			$context->tweets = false;
			return;
		}

		$tweets = array();

		foreach($listTweets as $tweet)
			array_push($tweets,self::getTweetData($tweet));

		$context->tweets = $tweets;
	}

	//------------------------------------------------------------------------------
	// * Get server url
	//------------------------------------------------------------------------------
	public static function getServerUrl()
	{
		// Localhost
		if($_SERVER["SERVER_NAME"] == "localhost")
			return "http://" . $_SERVER["HTTP_HOST"] . "/Projets/birdy";
		// Serveur pedago
		else
			return $_SERVER["REQUEST_SCHEME"] . "://" .
			       $_SERVER["SERVER_NAME"] . $_SERVER["CONTEXT_PREFIX"];
	}

	//------------------------------------------------------------------------------
	// * Get server root
	//------------------------------------------------------------------------------
	public static function getServerRoot()
	{
		// Localhost
		if($_SERVER["SERVER_NAME"] == "localhost")
			return $_SERVER["DOCUMENT_ROOT"] . "/Projets/birdy";
		// Serveur pedago
		else
			return $_SERVER["CONTEXT_DOCUMENT_ROOT"];
	}

	//------------------------------------------------------------------------------
	// * Get file modification time
	//------------------------------------------------------------------------------
	public static function getFileModificationTime($fileUrl)
	{
		$file  = self::getServerRoot();
		$file .= substr($fileUrl,strlen(self::getServerUrl()));
		return filemtime($file);
	}

	//------------------------------------------------------------------------------
	// * Add modification time to user avatar url
	// Ajoute la date de dernière modification de l'avatar de l'utilisateur
	// après son url. Permet de rafraîchir l'image côté client après que le fichier
	// ait été modifié (après une modification de l'avatar notamment). En effet,
	// le nom du fichier ne change pas forcément (identifiant.imagetype), donc
	// l'image n'est pas systématiquement re-téléchargée en AJAX.
	//------------------------------------------------------------------------------
	public static function addModificationTimeToUserAvatarUrl($user) {
		if(!$user->avatar)
			$user->avatar = "images/default.jpg";
		else
			$user->avatar .= '?=' . self::getFileModificationTime($user->avatar);
	}

	//------------------------------------------------------------------------------
	// * Check modify profile info
	// Vérifie si les informations du formulaires sont correctement remplies.
	// Renvoie vrai si une erreur a été détectée. (peut-être faudrait-il inverser
	// ou modifier le nom de la fonction)
	//------------------------------------------------------------------------------
	public static function checkModifyProfileInfo($context, $request)
	{
		$error = false;
		if(empty($request['login'])) {
			$context->error_msg['login'] = "Ce champ doit être rempli";
			$error = true;
		}
		if(empty($request['name'])) {
			$context->error_msg['name'] = "Ce champ doit être rempli";
			$error = true;
		}
		if(empty($request['firstname'])) {
			$context->error_msg['firstname'] = "Ce champ doit être rempli";
			$error = true;
		}
		if(empty($request['old-password']) && !empty($request['password'])) {
			$context->error_msg['old-password'] = "Pour changer de mot de passe, veuillez indiquer votre mot de passe actuel";
			$error = true;
		}
		if(strlen($request['login']) > 15) {
			$context->error_msg['login'] = "Le login ne peut dépasser 15 caractères";
			$error = true;
		}
		if(strlen($request['name']) > 15) {
			$context->error_msg['name'] = "Le nom ne peut dépasser 15 caractères";
			$error = true;
		}
		if(strlen($request['firstname']) > 15) {
			$context->error_msg['firstname'] = "Le prénom ne peut dépasser 15 caractères";
			$error = true;
		}
		if(isset($request['password']) && strlen($request['password']) > 32) {
			$context->error_msg['old-password'] = "Le mot de passe ne peut dépasser 32 caractères";
			$error = true;
		}

		return $error;
	}
}
