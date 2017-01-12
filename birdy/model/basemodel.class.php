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
		if($this->id !== NULL) {
			$set = array();
			foreach($this->data as $key => $value)
				$set[] = "$key = :" . $key;

			$sql  = "UPDATE " . SCHEMA . get_class($this) ." SET ";
			$sql .= implode(",",$set);
			$sql .= " WHERE id=:id";
		}
		// INSERT
		else {
			$keys       = implode(",",array_keys($this->data));
			$parameters = implode(",:",array_keys($this->data));

			$sql  = "INSERT INTO " . SCHEMA . get_class($this) . " ";
			$sql .= "(" . $keys . ") ";
			$sql .= "VALUES (:" . $parameters . ")";
		}

		$parameters = array();
		foreach($this->data as $key => $value)
				$parameters[':'.$key] = $value;

		// echo "<pre><h3>SQL</h3>"; var_dump($sql); echo "</pre>";
		// echo "<pre><h3>Parameters</h3>"; var_dump($parameters); echo "</pre>";

		$prepared = $connection->prepare($sql);
		$prepared->execute($parameters);

		if(!$this->id)
			$this->id = $connection->getLastInsertId(SCHEMA.get_class($this));

		return $this->id === false ? NULL : $this->id;
	}
}
