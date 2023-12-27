var $cotizaciones;

function loadQuotes($agent) {
	$.post('../controllers/Quote.php', { action: 'getQuotes', agent: $agent }).done(function (resp) {
		$cotizaciones = JSON.parse(resp);
		$html = '';
		$.each($cotizaciones, function (key, $cotizacion) {
			$html +=
				'<tr data-id = ' +
				$cotizacion.id +
				'><td>' +
				$cotizacion.date +
				'</td><td>' +
				$cotizacion.name +
				'</td><td>' +
				$cotizacion.state +
				'</td></tr>';
		});
		$('#tableQuotes').html($html);
	});
	return 0;
}

$('#tableQuotes').on('click', 'tr', function () {
	$id = $(this).data('id');
	$.each($cotizaciones, function (index, $cotizacion) {
		if ($cotizacion.id == $id) {
			$html =
				'<tr><td>Fecha de Cotización:</td><td>' +
				$cotizacion.date +
				'</td></tr>' +
				'<tr><td>Nombre de Empresa:</td><td>' +
				$cotizacion.name +
				'</td></tr>' +
				'<tr><td>DOT:</td><td>' +
				$cotizacion.dot +
				'</td></tr>' +
				'<tr><td>MC:</td><td>' +
				$cotizacion.mc +
				'</td></tr>' +
				'<tr><td>Dirección:</td><td>' +
				$cotizacion.address +
				'</td></tr>' +
				'<tr><td>Ciudad:</td><td>' +
				$cotizacion.city +
				'</td></tr>' +
				'<tr><td>Estado:</td><td>' +
				$cotizacion.state +
				'</td></tr>' +
				'<tr><td>ZIP:</td><td>' +
				$cotizacion.zip +
				'</td></tr>' +
				'<tr><td>Email:</td><td>' +
				$cotizacion.email +
				'</td></tr>' +
				'<tr><td>Phone:</td><td>' +
				$cotizacion.phone +
				'</td></tr>' +
				'<tr><td>Fecha Tentativa de Inicio:</td><td>' +
				$cotizacion.proposedDate +
				'</td></tr>' +
				'<tr><td>Licencia de Conductor:</td><td>' +
				$cotizacion.driverLicense +
				'</td></tr>' +
				'<tr><td>Nombre del Dueño:</td><td>' +
				$cotizacion.owner +
				'</td></tr>' +
                '<tr><td></td><td class="text-end"><button id="buttonRFP" type="button" class="btn btn-primary">Llenar RFP</button></td></tr>';
			$('#tableDetail').html($html);
		}
	});
});

$('#buttonRFP').on('click', function () {
    
});

$(document).ready(function () {});
