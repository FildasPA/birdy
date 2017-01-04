<?php

//=============================================================================
// ▼ Table utilisateur
// ----------------------------------------------------------------------------
//
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
	// * Copie l'avatar sur le serveur
	//---------------------------------------------------------------------------
	private static function copy_avatar($url,$dest_file)
	{
		$dest_dir  = dirname(dirname(dirname(__FILE__))) . "/images/avatars/";
		$dest_file = $dest_dir . $dest_file;
		if(copy($url,$dest_file)) {
			return true;
		}	else {
			echo "<p style='color:red;'>L'image n'a pas pu être ajoutée...</p>";
			return false;
		}
	}

	//---------------------------------------------------------------------------
  // * Register
  // Vérifie qu'aucun utilisateur existant ne possède l'identifiant souhaité,
  // puis enregistre l'utilisateur dans la table ainsi que son avatar (dans le
  // cas où une image a été envoyée).
  //---------------------------------------------------------------------------
  public static function register($request,$files)
  {
  	$user = new utilisateur();

  	$user->nom         = $request['name'];
  	$user->prenom      = $request['firstname'];
  	$user->identifiant = $request['login'];
  	$user->pass        = sha1($request['password']);

		// URL de l'image (serveur & upload)
		$avatar_url     = $files['avatar']['tmp_name'];
		$avatar_name    = $files['avatar']['name'];
		$image_type     = substr($avatar_name,strrpos($avatar_name,"."));

		$user->avatar = $user->identifiant . $image_type;

		echo "<pre><h3>Files</h3>"; var_dump($files); echo "</pre>";
		echo "<pre><h3>User</h3>"; var_dump($user); echo "</pre>";

		// return (utilisateurTable::getUserByLogin($user->identifiant) === false &&
		        // $user->save() != NULL &&
		        // copy_avatar($avatar_url,$user->avatar));
	}
}
