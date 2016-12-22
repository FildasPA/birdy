<?php

//=============================================================================
// ▼ Base Table
// ----------------------------------------------------------------------------
//
//=============================================================================
abstract class baseTable
{
	//---------------------------------------------------------------------------
	// * Exécute la requête SQL & créer l'objet approprié
	//---------------------------------------------------------------------------
	public static function getObject($sql,$objectType)
	{
		$connection = new dbconnection();

		$res = $connection->doQueryObject($sql,$objectType);

		if($res === false || empty($res))
			return false;

		return $res;
	}
}
