<div id="name-app">
	<a class="ajax-nav" href="index">
		<span class="text">Birdy</span>
		<span class="return">Index</span>
	</a>
</div>
<nav id="links">
	<span id="link-other-actions">
		<a>Autres pages</a>
		<div id="other-actions">
			<ul>
				<li><a class="ajax-nav" href="viewUsers">Liste des utilisateurs</a></li>
			</ul>
		</div>
	</span>
	<?php
		if($context->isUserLoged) {
	?>
	<a class="ajax-nav" href="sendTweet">Envoyer un tweet</a>
	<a class="ajax-nav" href="viewProfile" title="Voir le profil"><?php echo $context->getSessionAttribute('identifiant'); ?></a>
	<a class="ajax-nav" href="logout">Se déconnecter</a>
	<?php
		} else {
	?>
	<a class="ajax-nav" href="login">Se connecter</a>
	<a class="ajax-nav" href="register">S'inscrire</a>
	<?php
		}
	?>
</nav>
