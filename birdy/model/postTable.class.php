<?php

class postTable extends basemodel {

	public static function getPostById($id) {

		$connection = new dbconnection();

		$sql = "SELECT *
		        FROM jabaianb.post
		        WHERE id='" . $id . "'";

		$res = $connection->doQueryObject($sql, "post");

		if($res === false || empty($res))
			return false;

		return $res;
	}
}


?>
