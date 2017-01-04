//-----------------------------------------------------------------------------
// * Envoie le formulaire en AJAX et recharge la vue principale
//-----------------------------------------------------------------------------
$('form').submit(function(e)
{
	e.preventDefault();

	var content  = '#container';
	var address  = "birdyAjax.php?action=" + $(this).attr('action');
	var formData = $(this).serialize();

	$.post({
		url:     address,
		data:    formData,
		success: function(page) {
			$(content).html(page);
			updateMainViewOnClick(content);
		}
	});
});
