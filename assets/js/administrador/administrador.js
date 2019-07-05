$(document).ready(function($) {

	$('#myCollapsible').collapse({
  		toggle: false
	});

	function traerUsuarios(id) {
		console.log(id);
	}

	$('#acordeon1').click(function() {
		console.log('click click');
	});
});