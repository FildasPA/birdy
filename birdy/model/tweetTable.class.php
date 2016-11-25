<?php

//=============================================================================
// ▼ Table tweet
// ----------------------------------------------------------------------------
//
//=============================================================================
class tweetTable extends baseTable
{
	public static $tableName = "tweet";

	//---------------------------------------------------------------------------
	// * Get Tweets
	//---------------------------------------------------------------------------
	public static function getTweets()
	{
		$sql = "SELECT *
		        FROM " . self::$tableName;

		return baseTable::getObject($sql,self::$tableName);
	}

	//---------------------------------------------------------------------------
	// * Get Tweets posted by a user
	//---------------------------------------------------------------------------
	public static function getTweetPostedBy($login)
	{
		$sql = "SELECT *
		        FROM " . self::$tableName . "
		        WHERE emetteur='" . $login . "'";

		return baseTable::getObject($sql,self::$tableName);
	}
}
