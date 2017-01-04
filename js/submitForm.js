//-----------------------------------------------------------------------------
// * Envoie le formulaire en AJAX et recharge la vue principale
//-----------------------------------------------------------------------------
$('form').submit(function(e)
{
	e.preventDefault();

	var content  = '#container';
	var address  = "birdyAjax.php?action=" + $(this).attr('action');

	var formData = new FormData();
	// alert($('#avatar')[0].files[0]);
	console.log($('#avatar')[0].files[0]);
	formData.append('avatar',$('#avatar')[0].files[0]);
	console.log(formData);
	// alert(formData.getAll('avatar').getAsText());
	// alert(charge.readAsText(formData.getAll('avatar')));
	// alert(this);
	// formData.append('info',$(this).serialize());
	var other_data = $(this).serializeArray();
	// alert(other_data);
	$.each(other_data,function(key,input){
		formData.append(input.name,input.value);
	});

	// // alert("formData",formData);

	$.post({
		url:     address,
		data:    formData,
		processData: false,
		contentType: false,
		success: function(page){$(content).html(page);}
	});
});
