<?php

//=============================================================================
// ▼ Table post
// ----------------------------------------------------------------------------
//
//=============================================================================
class postTable extends baseTable
{
	public static $objectType = "post";
	public static $tableName  = "jabaianb.post";

	//---------------------------------------------------------------------------
	// * Get post by id
	//---------------------------------------------------------------------------
	public static function getPostById($id)
	{
		$sql = "SELECT *
		        FROM " . self::$tableName . "
		        WHERE id=:id";

		$parameters = [[':id',$id,PDO::PARAM_INT]];

		return baseTable::getObject($sql,$parameters,self::$objectType);
	}

	//---------------------------------------------------------------------------
	// * Send post
	// Insère le poste et retourne son id dans la table (ce qui permet de le
	// lier à un tweet).
	//---------------------------------------------------------------------------
	public static function send($text, $media)
	{
		$post = new post();

		$post->texte = $text;
		$post->image = $media;
		$post->date  = new DateTime();
		$post->date  = $post->date->format('Y-m-d H:i:s');

		return $post->save();
	}
}
