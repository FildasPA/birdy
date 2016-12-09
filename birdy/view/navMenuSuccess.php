<div id="nav-menu">
	<p id="name">
		<a href="birdy.php?action=index">
			<span class="text">Birdy</span>
			<span class="return">Index</span>
		</a>
	</p>
	<nav id="links">
		<span id="link-other-actions">
			<a>Autres actions</a>
			<div id="other-actions" style="line-height: 20px">
				<ul style="margin: 0;">
					<li><a href="birdy.php?action=displayUsers">Liste des utilisateurs</a></li>
					<li><a href="birdy.php?action=superTest&par1=mdr&par2=lol">SuperTest</a></li>
					<li><a href="birdy.php?action=helloWorld">helloWorld</a></li>
				</ul>
			</div>
		</span>

		<?php
			if($context->isUserLoged) {
		?>
		<a href="birdy.php?action=viewProfile" title="Voir le profil"><?php echo $context->identifiant; ?></a>
		<a href="birdy.php?action=logout">Se déconnecter</a>
		<?php
			} else {
		?>
		<a href="birdy.php?action=login">Se connecter</a>
		<a href="birdy.php?action=register">S'inscrire</a>
		<?php
			}
		?>

	</nav>
</div>
