<?php

//=============================================================================
// ▼ Base model
// ----------------------------------------------------------------------------
// La classe de base des classes "objets".
//=============================================================================
abstract class basemodel
{
	protected $data = array();

	//---------------------------------------------------------------------------
	// * Constructeur
	//---------------------------------------------------------------------------
	function __construct($tab = null) {
		if(!empty($tab))
			foreach($tab as $att => $value)
				$this->$att = $value;
	}

	//---------------------------------------------------------------------------
	// * Destructeur
	//---------------------------------------------------------------------------
	public function __destruct()
	{
		$this->data = null;
	}

	//---------------------------------------------------------------------------
	// * Get
	//---------------------------------------------------------------------------
	public function __get($key)
	{
		if(array_key_exists($key,$this->data))
			return $this->data[$key];
		else
			return null;
	}

	//---------------------------------------------------------------------------
	// * Set
	//---------------------------------------------------------------------------
	public function __set($key,$value)
	{
			$this->data[$key] = $value;
	}

	//---------------------------------------------------------------------------
	// * Data
	//---------------------------------------------------------------------------
	public function getData() {
		return $this->data;
	}

	//---------------------------------------------------------------------------
	// * Save
	//---------------------------------------------------------------------------
	public function save()
	{
		$connection = new dbconnection();

		// UPDATE
		if($this->id) {
			$sql  = "UPDATE jabaianb." . get_class($this) ." SET ";

			$set = array();
			foreach($this->data as $att => $value)
				if($att != 'id' && $value)
					$set[] = "$att = '" . $value . "'";

			$sql .= implode(",",$set);
			$sql .= " WHERE id=" . $this->id;
		}

		// INSERT
		else {
			$keys   = implode(",",array_keys($this->data));
			$values = implode("','",array_values($this->data));

			$sql  = "INSERT INTO jabaianb." . get_class($this) . " ";
			$sql .= "(" . $keys . ") ";
			$sql .= "VALUES ('" . $values ."')";
		}

		$connection->doExec($sql);

		if(!$this->id)
			$this->id = $connection->getLastInsertId(get_class($this));

		return $this->id === false ? NULL : $this->id;
	}
}
