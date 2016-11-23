<?php

//=============================================================================
// ▼ Table tweet
// ----------------------------------------------------------------------------
//
//=============================================================================
class tweetTable
{
	//------------------------------------------------------------------------------
	// * Get Tweets
	//------------------------------------------------------------------------------
	public static function getTweets() {
		$connection = new dbconnection();

		$sql = "SELECT *
		        FROM tweet";

		$res = $connection->doQueryObject($sql,"tweet");

		if($res === false || empty($res))
			return false;

		return $res;
	}

	//------------------------------------------------------------------------------
	// * Get Tweets posted by a user
	//------------------------------------------------------------------------------
	public static function getTweetPostedBy($login)
	{
		$connection = new dbconnection();

		$sql = "SELECT *
		        FROM tweet
		        WHERE emetteur='" . $login . "'";

		$res = $connection->doQueryObject($sql,"tweet");

		if($res === false || empty($res))
			return false;

		return $res;
	}
}
