<?php

include_once 'dbconnection.infos.php';

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
			// $this->link = new PDO("pgsql:host=".HOST.";dbname=".DB);
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
	// * Do exec
	//------------------------------------------------------------------------------
	public function doExec($sql)
	{
		$prepared = $this->link->prepare($sql);
		return $prepared->execute();
	}

	//------------------------------------------------------------------------------
	// * Do query
	//------------------------------------------------------------------------------
	public function doQuery($sql)
	{
		$prepared = $this->link->prepare($sql);
		$prepared->execute();
		$res = $prepared->fetchAll(PDO::FETCH_ASSOC);
		return $res;
	}

	//------------------------------------------------------------------------------
	// * Do query object
	//------------------------------------------------------------------------------
	public function doQueryObject($sql,$className)
	{
		$prepared = $this->link->prepare($sql);
		$prepared->execute();
		$res = $prepared->fetchAll(PDO::FETCH_CLASS,$className);
		return $res;
	}
}
