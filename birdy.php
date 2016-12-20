<?php

$nameApp = "birdy";
$action  = "index";  # action par défaut

if(key_exists("action",$_REQUEST))
	$action = $_REQUEST['action'];

require_once 'lib/core.php';
require_once $nameApp.'/controller/mainController.php';
session_start();

$context = context::getInstance();
$context->init($nameApp);

$view = $context->executeAction($action,$_REQUEST);

if($view === false) {
	echo "Erreur: l'action " . $action . " n'existe peut-être pas";
	die;
}
else if($view != context::NONE) {
	$template_view = $nameApp."/view/".$view.".php";
	include($nameApp."/layout/".$context->getLayout().".php");
}

?>
