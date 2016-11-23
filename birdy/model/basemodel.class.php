<?php

abstract class basemodel
{
	protected $id;
	protected $data;

	//------------------------------------------------------------------------------
	// * Constructeur
	//------------------------------------------------------------------------------
	function __construct($tab = null) {
		if(isset($tab['id']))
			$id = $tab['id'];
		else
			$id = null;

		foreach($tab as $att => $value)
			if($att != 'id' && $value)
				$this->$att = $value;
	}

	//---------------------------------------------------------------------------
	// * Destructeur
	//---------------------------------------------------------------------------
	public function __destruct()
	{
		$this->id   = null;
		$this->data = null;
	}

	//---------------------------------------------------------------------------
	// * Get
	//---------------------------------------------------------------------------
	public function __get($key)
	{
		return $this->data[$key];
	}

	//---------------------------------------------------------------------------
	// * Set
	//---------------------------------------------------------------------------
	public function __set($key,$value)
	{
		$this->data[$key] = $value;
	}

	//---------------------------------------------------------------------------
	// * Save
	//---------------------------------------------------------------------------
	public function save()
	{
		$connection = new dbconnection();

		if(!empty($this->id)) {
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
		$id = $connection->getLastInsertId(get_class($this));

		return $id == false ? NULL : $id;
	}
}
