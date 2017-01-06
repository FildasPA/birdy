<?php

//=============================================================================
// ▼ Table utilisateur
// ----------------------------------------------------------------------------
// Fonctions permettant d'enregistrer ou d'obtenir des informations
// d'utilisateurs.
//=============================================================================
class utilisateurTable extends baseTable
{
	public static $objectType = "utilisateur";
	public static $tableName  = "jabaianb.utilisateur";

	//---------------------------------------------------------------------------
	// * Get user by login & pass
	//---------------------------------------------------------------------------
	public static function getUserByLoginAndPass($login,$pass)
	{
		$sql = "SELECT *
		        FROM " . self::$tableName . "
		        WHERE identifiant='" . $login . "' AND pass='" . sha1($pass) . "'";

		return baseTable::getObject($sql,self::$objectType);
	}

	//---------------------------------------------------------------------------
	// * Get user by login
	//---------------------------------------------------------------------------
	public static function getUserByLogin($login)
	{
		$sql = "SELECT *
		        FROM " . self::$tableName . "
		        WHERE identifiant='" . $login . "'";

		return baseTable::getObject($sql,self::$objectType);
	}

	//---------------------------------------------------------------------------
	// * Get user by id
	//---------------------------------------------------------------------------
	public static function getUserById($id)
	{
		$sql = "SELECT *
		        FROM " . self::$tableName . "
		        WHERE id='" . $id . "'";

		return baseTable::getObject($sql,self::$objectType);
	}

	//---------------------------------------------------------------------------
	// * Get users
	//---------------------------------------------------------------------------
	public static function getUsers()
	{
		$sql = "SELECT *
		        FROM " . self::$tableName;

		return baseTable::getObject($sql,self::$objectType);
	}

	//---------------------------------------------------------------------------
	// * Register
	// Vérifie qu'aucun utilisateur existant ne possède l'identifiant souhaité,
	// puis enregistre l'utilisateur dans la table et enregistre son avatar (si
	// une image a été envoyée).
	//---------------------------------------------------------------------------
	public static function register($request,$avatarFile)
	{
		$user = new utilisateur();

		$user->nom         = $request['name'];
		$user->prenom      = $request['firstname'];
		$user->identifiant = $request['login'];
		$user->pass        = sha1($request['password']);

		if(utilisateurTable::getUserByLogin($user->identifiant) === false
		 &&
		   $user->save() !== NULL) {
			if(isset($avatarFile) && !empty($avatarFile))
				$user->uploadAvatar($avatarFile);
			return $user;
		}

		return false;
	}
}
