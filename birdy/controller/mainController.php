<?php

//=============================================================================
// ▼ Main Controller
// ----------------------------------------------------------------------------
//
//=============================================================================
class mainController
{
	//---------------------------------------------------------------------------
	// * Index
	//---------------------------------------------------------------------------
	public static function index($request,$context)
	{
		return context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * helloWorld
	//---------------------------------------------------------------------------
	public static function helloWorld($request,$context) {
		if(empty($context->getSessionAttribute('nom'))) {
			$context->setSessionAttribute('error-message','Erreur: vous devez être connecté!<br>');
			$context->redirect("birdy.php?action=login");
			// return context::ERROR;
		} else {
			return context::SUCCESS;
		}
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
				echo "C'est ok!<br>";
				// $context->redirect("birdy.php?action=index");
			} else {
				echo "Echec de l'inscription<br>";
				$context->login     = $request['login'];
				$context->name      = $request['name'];
				$context->firstname = $request['firstname'];
			}
		}
		else {
			$context->login     = '';
			$context->name      = '';
			$context->firstname = '';
		}
		return context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * View profile
	//---------------------------------------------------------------------------
	public static function viewProfile($request,$context) {
		$context->user = utilisateurTable::getUserByLogin($request['login'])[0];
		return context::SUCCESS;
	}

	//---------------------------------------------------------------------------
	// * Display users
	//---------------------------------------------------------------------------
	public static function displayUsers($request, $context) {
		$context->users = utilisateurTable::getUsers();
		if(count($context->users) <= 0) {
			echo "<p>Aucun utilisateur enregistré</p>";
			return context::NONE;
		}
		return context::SUCCESS;
	}

}
