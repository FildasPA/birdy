<?php
if($context->tweets !== false) {
	foreach($context->tweets as $tweet) {
		include("viewTweetSuccess.php");
	}
}
?>
