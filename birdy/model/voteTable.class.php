<?php

//=============================================================================
// ▼ Table Vote
// ----------------------------------------------------------------------------
//
//=============================================================================
class voteTable extends baseTable
{
	public static $objectType, $tableName;

	//---------------------------------------------------------------------------
	// * Get post by user id and tweet id
	//---------------------------------------------------------------------------
	public static function getVoteByUserIdAndTweetId($userId,$tweetId)
	{
		$sql = "SELECT *
		        FROM " . self::$tableName . "
		        WHERE utilisateur=':userId' AND message=':tweetId'";

		$parameters = [[":userId" ,$id,PDO::PARAM_INT],
		               [":tweetId",$id,PDO::PARAM_INT]];

		return baseTable::getObject($sql,$parameters,self::$objectType);
	}
}

voteTable::ini();
