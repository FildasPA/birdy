
//=============================================================================
// * Recharge la sous-vue principale
// ----------------------------------------------------------------------------
// Récupère l'action (ainsi que les paramètres) se trouvant dans l'attribut
// 'href', puis recharge la sous-vue principale dans '#container'.
//=============================================================================
function updateViews() {
	updateView(this.getAttribute("href"),"#container");
	return false;
}

//=============================================================================
// * Recharge la vue principale quand l'utilisateur clique sur un lien interne
// ----------------------------------------------------------------------------
// Place un gestionnaire d'évènement 'click' appelant la fonction 'updateViews'
// sur chaque lien (<a>) ayant pour classe 'ajax-nav'.
//=============================================================================
$(document).ready(function(){
	$('a.ajax-nav').click(updateViews);
});

//=============================================================================
// * Recharge une vue dans un bloc
// ----------------------------------------------------------------------------
// Appelle l'action passée en paramètre en AJAX, puis affiche son résultat
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
	var xhttp;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			$(content).load(address);
			$(document).off('click','a.ajax-nav');
			$(document).on('click','a.ajax-nav',updateViews);
		}
	};
	xhttp.open("GET",address,true); // requête GET asynchrone
	xhttp.send();
}
