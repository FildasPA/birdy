<?php

$nameApp = "birdy";
$action  = "index";  # action par défaut

if(key_exists("action",$_REQUEST))
	$action = $_REQUEST['action'];

require_once 'lib/core.php';
require_once $nameApp.'/controller/protectedMethods.php';
require_once $nameApp.'/controller/mainController.php';
session_start();

$context = context::getInstance();
$context->init($nameApp);

$view = $context->executeAction($action,$_REQUEST);

if($view === false) {
	echo "<p style=\"color:red;\">Erreur: l'action <b>" . $action . "</b> n'existe peut-être pas.</p>";
	die;
}
else if($view != context::NONE) {
	$template_view = $nameApp."/view/".$view.".php";
	include($nameApp."/layout/".$context->getLayout().".php");
}

?>
