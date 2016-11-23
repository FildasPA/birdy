<?php

//=============================================================================
// ▼ Post
// ----------------------------------------------------------------------------
//
//=============================================================================
class utilisateurTable
{
	//---------------------------------------------------------------------------
	// * Get user by login & pass
	//---------------------------------------------------------------------------
	public static function getUserByLoginAndPass($login,$pass)
	{
		$connection = new dbconnection();

		$sql = "SELECT *
		        FROM utilisateur
		        WHERE identifiant='" . $login . "' AND pass='" . sha1($pass) . "'";

		$res = $connection->doQueryObject($sql,"utilisateur");

		if($res === false || empty($res))
			return false;

		return $res;
	}

	//---------------------------------------------------------------------------
	// * Get user by login
	//---------------------------------------------------------------------------
	public static function getUserByLogin($login)
	{
		$connection = new dbconnection();

		$sql = "SELECT *
		        FROM utilisateur
		        WHERE identifiant='" . $login . "'";

		$res = $connection->doQueryObject($sql,"utilisateur");

		if($res === false || empty($res))
			return false;

		return $res;
	}

	//---------------------------------------------------------------------------
	// * Get user by id
	//---------------------------------------------------------------------------
	public static function getUserById($id)
	{
		$connection = new dbconnection();

		$sql = "SELECT *
		        FROM utilisateur
		        WHERE id='" . $id . "'";

		$res = $connection->doQueryObject($sql,"utilisateur");

		if($res === false || empty($res))
			return false;

		return $res;
	}

	//---------------------------------------------------------------------------
	// * Get users
	//---------------------------------------------------------------------------
	public static function getUsers()
	{
		$connection = new dbconnection();

		$sql = "SELECT *
		        FROM utilisateur";

		$res = $connection->doQuery($sql);

		if($res === false || empty($res))
			return false;

		return $res;
	}
}
