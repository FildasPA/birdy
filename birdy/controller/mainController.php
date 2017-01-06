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
		// echo "<pre><h3>Session (index, controller, 1)</h3>"; var_dump($_SESSION); echo "</pre>";
		// echo "<pre><h3>Server</h3>"; var_dump($_SERVER); echo "</pre>";
		// echo "<pre><h3>Session (index, controller, 2)</h3>"; var_dump($_SESSION); echo "</pre>";

		return __FUNCTION__ . context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * View users
	//---------------------------------------------------------------------------
	public static function viewUsers($request, $context) {

		protectedMethods::updateAlertBox();

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

		// Informations à insérer dans le formulaire
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
			$user = utilisateurTable::register($request,$_FILES['avatar']);
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

		if(!$context->user->avatar) {
			$context->user->avatar = "images/default.jpg";
		}

		// Indique s'il s'agit du profil de l'utilisateur courant
		$context->isProfileOwner = ($requestLogin == $context->getSessionAttribute('identifiant'));

		// Récupère les tweets de l'utilisateur
		protectedMethods::getTweetsPostedBy($context,$context->user->id);

		return __FUNCTION__ . context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * Modify profile
	// Nécessite d'être connecté.
	//---------------------------------------------------------------------------
	public static function modifyProfile($request,$context)
	{
		if(protectedMethods::unconnectedError($context))
			return login($request,$context);

		$context->user = utilisateurTable::getUserByLogin($context->getSessionAttribute('identifiant'));

		if($context->user === false)
			return __FUNCTION__ . context::ERROR;

		$context->user = $context->user[0];

		$checkform = ($_SERVER["REQUEST_METHOD"] == "POST" && (!empty($request['old-password']) 
															|| !empty($request['firstname']) 
															|| !empty($request['name'])));

		if($checkform) {

			$error = protectedMethods::checkModifyProfileInfo($context, $request);
			if(!$error) {
				$context->user->prenom = $request['firstname'];
				$context->user->nom = $request['name'];
				$context->user->statut= $request['statut'];
			
				if(isset($_FILES['avatar']))
					$context->user->uploadAvatar($_FILES['avatar']);
				
				$context->user->save();
			}
		}

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
			$text  = $request['text'];
			$media = isset($request['media']) ? $request['media'] : NULL;
			$idUser = $context->getSessionAttribute('id');

			$idPost = postTable::send($text, $media);
			tweetTable::send($idUser, $idUser, intval($idPost));

			return self::viewProfile($request, $context);
		}

		return __FUNCTION__ . context::SUCCESS;
	}
}
