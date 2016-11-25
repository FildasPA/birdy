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
	public static function getObject($sql,$type)
	{
		$connection = new dbconnection();

		$res = $connection->doQueryObject($sql,$type);

		if($res === false || empty($res))
			return false;

		return $res;
	}
}
