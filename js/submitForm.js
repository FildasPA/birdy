//-----------------------------------------------------------------------------
// * Envoie le formulaire en AJAX et recharge la vue principale
//-----------------------------------------------------------------------------
function submitForm(form)
{
	var content  = '#container';
	var address  = "birdyAjax.php?action=" + form.attr('action');

	// Add form data & files
	var formData = new FormData();
	$.each(form.serializeArray(),function(key,input){
		formData.append(input.name,input.value);
	});
	if($('#avatar').length) {
		console.log("avatar!");
		formData.append('avatar',$('#avatar')[0].files[0]);
	}

	$.post({
		url:     address,
		data:    formData,
		processData: false,
		contentType: false,
		success: function(page){$(content).html(page);}
	});
}

//-----------------------------------------------------------------------------
// * Envoie le formulaire en AJAX et recharge la vue principale
//-----------------------------------------------------------------------------
$('form').submit(function(e)
{
	e.preventDefault();
	submitForm($(this));
});



