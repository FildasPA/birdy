<?php

//=============================================================================
// ▼ Context
// ----------------------------------------------------------------------------
//
//=============================================================================
class context
{
	const SUCCESS = "Success";
	const ERROR   = "Error";
	const NONE    = "None";
	private $data;
	private $name;
	private static $instance = null;

	//---------------------------------------------------------------------------
	// * Get instance
	//---------------------------------------------------------------------------
	public static function getInstance()
	{
		if(self::$instance == null)
			self::$instance = new context();
		return self::$instance;
	}

	//---------------------------------------------------------------------------
	// * Constructeur
	//---------------------------------------------------------------------------
	private function __construct()
	{
	}

	//---------------------------------------------------------------------------
	// * Init
	//---------------------------------------------------------------------------
	public function init($name)
	{
		$this->name = $name;
		// $this->setSessionAttribute("alert-message","");
	}
	//---------------------------------------------------------------------------
	// * Get layout
	//---------------------------------------------------------------------------
	public function getLayout()
	{
		return $this->layout;
	}

	//---------------------------------------------------------------------------
	// * Set layout
	//---------------------------------------------------------------------------
	public function setLayout($layout)
	{
		$this->layout = $layout;
	}

	//---------------------------------------------------------------------------
	// * Redirect
	//---------------------------------------------------------------------------
	public function redirect($url)
	{
		header("location:".$url);
	}

	//---------------------------------------------------------------------------
	// * Execute action
	//---------------------------------------------------------------------------
	public function executeAction($action,$request)
	{
		$this->layout = "layout";
		if(!method_exists('mainController',$action))
			return false;
		return mainController::$action($request,$this);
	}

	//---------------------------------------------------------------------------
	// * Get session attribute
	//---------------------------------------------------------------------------
	public function getSessionAttribute($attribute)
	{
		if(!isset($_SESSION[$attribute])) return false;
		return $_SESSION[$attribute];
	}

	//---------------------------------------------------------------------------
	// * Set session attribute
	//---------------------------------------------------------------------------
	public function setSessionAttribute($attribute,$value)
	{
		$_SESSION[$attribute] = $value;
	}

	//---------------------------------------------------------------------------
	// * Unset session attributes
	//---------------------------------------------------------------------------
	public function unsetSession() {
		session_unset();
	}

	//---------------------------------------------------------------------------
	// * Get
	//---------------------------------------------------------------------------
	public function __get($prop)
	{
		if(!array_key_exists($prop,$this->data))
		   return NULL;
		return $this->data[$prop];
	}

	//---------------------------------------------------------------------------
	// * Set
	//---------------------------------------------------------------------------
	public function __set($prop,$value)
	{
		$this->data[$prop] = $value;
	}

	//---------------------------------------------------------------------------
	// * Get alert message
	// Supprime le message de la session avant de le renvoyer.
	//---------------------------------------------------------------------------
	public function getAlertMessage() {
		$alertMessage = $this->getSessionAttribute("alert-message");
		// echo "<pre><h3>alertMessage (context,1)</h3>"; var_dump($alertMessage); echo "</pre>";
		// $alertMessage = $alertMessage);
		// $this->setSessionAttribute("alert-message","");
		unset($_SESSION["alert-message"]);
		// echo "<pre><h3>alertMessage (context,2)</h3>"; var_dump($alertMessage); echo "</pre>";
		return $alertMessage;
	}

	//------------------------------------------------------------------------------
	// * Set success message
	//------------------------------------------------------------------------------
	public function setSuccessMessage($message) {
		$alertMessage = array("type"    => "success",
		                      "message" => $message);
		$this->setSessionAttribute("alert-message",$alertMessage);
	}

	//------------------------------------------------------------------------------
	// * Set warning message
	//------------------------------------------------------------------------------
	public function setWarningMessage($message) {
		$alertMessage = array("type"    => "warning",
		                      "message" => $message);
		$this->setSessionAttribute("alert-message",$alertMessage);
	}

	//------------------------------------------------------------------------------
	// * Set error message
	//------------------------------------------------------------------------------
	public function setErrorMessage($message) {
		$alertMessage = array("type"    => "error",
		                      "message" => $message);
		$this->setSessionAttribute("alert-message",$alertMessage);
	}
}
