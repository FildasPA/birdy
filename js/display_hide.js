function closeBox(id) {
	$("#"+ id).addClass("invisible");
}

$(document).ready(function() {
	$('a').click(function() {
		var address = this.href;
		var xhttp;
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				$("#container").load(address);
			}
		};
		xhttp.open("GET",address,true); // requête GET asynchrone
		xhttp.send();
		return false;
	})
});
