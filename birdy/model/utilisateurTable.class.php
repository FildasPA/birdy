<?php

//=============================================================================
// ▼ Table utilisateur
// ----------------------------------------------------------------------------
// Que veut dire le nom de cette classe?
// Pourquoi les fonctions sont-elles statiques? Pourquoi n'instancie-t-on pas
// la classe?
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

		$res = $connection->doQuery($sql);

		if($res === false || empty($rest))
			return false;

		return $res;
	}

	//---------------------------------------------------------------------------
	// * Get user id by login
	//---------------------------------------------------------------------------
	public static function getUserIdByLogin($login)
	{
		$connection = new dbconnection();

		$sql = "SELECT id
		        FROM utilisateur
		        WHERE identifiant='" . $login . "'";

		$res = $connection->doQuery($sql);

		if($res === false)
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

		$res = $connection->doQuery($sql);

		if($res === false)
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

		if($res === false)
			return false;

		return $res;
	}
}
