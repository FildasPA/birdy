<?php

//=============================================================================
// ▼ Main Controller
// ----------------------------------------------------------------------------
// Actions de l'application.
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
	// * Unconnected error
	// Si l'utilisateur n'est pas connecté, redirige sur la page de connexion.
	//---------------------------------------------------------------------------
	private static function unconnectedError($context)
	{
		if(!self::isUserLoged($context)) {
			$context->setErrorMessage("Erreur: vous devez être connecté pour effectuer cette action!");
			// $context->redirect("birdy.php?action=login");
			return true;
		}

		return false;
	}

	//------------------------------------------------------------------------------
	// * Update navMenu view
	// Met à jour le menu de navigation en Javascript.
	// Permet à certaines actions de le mettre à jour de manière spécifique (par
	// exemple lors de la connexion, déconnexion, etc.)
	//------------------------------------------------------------------------------
	private static function updateNavMenu()
	{
		echo '<script>updateView("_navMenu","#nav-menu");</script>';
	}
	//------------------------------------------------------------------------------
	// * Update alertBox view
	// Met à jour les messages d'alerte en Javascript.
	//------------------------------------------------------------------------------
	private static function updateAlertBox()
	{
		echo '<script>updateView("_alertBox","#alert-container");</script>';
	}

	//------------------------------------------------------------------------------
	// * Get tweet data
	// Récupère les données (objets utilisateur, post, ...) associés au tweet.
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
	// * Get tweets posted by a user
	// Récupère les tweets postés par l'utilisateur et en rassemble toutes les
	// informations (post, utilisateur) (voir la fonction getTweetData).
	// Puis ajoute la liste de ces tweets à la variable contexte.
	//------------------------------------------------------------------------------
	private static function getTweetsPostedBy($context,$userId)
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

	//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	// Non action -- FIN
	// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
	// Actions -- DEBUT
	//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

	//---------------------------------------------------------------------------
	// * Nav Menu
	// Si l'utilisateur est authentifié, affiche son identifiant.
	//---------------------------------------------------------------------------
	public static function _navMenu($request,$context)
	{
		$context->identifiant = '';
		$context->isUserLoged = false;

		if(self::isUserLoged($context)) {
			$context->isUserLoged = true;
		}

		return __FUNCTION__ . context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * Alert box
	//---------------------------------------------------------------------------
	public static function _alertBox($request,$context)
	{
		// echo "<pre><h3>Session (controller, alertBox, 1)</h3>"; var_dump($_SESSION); echo "</pre>";
		// $_SESSION['alert-message'] = "";
		// echo "<pre><h3>Session (controller, alertBox, 2)</h3>"; var_dump($_SESSION); echo "</pre>";
		$context->alertMessage = $context->getAlertMessage();

		// echo "<pre><h3>alertMessage (controller, alertBox)</h3>"; var_dump($context->alertMessage); echo "</pre>";


		return __FUNCTION__ . context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * Index
	// TODO : afficher une liste de tweets aléatoires.
	//---------------------------------------------------------------------------
	public static function index($request,$context)
	{
		$context->setSessionAttribute("Message2","Message2");
		$context->setSuccessMessage("Liste des utilisateurs");
		// echo "<pre><h3>Session (index, controller, 1)</h3>"; var_dump($_SESSION); echo "</pre>";


		// echo "<pre><h3>Session (index, controller, 2)</h3>"; var_dump($_SESSION); echo "</pre>";

		return __FUNCTION__ . context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * View users
	//---------------------------------------------------------------------------
	public static function viewUsers($request, $context) {

		self::updateAlertBox();

		$context->users = utilisateurTable::getUsers();

		if(count($context->users) <= 0)
			return __FUNCTION__ . context::ERROR;

		return __FUNCTION__ . context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * Login - Formulaire de connexion
	// Si l'utilisateur existe, met à jour le menu de navigation et redirige
	// sur l'index.
	//---------------------------------------------------------------------------
	public static function login($request,$context)
	{
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
				// L'utilisateur n'existe pas : définit un message d'erreur
				$context->setErrorMessage("Erreur: login et/ou mot de passe erroné(s) !");
			else {
				// Connexion réussie : enregistre l'utilisateur en session
				foreach($user->getData() as $key => $value)
					$context->setSessionAttribute($key,$value);
				self::updateNavMenu();
				return self::index($request,$context);
			}
		}

		return __FUNCTION__ . context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * Logout
	// Supprime la session, met à jour le menu de navigation et redirige sur
	// l'index.
	//---------------------------------------------------------------------------
	public static function logout($request,$context) {
		$context->unsetSession();
		self::updateNavMenu();
		return self::index($request,$context);
	}

	//---------------------------------------------------------------------------
	// * Register
	//---------------------------------------------------------------------------
	public static function register($request,$context)
	{
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			$context->user = new utilisateur();
			if($context->user->register($request,$_FILES)) {
				return self::index($request,$context);
			} else {
				$context->setErrorMessage("Echec de l'inscription.");
				$context->login     = $request['login'];
				$context->name      = $request['name'];
				$context->firstname = $request['firstname'];
			}
		} else {
			$context->login     = '';
			$context->name      = '';
			$context->firstname = '';
		}
		return __FUNCTION__ . context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * View profile
	// Récupère les informations de l'utilisateurs ainsi que ses tweets.
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
				$context->setErrorMessage("Erreur: aucun login indiqué !");
				return __FUNCTION__ . context::ERROR;
			}
		}

		// Recupère les données de l'utilisateur
		$context->user = utilisateurTable::getUserByLogin($requestLogin);

		// Impossible de trouver l'utilisateur avec l'identifiant indiqué
		if($context->user === false) {
			$context->setErrorMessage("Erreur: Aucun utilisateur avec ce pseudo !");
			return __FUNCTION__ . context::ERROR;
		}

		// Liste des tweets
		$context->isUserLoged = self::isUserLoged($context);
		$context->haveUserVoted = true;
		$context->user = $context->user[0];
		// Si c'est le compte de l'utilisateur, affiche un lien vers l'action modifier profil
		$context->isOwner = ($requestLogin == $context->getSessionAttribute('identifiant'));

		// Récupère les tweets de l'utilisateur
		self::getTweetsPostedBy($context,$context->user->id);

		return __FUNCTION__ . context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * Modify profile
	// Nécessite d'être connecté.
	//---------------------------------------------------------------------------
	public static function modifyProfile($request,$context)
	{
		if(self::unconnectedError($context))
			return login($request,$context);;

		$context->user = utilisateurTable::getUserByLogin($context->getSessionAttribute('identifiant'));

		if($context->user === false)
			return __FUNCTION__ . context::ERROR;

		$context->user = $context->user[0];
		return __FUNCTION__ . context::SUCCESS;
	}
}
