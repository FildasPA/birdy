<?php

//=============================================================================
// ▼ Base Table
// ----------------------------------------------------------------------------
//
//=============================================================================
abstract class baseTable
{
	//---------------------------------------------------------------------------
	// * Execute SQL request & create appropriate object
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
