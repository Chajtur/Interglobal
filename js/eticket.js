$(document).ready(function () {
	$('#nombreModulo').text('E-Tickets');
	$('#nombreModuloM').text('E-Tickets');
	var text_max = 512;
	$('#count_message').html('0/' + text_max);
	$('#detalleEticket').on('keyup', function () {
		var text_length = $('#detalleEticket').val().length;
		var text_remaining = text_max - text_length;
		$('#count_message').html(text_length + '/' + text_max);
	});
});
