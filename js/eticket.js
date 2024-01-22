$(document).ready(function () {
	$('#openTicket').load('../components/openTicket.php');
	$('#FAQ').load('../components/faq.php');
	$('#openTickets').load('../components/openTickets.php');
	$('#closedTickets').load('../components/closedTickets.php');
	var text_max = 512;
	$('#count_message').html('0/' + text_max);
	$('#detalleEticket').on('keyup', function () {
		var text_length = $('#detalleEticket').val().length;
		var text_remaining = text_max - text_length;
		$('#count_message').html(text_length + '/' + text_max);
	});
});

$(document).on('click', '#btnSaveTicket', function () {
	$('#spinner').modal('show');
	$.post(
		'../controllers/Eticket.php',
		{
			action: 'saveEticket',
			type: $('#tipoEticket').val(),
			issue: $('#asuntoEticket').val(),
			detail: $('#detalleEticket').val(),
		},
		function (resp) {
			resp = JSON.parse(resp);
			if (resp.status == 'true') {
				// success
				$('#spinner').modal('hide');
				$('#infoModalTitle').text('Success');
				$('#infoModalText').html(resp.message);
				$('#infoModalButtons').html(
					'<button type="button" class="btn btn-info" data-bs-dismiss="modal">Ok</button>'
				);
				$('#infoModal').modal('show');
				$('#openTicket').load('../components/openTicket.php');
				$('#openTickets').load('../components/openTickets.php');
				$('#closedTickets').load('../components/closedTickets.php');
			} else {
				$('#spinner').modal('hide');
				$('#infoModalTitle').text('Error');
				$('#infoModalText').html(resp.message);
				$('#infoModalButtons').html(
					'<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Ok</button>'
				);
				$('#infoModal').modal('show');
			}
			
		}
	);
	$modalContent =
		'<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-success" id="btnSaveEticket">Save</button>';
	$('#infoModalButtons').html($modalContent);
});