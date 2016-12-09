<?php

$actionNav = "navMenu";

$viewNav = $context->executeAction($actionNav,$_REQUEST);

if($viewNav != context::NONE) {
	$template_viewNav = $nameApp."/view/".$actionNav.$viewNav.".php";
	include($template_viewNav);
}

?>
