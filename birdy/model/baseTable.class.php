<?php

include_once($nameApp.'/model/_tables.infos.php');

//=============================================================================
// ▼ Base Table
// ----------------------------------------------------------------------------
// La classe de base des classes 'table'.
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

	//---------------------------------------------------------------------------
	// * Initialize
	// Définit le type d'objet et le nom de la table à utiliser dans la classe
	// dérivée.
	//---------------------------------------------------------------------------
	public static function ini()
	{
		static::$objectType = substr(get_called_class(),0,
		                             strrpos(get_called_class(),'Table'));
		static::$tableName  = SCHEMA . static::$objectType;
	}
}
