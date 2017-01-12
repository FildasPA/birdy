<?php

//=============================================================================
// ▼ Table utilisateur
// ----------------------------------------------------------------------------
// Fonctions permettant d'enregistrer ou d'obtenir des informations
// d'utilisateurs.
//=============================================================================
class utilisateurTable extends baseTable
{
	public static $objectType, $tableName;

	//---------------------------------------------------------------------------
	// * Get user by login & pass
	//---------------------------------------------------------------------------
	public static function getUserByLoginAndPass($login,$pass)
	{
		$sql = "SELECT *
		        FROM " . self::$tableName . "
		        WHERE identifiant=:identifiant AND pass=:pass";

		$parameters = [[':identifiant',$login,PDO::PARAM_STR],
		               [':pass'       ,sha1($pass),PDO::PARAM_STR]];

		return baseTable::getObject($sql,$parameters,self::$objectType);
	}

	//---------------------------------------------------------------------------
	// * Get user by login
	//---------------------------------------------------------------------------
	public static function getUserByLogin($login)
	{
		$sql = "SELECT *
		        FROM " . self::$tableName . "
		        WHERE identifiant=:identifiant";

		$parameters = [[':identifiant',$login,PDO::PARAM_STR]];

		return baseTable::getObject($sql,$parameters,self::$objectType);
	}

	//---------------------------------------------------------------------------
	// * Get user by id
	//---------------------------------------------------------------------------
	public static function getUserById($id)
	{
		$sql = "SELECT *
		        FROM " . self::$tableName . "
		        WHERE id=:id";

		$parameters = [[':id',$id,PDO::PARAM_INT]];

		return baseTable::getObject($sql,$parameters,self::$objectType);
	}

	//---------------------------------------------------------------------------
	// * Get users
	//---------------------------------------------------------------------------
	public static function getUsers()
	{
		$sql = "SELECT *
		        FROM " . self::$tableName;

		$parameters = NULL;

		return baseTable::getObject($sql,$parameters,self::$objectType);
	}

	//---------------------------------------------------------------------------
	// * Register
	// Vérifie qu'aucun utilisateur existant ne possède l'identifiant souhaité,
	// puis enregistre l'utilisateur dans la table et enregistre son avatar (si
	// une image a été envoyée).
	// Renvoie un objet utilisateur si l'opération réussit, false sinon.
	//---------------------------------------------------------------------------
	public static function register($request,$files)
	{
		$user = new utilisateur();

		$user->nom         = $request['name'];
		$user->prenom      = $request['firstname'];
		$user->identifiant = $request['login'];
		$user->pass        = sha1($request['password']);

		if(utilisateurTable::getUserByLogin($user->identifiant) == true)
			return false;

		if(isset($files) && isset($files['avatar']) && $files['avatar'] !== NULL)
			if(!$user->uploadAvatarAndSave($files)) return false;
		else
			if(!$user->save()) return false;

		return $user;
	}
}

utilisateurTable::ini();
echo "<pre><h3>Utilisateur table</h3>"; var_dump(utilisateurTable::$tableName); echo "</pre>";
