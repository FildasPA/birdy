
//=============================================================================
// * Recharge une vue dans un bloc
// ----------------------------------------------------------------------------
// Appelle l'action passée en paramètre en AJAX et affiche son résultat
// dans le bloc passé en second paramètre.
// Une fois la vue rechargée, replace tous les gestionnaires d'évènements sur
// les liens.
// ----------------------------------------------------------------------------
// Notes :
// - pourquoi ajouter les gestionnaires d'év.? tout lien affiché dans la
// nouvelle vue ne pourra mettre à jour la vue en AJAX, et mènera directement
// l'utilisateur à l'adresse indiquée dans 'href' => erreur.
// - pourquoi enlever les gestionnaires d'év. déjà présents? ils s'ajouteraient
// de manière récursive.
//=============================================================================
function updateView(action,content) {
	var address = "birdyAjax.php?action=" + action;
	$(content).load(address,updateMainViewOnClick(content));
}

//=============================================================================
// * Recharge la sous-vue principale
// ----------------------------------------------------------------------------
// Récupère l'action (ainsi que les paramètres) se trouvant dans l'attribut
// 'href' de l'élément courant, puis recharge la sous-vue principale dans
// le bloc #container'.
//=============================================================================
function updateMainView(e) {
	e.preventDefault();
	updateView(this.getAttribute("href"),"#container");
}

//=============================================================================
// * Recharge la vue principale quand l'utilisateur clique sur un lien interne
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
// * Place un gestionnaire d'évènement sur tous les lien internes de la page.
//=============================================================================
$(document).ready(updateMainViewOnClick(document));
