<?php

//=============================================================================
// ▼ Base Table
// ----------------------------------------------------------------------------
// La classe de base des classes "table"
//=============================================================================
abstract class baseTable
{
	//---------------------------------------------------------------------------
	// * Exécute la requête SQL et crée et renvoie l'objet approprié
	//---------------------------------------------------------------------------
	public static function getObject($sql,$parameters,$objectType)
	{
		$connection = new dbconnection();

		$res = $connection->doQueryObject($sql,$parameters,$objectType);

		if($res === false || empty($res))
			return false;

		return $res;
	}
}
