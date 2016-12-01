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
}
