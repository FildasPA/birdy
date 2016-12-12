<div class="<?php if(!$context->alertMessage || $context->alertMessage == '') {echo 'invisible';} ?>" id="alert-box">
	<?php
	if($context->alertMessage != '')
		echo $context->alertMessage;
	?>
	<span id="close-box" onclick="closeBox('alert-box');">X<span>
</div>
