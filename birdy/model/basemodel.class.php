<?php

abstract class basemodel
{
	//---------------------------------------------------------------------------
	// * Save
	//---------------------------------------------------------------------------
	public function save()
	{
		$connection = new dbconnection();

		if($this->id) {
			$sql  = "UPDATE " . get_class($this) ." SET ";

			$set = array();
			foreach($this->data as $att => $value)
				if($att != 'id' && $value)
					$set[] = "$att = '" . $value . "'";

			$sql .= implode(",",$set);
			$sql .= " WHERE id=" . $this->id;
		} else {
			$keys   = implode(",",array_keys($this->data));
			$values = implode("','",array_values($this->data));

			$sql  = "INSERT INTO " . get_class($this) . " ";
			$sql .= "(" . $keys . ") ";
			$sql .= "VALUES ('" . $values ."')";
		}

		$connection->doExec($sql);
		$id = $connection->getLastInsertId("jabaianb.".get_class($this));

		return $id == false ? NULL : $id;
	}
}
