//=============================================================================
// * Recharge une vue dans un bloc
// ----------------------------------------------------------------------------
// Appelle l'action passée en paramètre en AJAX et affiche son résultat
// dans le bloc passé en second paramètre.
//=============================================================================
function updateView(action,content) {
	var address = "birdyAjax.php?action=" + action;
	$(content).load(address);
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
// * Place des gestionnaires d'évènements sur les principaux blocs
// ----------------------------------------------------------------------------
// Ces gestionnaires d'évènements appellent la fonction 'updateView' lors d'un
// clic sur un lien interne (identifié à l'aide de la classe 'ajax-nav').
// ----------------------------------------------------------------------------
// Ces gestionnaires ne sont placés qu'une seule fois lors du chargement de la
// page (lors du chargement du layout).
//=============================================================================
$(document).ready(function(){
	$('#container').on('click','a.ajax-nav',updateMainView);
	$('#nav-menu').on('click','a.ajax-nav',updateMainView);
});
