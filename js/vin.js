$(document).ready(function () {
	
    $('#vinSearchBtn').on('click', function () {
		modalShow('spinner');
		$.get('../controllers/Load.php', {
			action: 'searchVIN',
			VIN: $('#vinSearch').val(),
		}).done(function (resp) {
			if (resp) {
				respuesta = JSON.parse(resp);
				$html = '';
				$.each(respuesta.Results, function (index, dato) {
					if (dato.Value) {
						$html += `<tr><td>${dato.Variable}</td><td>${dato.Value}</td></tr>`;
					}
				});
				$('#vinTable').html($html);
			}
			modalHide('spinner');
		});
	});

});
