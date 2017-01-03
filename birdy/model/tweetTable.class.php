<?php

//=============================================================================
// ▼ Table tweet
// ----------------------------------------------------------------------------
//
//=============================================================================
class tweetTable extends baseTable
{
	public static $objectType = "tweet";
	public static $tableName  = "jabaianb.tweet";

	//---------------------------------------------------------------------------
	// * Get Tweets
	//---------------------------------------------------------------------------
	public static function getTweets()
	{
		$sql = "SELECT *
		        FROM " . self::$tableName;

		return baseTable::getObject($sql,self::$objectType);
	}

	//---------------------------------------------------------------------------
	// * Get Tweets posted by a user
	//---------------------------------------------------------------------------
	public static function getTweetsPostedBy($id)
	{
		$sql = "SELECT *
		        FROM " . self::$tableName . "
		        WHERE emetteur='" . $id . "'";

		return baseTable::getObject($sql,self::$objectType);
	}

	//---------------------------------------------------------------------------
	// * Send tweet
	// Ajoute un tweet dans la table.
	//---------------------------------------------------------------------------
	public static function send($senderId, $parentId, $postId)
	{
		$tweet = new tweet();

		$tweet->emetteur = $senderId;
		$tweet->parent   = $parentId;
		$tweet->post     = $postId;
		$tweet->nbVotes  = 0;

		$tweet->save();
	}
}
