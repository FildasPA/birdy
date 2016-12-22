<?php

//=============================================================================
// ▼ Affiche le menu de navigation (navMenu)
// ----------------------------------------------------------------------------
// Exécute l'action navMenu & inclut la vue.
//=============================================================================

$actionNav = "navMenu";

$viewNav = $context->executeAction($actionNav,$_REQUEST);

if($viewNav != context::NONE) {
	$template_viewNav = $nameApp."/view/".$viewNav.".php";
	include($template_viewNav);
}

?>
