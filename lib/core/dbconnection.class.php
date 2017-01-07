<?php

include_once 'dbconnection.log.php';

class dbconnection
{
	private $link;
	private $error;

	//------------------------------------------------------------------------------
	// * Constructeur
	//------------------------------------------------------------------------------
	public function __construct()
	{
		$this->link  = null;
		$this->error = null;
		try {
			$this->link = new PDO("pgsql:host=".HOST.";dbname=".DB.";user=".USER.";password=".PASS);
		} catch(PDOException $e) {
			$this->error = $e->getMessage();
		}
	}

	//------------------------------------------------------------------------------
	// * Destructeur
	//------------------------------------------------------------------------------
	public function __destruct()
	{
		$this->link = null;
	}

	//------------------------------------------------------------------------------
	// * Get last insert id
	//------------------------------------------------------------------------------
	public function getLastInsertId($att)
	{
		return $this->link->lastInsertId($att."_id_seq");
	}

	//------------------------------------------------------------------------------
	// * Prepare request
	//------------------------------------------------------------------------------
	public function prepare($sql) {
		return $this->link->prepare($sql);
	}

	//------------------------------------------------------------------------------
	// * Do query object
	// Prépare la requête et lie les paramètres envoyés.
	// Construit et renvoie un ou plusieurs objet(s) de type className.
	//------------------------------------------------------------------------------
	public function doQueryObject($sql,$parameters,$className)
	{
		$prepared = $this->link->prepare($sql);
		if($parameters !== NULL && !empty($parameters)) {
			foreach($parameters as $parameter) {
				call_user_func_array(array($prepared,'bindValue'),$parameter);
			}
		}
		$prepared->execute();
		$res = $prepared->fetchAll(PDO::FETCH_CLASS,$className);
		return $res;
	}
}
