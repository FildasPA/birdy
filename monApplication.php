<?php

$nameApp = "monApplication";
$action = "index";

if(key_exists("action",$_REQUEST))
	$action = $_REQUEST['action'];

require_once 'lib/core.php';
require_once $nameApp.'/controller/mainController.php';
session_start();

$context = context::getInstance();
$context->init($nameApp);

$view = $context->executeAction($action,$_REQUEST);

// Traitement des erreurs de bases, reste a traiter les erreurs d'inclusion
if($view === false) {
	echo "Une erreur s'est produite, il est probable que l'action " . $action . " n'existe pas...";
	die;
}
// Inclusion du layout qui va lui meme inclure le template view
else if($view != context::NONE) {
	$template_view = $nameApp."/view/".$action.$view.".php";
	include($nameApp."/layout/".$context->getLayout().".php");
}

?>
