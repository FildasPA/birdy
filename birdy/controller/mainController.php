<?php

//=============================================================================
// ▼ Main Controller
// ----------------------------------------------------------------------------
// Actions de l'application.
//=============================================================================
class mainController
{
	//---------------------------------------------------------------------------
	// * Nav Menu
	// Si l'utilisateur est authentifié, affiche son identifiant.
	//---------------------------------------------------------------------------
	public static function _navMenu($request,$context)
	{
		$context->identifiant = '';
		$context->isUserLoged = false;

		if(protectedMethods::isUserLoged($context)) {
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

		if(protectedMethods::isUserLoged($context)) {
			$listTweets = tweetTable::getTweetsOrderedByIdNotId(10,0,$context->getSessionAttribute('id'));
		}
		else {
			$listTweets = tweetTable::getTweetsOrderedById(10,0);
		}

		protectedMethods::getTweetsData($context,$listTweets);

		// echo "<pre><h3>Tweets</h3>"; var_dump($context->tweets); echo "</pre>";

		// echo "<pre><h3>Session (index, controller, 1)</h3>"; var_dump($_SESSION); echo "</pre>";
		// echo "<pre><h3>Server</h3>"; var_dump($_SERVER); echo "</pre>";
		// echo "<pre><h3>Session (index, controller, 2)</h3>"; var_dump($_SESSION); echo "</pre>";

		return __FUNCTION__ . context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * View users
	//---------------------------------------------------------------------------
	public static function viewUsers($request, $context)
	{
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
				// Connexion réussie
				return protectedMethods::logUser($request,$context,$user);
			}
		}

		// Informations à ré-insérer dans le formulaire
		if(isset($request['login'])) $context->login = $request['login'];
		else $context->login = "";

		return __FUNCTION__ . context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * Logout
	// Supprime la session, met à jour le menu de navigation et redirige sur
	// l'index.
	//---------------------------------------------------------------------------
	public static function logout($request,$context) {
		$context->unsetSession();
		protectedMethods::updateNavMenu();
		return self::index($request,$context);
	}

	//---------------------------------------------------------------------------
	// * Register
	// Vérifie si le formulaire a été envoyé.
	// Si c'est le cas, essaie d'enregistrer l'utilisateur.
	// Si l'opération réussit, le connecte automatiquement.
	//---------------------------------------------------------------------------
	public static function register($request,$context)
	{
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			$request['login']     = protectedMethods::testInput($request['login']);
			$request['name']      = protectedMethods::testInput($request['name']);
			$request['firstname'] = protectedMethods::testInput($request['firstname']);
			$request['password']  = protectedMethods::testInput($request['password']);

			$user = utilisateurTable::register($request,$_FILES);
			echo "<pre><h3>User</h3>"; var_dump($user); echo "</pre>";
			if($user !== false)
				return protectedMethods::logUser($request,$context,$user);
			else {
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
		// Si aucun login n'est indiqué, prend celui de l'utilisateur
		// S'il n'est pas connecté, renvoie une erreur
		if(!empty($request['login']))
			$requestLogin = $request['login'];
		else {
			if(protectedMethods::isUserLoged($context))
				$requestLogin = $context->getSessionAttribute('identifiant');
			else {
				$context->setErrorMessage("Erreur: aucun login indiqué !");
				return __FUNCTION__ . context::ERROR;
			}
		}

		// Recupère les données de l'utilisateur
		$context->user = utilisateurTable::getUserByLogin($requestLogin);

		// Si aucun utilisateur n'est identifié, renvoie une erreur
		if($context->user === false) {
			$context->setErrorMessage("Erreur: Aucun utilisateur avec ce pseudo !");
			return __FUNCTION__ . context::ERROR;
		}

		$context->user = $context->user[0];

		protectedMethods::addModificationTimeToUserAvatarUrl($context->user);

		// Indique s'il s'agit du profil de l'utilisateur courant
		$context->isProfileOwner = ($requestLogin == $context->getSessionAttribute('identifiant'));

		// Récupère les tweets de l'utilisateur
		protectedMethods::getTweetsPostedBy($context,$context->user->id);

		return __FUNCTION__ . context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * Modify profile
	// Nécessite d'être connecté.
	// Si les informations envoyées sont valides, met à jour l'utilisateur dans
	// la base et dans $context.
	//---------------------------------------------------------------------------
	public static function modifyProfile($request,$context)
	{
		if(protectedMethods::unconnectedError($context))
			return login($request,$context);

		$context->user = utilisateurTable::getUserByLogin($context->getSessionAttribute('identifiant'));

		if($context->user === false)
			return __FUNCTION__ . context::ERROR;

		$context->user = $context->user[0];

		$checkForm = ($_SERVER["REQUEST_METHOD"] == "POST" &&
		              !protectedMethods::checkModifyProfileInfos($context,$request));

		if($checkForm) {
			$user = clone($context->user);

			// TODO : Mettre les informations invalides dans $context?
			$user->identifiant = $request['login'];
			$user->nom         = $request['name'];
			$user->prenom      = $request['firstname'];
			$user->statut      = $request['statut'];

			if(isset($_FILES['avatar']))
				$saveSuccess = $user->uploadAvatarAndSave($_FILES);
			else
				$saveSuccess = $user->save();

			if($saveSuccess) {
				$context->user = $user;
				protectedMethods::logUser($request,$context,$user);
				protectedMethods::updateNavMenu();
				unset($request['login']);
				return self::viewProfile($request,$context);
			}
		}

		protectedMethods::addModificationTimeToUserAvatarUrl($context->user);

		return __FUNCTION__ . context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * Send tweet
	// Nécessite d'être connecté.
	// Ajoute un poste et l'associe à un tweet.
	//---------------------------------------------------------------------------
	public static function sendTweet($request, $context)
	{
		if(protectedMethods::unconnectedError($context))
			return login($request, $context);

		$checkForm = ($_SERVER["REQUEST_METHOD"] == "POST" &&
		              !empty($request['text']));

		if($checkForm) {
			$text  = protectedMethods::testInput($request['text']);
			$media = isset($request['media']) ? $request['media'] : NULL;
			$idUser = $context->getSessionAttribute('id');

			$idPost = postTable::send($text, $media);
			tweetTable::send($idUser, $idUser, intval($idPost));

			return self::viewProfile($request, $context);
		}

		return __FUNCTION__ . context::SUCCESS;
	}

	//------------------------------------------------------------------------------
	// * Add tweet
	//------------------------------------------------------------------------------
	public static function addMostRecentTweets($request, $context)
	{
		// echo "<pre><h3>Tweets</h3>"; var_dump($tweets); echo "</pre>";
		$lastTweetId = $request['lastTweetId'];

		if(protectedMethods::isUserLoged($context)) {
			$tweets = tweetTable::getTweetsOrderedByIdNotId(10,$lastTweetId,$context->getSessionAttribute('id'));
		}
		else {
			$tweets = tweetTable::getTweetsOrderedById(10,$lastTweetId);
		}


		// echo "<pre><h3>Tweets</h3>"; var_dump($tweets); echo "</pre>";

		if(!$tweets) return __FUNCTION__ . context::NONE;

		$context->tweets = $tweets;
		return self::viewTweetsSuccess($request,$context);
	}
	//------------------------------------------------------------------------------
	// * Add tweet
	//------------------------------------------------------------------------------
	public static function addOlderTweets($request, $context)
	{

	}

	//------------------------------------------------------------------------------
	// * Add tweet
	//------------------------------------------------------------------------------
	public static function addMostRecentTweetsPostedBy($request, $context)
	{

	}
	//------------------------------------------------------------------------------
	// * Add tweet
	//------------------------------------------------------------------------------
	public static function addOlderTweetsPostedBy($request, $context)
	{

	}

}
