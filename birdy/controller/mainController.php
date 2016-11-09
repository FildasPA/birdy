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
		echo "<pre>";
		echo "<h3>Session</h3>";
		var_dump($_SESSION);
		echo "</pre>";
		if($context->getSessionAttribute("id") == null) {
			global $context;
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
			$context->user = utilisateurTable::getUserByLoginAndPass($request['login'],$request['password']);

			if($context->user === false)
				// Définit un message d'erreur à afficher sur la page suivante ou la page actuelle
				$context->errorMessage = "Erreur: login et/ou mot de passe erroné(s) !";
			else {
				// Connexion réussie: enregistre l'utilisateur en session &
				// réinitialise le message d'erreur
				foreach($context->user[0] as $key => $value)
					$context->setSessionAttribute($key,$value);
				$context->setSessionAttribute('error-message','');
				$context->redirect("birdy.php?action=index");
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
	}
}
