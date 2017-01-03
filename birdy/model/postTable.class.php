<?php

//=============================================================================
// ▼ Table Post
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
		        WHERE id='" . $id . "'";

		return baseTable::getObject($sql,self::$objectType);
	}


	public static function send($text, $media) {

		$post = new post();

		$post->texte = $text;
		$post->image = $media;

		var_dump($post); echo "<br>";

		return $post->save();
	}

}


?>
