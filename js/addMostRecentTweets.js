//=============================================================================
// * Ajout dynamique des tweets dans la vue
//=============================================================================

//=============================================================================
// * Ajoute les tweets les plus récents en haut d'un container
//=============================================================================
function addMostRecentTweets()
{
	var address = "birdyAjax.php?action=addMostRecentTweets";
	$('.most-recent-tweets').prepend(address);
}

//=============================================================================
// * Ajoute les tweets les plus récents en bas d'un container
//=============================================================================
function addOlderTweets()
{
	var address = "birdyAjax.php?action=addOlderTweets";
	$('.most-recent-tweets').append(address);
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
	$('.add-most-recent-tweets').on('click',addMostRecentTweets);
	$('.add-older-tweets').on('click',addOlderTweets);
});
