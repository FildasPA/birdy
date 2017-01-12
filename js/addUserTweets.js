//=============================================================================
// * Ajout dynamique des tweets dans la vue
//=============================================================================

//=============================================================================
// * Ajoute les tweets les plus récents en haut d'un container
//=============================================================================
function addMostRecentTweetsPostedBy(userLogin)
{
	var address = "birdyAjax.php?action=addMostRecentTweetsPostedByUser";
	$('.tweets').prepend(address);
}

//=============================================================================
// * Ajoute les tweets anciens en bas d'un container
//=============================================================================
function addOlderTweetsPostedBy(userLogin)
{
	var address = "birdyAjax.php?action=addOlderTweetsPostedBy";
	$('.tweets').append(address);
}

//=============================================================================
// * Place des gestionnaires d'évènements
// ----------------------------------------------------------------------------
// Ces gestionnaires d'évènements appellent la fonction 'updateView' lors d'un
// clic sur un lien interne (identifié à l'aide de la classe 'ajax-nav').
// ----------------------------------------------------------------------------
// Ces gestionnaires ne sont placés qu'une seule fois lors du chargement de la
// page (lors du chargement du layout).
//=============================================================================
$(document).ready(function(){
	$('.add-most-recent-tweets-posted-by-user').on('click',addMostRecentTweetsPostedBy);
	$('.add-older-tweets-posted-by-user').on('click',addOlderTweetsPostedBy);
});
