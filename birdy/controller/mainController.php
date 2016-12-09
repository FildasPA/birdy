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
	// * View tweets posted by a user
	//------------------------------------------------------------------------------
	private static function viewTweets($context,$userId)
	{
		$listTweets = tweetTable::getTweetsPostedBy($context->user->getId());

		if($listTweets === false) {
			$context->tweets = false;
			return;
		}
		$i = 0;
		$tweets = array();

		foreach($listTweets as $tweet) {
			$tweet = $tweet->getData();

			$tweets[$i] = array();
			$tweets[$i]['nbvotes']  = $tweet['nbvotes'];
			$tweets[$i]['emetteur'] = utilisateurTable::getUserById($tweet['emetteur'])[0];
			$tweets[$i]['parent']   = utilisateurTable::getUserById($tweet['parent'])[0];
			$tweets[$i]['post']     = postTable::getPostById($tweet['post'])[0];
			$tweets[$i]['date']     = new DateTime($tweets[$i]['post']->date);
			$tweets[$i]['date']     = $tweets[$i]['date']->format('d/m/Y');
			$i++;
		}

		$context->tweets = $tweets;
	}


	//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	// Non action -- FIN
	// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
	// Actions -- DEBUT
	//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

	//---------------------------------------------------------------------------
	// * Index
	//---------------------------------------------------------------------------
	public static function index($request,$context)
	{
		return context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * helloWorld
	// Nécessite d'être connecté
	//---------------------------------------------------------------------------
	public static function helloWorld($request,$context) {
		if(self::disconnectedError($context))
			return context::NONE;
		else
			return context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * Super Test
	//---------------------------------------------------------------------------
	public static function superTest($request,$context)
	{
		$context->par1 = $request['par1'];
		$context->par2 = $request['par2'];
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
				echo "true!";
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

		$context->user = $context->user[0];
		// Si c'est le compte de l'utilisateur, affiche un lien vers l'action modifier profil
		$context->isOwner = ($requestLogin == $context->getSessionAttribute('identifiant'));

		// Affiche les tweets
		self::viewTweets($context,$context->user->getId());

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
