<?php

//=============================================================================
// ▼ Table Vote
// ----------------------------------------------------------------------------
//
//=============================================================================
class voteTable extends baseTable
{
	public static $objectType = "vote";
	public static $tableName  = "jabaianb.vote";

	//---------------------------------------------------------------------------
	// * Get post by user id and tweet id
	//---------------------------------------------------------------------------
	public static function getVoteByUserIdAndTweetId($userId,$tweetId)
	{
		$sql = "SELECT *
		        FROM " . self::$tableName . "
		        WHERE utilisateur='" . $userId . "' AND message='" . $tweetId . "'";

		return baseTable::getObject($sql,self::$objectType);
	}
}
