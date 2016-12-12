<?php

//=============================================================================
// ▼ Main Controller
// ----------------------------------------------------------------------------
// Actions.
//=============================================================================
class mainController
{
	//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	// Non actions -- DEBUT
	//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

	//---------------------------------------------------------------------------
	// * Is user loged
	//---------------------------------------------------------------------------
	private static function isUserLoged($context)
	{
		return (!empty($context->getSessionAttribute('nom')));
	}

	//---------------------------------------------------------------------------
	// * Disconnected error
	// Si l'utilisateur n'est pas connecté, redirige sur la page de connexion.
	//---------------------------------------------------------------------------
	private static function disconnectedError($context)
	{
		if(!self::isUserLoged($context)) {
			$context->setSessionAttribute('error-message',
			  'Erreur: vous devez être connecté pour effectuer cette action!<br>');
			$context->redirect("birdy.php?action=login");
			return true;
		}

		return false;
	}

	//------------------------------------------------------------------------------
	// * Get tweet data
	//------------------------------------------------------------------------------
	private static function getTweetData($tweet) {
		$tweet->parent     = $tweet->getParent();
		$tweet->emetteur   = $tweet->getSender();
		$tweet->post       = $tweet->getPost();
		$tweet->post->date = new DateTime($tweet->post->date);
		$tweet->post->date = $tweet->post->date->format('d/m/Y');
		return $tweet;
	}

	//------------------------------------------------------------------------------
	// * View tweets posted by a user
	//------------------------------------------------------------------------------
	private static function getTweetsPostedBy($context,$userId)
	{
		$listTweets = tweetTable::getTweetsPostedBy($context->user->getId());

		if($listTweets === false) {
			$context->tweets = false;
			return;
		}

		$tweets = array();

		foreach($listTweets as $tweet)
			array_push($tweets,self::getTweetData($tweet));

		$context->tweets = $tweets;
	}


	//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	// Non action -- FIN
	// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
	// Actions -- DEBUT
	//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

	//---------------------------------------------------------------------------
	// * Nav Menu
	// Si l'utilisateur est authentifié, affiche son identifiant.
	//---------------------------------------------------------------------------
	public static function navMenu($request,$context)
	{
		$context->identifiant = '';
		$context->isUserLoged = false;

		if(self::isUserLoged($context)) {
			$context->isUserLoged = true;
			// $context->identifiant = $context->getSessionAttribute('identifiant');
		}

		return context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * Index
	//---------------------------------------------------------------------------
	public static function index($request,$context)
	{
		return context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * Display users
	//---------------------------------------------------------------------------
	public static function displayUsers($request, $context) {
		$context->users = utilisateurTable::getUsers();

		if(count($context->users) <= 0)
			return context::ERROR;

		return context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * Login - Formulaire de connexion
	//---------------------------------------------------------------------------
	public static function login($request,$context)
	{
		// Informations à afficher sur la page
		if($context->getSessionAttribute('error-message'))
			$context->errorMessage = $context->getSessionAttribute('error-message');
		else $context->errorMessage = '';

		// Informations à insérer dans le formulaire
		if(isset($request['login'])) $context->login = $request['login'];
		else $context->login = "";

		// Vérifie si le formulaire a été envoyé
		$formSent = ($_SERVER['REQUEST_METHOD'] == "POST" &&
		             !empty($request['login']) && !empty($request['password']));

		// Traitement du formulaire
		if($formSent) {
			$user = utilisateurTable::getUserByLoginAndPass($request['login'],$request['password'])[0];
			if(empty($user) || $user === false)
				// Définit un message d'erreur à afficher sur la page suivante ou la page actuelle
				$context->errorMessage = "Erreur: login et/ou mot de passe erroné(s) !";
			else {
				// Connexion réussie: enregistre l'utilisateur en session &
				// réinitialise le message d'erreur
				foreach($user->getData() as $key => $value)
					$context->setSessionAttribute($key,$value);
				$context->setSessionAttribute('error-message','');
				$context->redirect("birdy.php?action=viewProfile&login=".$request['login']);
			}
		}
		// Si le formulaire n'a pas été envoyé, réinitialise le message d'erreur
		else {
			$context->setSessionAttribute('error-message','');
		}
		return context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * Logout
	//---------------------------------------------------------------------------
	public static function logout($request,$context) {
		$context->unsetSession();
		$context->redirect("birdy.php?action=index");
		return context::NONE;
	}

	//---------------------------------------------------------------------------
	// * Register
	//---------------------------------------------------------------------------
	public static function register($request,$context)
	{
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			$context->user = new utilisateur();
			if($context->user->register($request,$_FILES)) {
				$context->redirect("birdy.php?action=index");
			} else {
				echo "Echec de l'inscription<br>";
				$context->login     = $request['login'];
				$context->name      = $request['name'];
				$context->firstname = $request['firstname'];
			}
		} else {
			$context->login     = '';
			$context->name      = '';
			$context->firstname = '';
		}
		return context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * View profile
	//---------------------------------------------------------------------------
	public static function viewProfile($request,$context)
	{
		// Login de l'utilisateur (défaut), ou erreur pas de login
		if(!empty($request['login']))
			$requestLogin = $request['login'];
		else {
			if(self::isUserLoged($context)) {
				$requestLogin = $context->getSessionAttribute('identifiant');
			}
			else {
				$context->errorMessage = "Erreur: Veuillez indiquer un login !";
				return context::ERROR;
			}
		}

		// Requête
		$context->user = utilisateurTable::getUserByLogin($requestLogin);

		// Impossible de trouver l'utilisateur avec l'identifiant indiqué
		if($context->user === false) {
			$context->errorMessage = "Erreur: Aucun utilisateur avec ce pseudo !";
			return context::ERROR;
		}

		// Liste des tweets

		$context->isUserLoged = self::isUserLoged($context);
		// $context->alertMessage = "Le tweet a bien été envoyé.";
		$context->haveUserVoted = true;
		$context->user = $context->user[0];
		// Si c'est le compte de l'utilisateur, affiche un lien vers l'action modifier profil
		$context->isOwner = ($requestLogin == $context->getSessionAttribute('identifiant'));

		// Affiche les tweets
		self::getTweetsPostedBy($context,$context->user->getId());

		return context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * Modify profile
	// Nécessite d'être connecté
	//---------------------------------------------------------------------------
	public static function modifyProfile($request,$context)
	{
		if(self::disconnectedError($context))
			return context::NONE;

		$context->user = utilisateurTable::getUserByLogin($context->getSessionAttribute('identifiant'));

		if($context->user === false)
			return context::ERROR;

		$context->user = $context->user[0];
		return context::SUCCESS;
	}
}
