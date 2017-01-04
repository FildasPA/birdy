//=============================================================================
// * Recharge une vue dans un bloc
// ----------------------------------------------------------------------------
// Appelle l'action passée en paramètre en AJAX et affiche son résultat
// dans le bloc passé en second paramètre.
// Une fois la vue rechargée, replace tous les gestionnaires d'évènements sur
// les liens internes présents dans le bloc.
// ----------------------------------------------------------------------------
// Note : pourquoi ajouter les gestionnaires d'évènements après le rechargement
// de la vue?
// Les liens affichés dans la nouvelle vue sont des liens normaux, c'est à dire
// qu'ils ne font appel à aucune fonction Javascript (même s'ils sont indiqués
// comme étant "internes" à l'aide de la classe 'ajax-nav').
// Ainsi, au lieu de mettre à jour la vue, ces liens mèneront l'utilisateur
// directement à l'adresse indiquée (vers le dispatcher AJAX, qui ne renvoie
// qu'une vue seule), ce qui occasionnera la perte du layout (css, scripts,..)
// et donc une erreur d'affichage.
//=============================================================================
function updateView(action,content) {
	var address = "birdyAjax.php?action=" + action;
	$(content).load(address,updateMainViewOnClick(content));
}

//=============================================================================
// * Recharge la sous-vue principale
// ----------------------------------------------------------------------------
// Récupère l'action (ainsi que les paramètres) se trouvant dans l'attribut
// 'href' du lien, puis recharge la sous-vue principale dans le bloc
// '#container'.
//=============================================================================
function updateMainView(e) {
	e.preventDefault();
	updateView(this.getAttribute("href"),"#container");
}

//=============================================================================
// * Recharge la vue principale lorsque l'utilisateur clique sur un lien
// interne
// ----------------------------------------------------------------------------
// Place un gestionnaire d'évènement sur chaque lien interne (identifié à
// l'aide de la classe 'ajax-nav') présent dans le bloc indiqué.
// Lorsque l'utilisateur clique sur un de ces liens, appelle la fonction
// 'updateMainView'.
//=============================================================================
function updateMainViewOnClick(content) {
	$(content).on('click','a.ajax-nav',updateMainView);
}

//=============================================================================
// * Place un gestionnaire d'évènement sur tous les liens internes
// ----------------------------------------------------------------------------
// Cette instruction n'est exécutée qu'une seule fois lors du chargement de la
// page (lors du chargement du layout).
//=============================================================================
$(document).ready(updateMainViewOnClick(document));
