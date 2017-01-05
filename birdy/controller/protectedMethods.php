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
		$tweet->post->date = new DateTime($tweet->post->date);
		$tweet->post->date = $tweet->post->date->format('d/m/Y');
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
}
