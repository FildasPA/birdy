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

		if(isset($files) && isset($files['avatar']))
			$user->avatar = self::uploadAvatar($files['avatar'],$user->identifiant);

		if(utilisateurTable::getUserByLogin($user->identifiant) === false &&
		   $user->save())
			return $user;

		return false;
	}

	//------------------------------------------------------------------------------
	// * Upload avatar
	//------------------------------------------------------------------------------
	public static function uploadAvatar($file,$userLogin) {
		$avatar_tmp  = $file['tmp_name'];
		$avatar_name = $file['name'];
		$image_type  = substr($avatar_name,strrpos($avatar_name,"."));
		$avatar_url  = $_SERVER["DOCUMENT_ROOT"] . "/Projets/birdy/images/avatars/";
		$avatar_url .= $userLogin . $image_type;

		// Pour le serveur pedago (peu importe la session utilisateur) :
		// $avatar  = $_SERVER["REQUEST_SCHEME"] . $_SERVER["SERVER_NAME"] . $_SERVER["CONTEXT_PREFIX"];
		// Localhost :
		$avatar  = "http://" . $_SERVER["HTTP_HOST"] . "/Projets/birdy";

		$avatar .= "/images/avatars/" . $userLogin . $image_type;

		move_uploaded_file($avatar_tmp,$avatar_url);

		return $avatar;
	}
}
