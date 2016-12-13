<div id="nav-menu">
	<div id="name-app">
		<a href="birdyAjax.php?action=index">
			<span class="text">Birdy</span>
			<span class="return">Index</span>
		</a>
	</div>
	<nav id="links">
		<span id="link-other-actions">
			<a>Autres pages</a>
			<div id="other-actions">
				<ul>
					<li><a href="birdyAjax.php?action=displayUsers">Liste des utilisateurs</a></li>
				</ul>
			</div>
		</span>
		<?php
			if($context->isUserLoged) {
		?>
		<a href="birdyAjax.php?action=sendTweet">Envoyer un tweet</a>
		<a href="birdyAjax.php?action=viewProfile" title="Voir le profil"><?php echo $context->	getSessionAttribute('identifiant'); ?></a>
		<a href="birdyAjax.php?action=logout">Se déconnecter</a>
		<?php
			} else {
		?>
		<a href="birdyAjax.php?action=login">Se connecter</a>
		<a href="birdyAjax.php?action=register">S'inscrire</a>
		<?php
			}
		?>
	</nav>
</div>
