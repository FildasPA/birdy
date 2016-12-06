<div id="tweet">
	<div id="tweet-block">
		<h3>Retweeté par <a href=""><?php echo $context->emetteur->nom; ?></a></h3>
		<div id="votes-number"><a href="" title="Voter pour ce contenu">Voté <?php echo $context->tweet->nVotes; ?> fois</a></div>
	</div>
	<div div="post-block">
		<div id="post-image"><img src="images/<?php echo $context->post->image; ?>"></img></div>
		<div id="post-text"><?php echo $context->post->text; ?></div>
		<div id="post-meta">
			<span id="author"><a href="birdy.php?action=viewProfile&login=<?php echo $context->tweet->parent->id; ?>"><?php echo $context->tweet->parent->nom ?><?php echo $context->tweet->parent->prenom; ?></a></span>
			<span id="date"><?php echo $context->tweet->post->date; ?></span>
		</div>
	</div>
</div>
