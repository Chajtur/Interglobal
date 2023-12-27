$(document).ready(function () {
	$('#nombreModulo').text('Cargas');
	$('#nombreModuloM').text('Cargas');

	$('#dotSearch').on('click', function () {
		$.get('../controllers/Load.php', {
			action: 'generalDot',
			dot: $('#searchText').val(),
		}).done(function (resp) {
			respuesta = JSON.parse(resp);
			$('#estatusOperacion').html(respuesta.commonAuthorityStatus);
			$('#nombreLegal').html(respuesta.legalName);
			$('#estado').html(respuesta.phyState);
			$('#usDot').html(respuesta.dotNumber);
		});
	});

	$('#mcSearch').on('click', function () {
		$.get('../controllers/Load.php', {
			action: 'generalMC',
			mc: $('#searchText').val(),
		}).done(function (resp) {
			respuesta = JSON.parse(resp);
			$('#estatusOperacion').html(respuesta.commonAuthorityStatus);
			$('#nombreLegal').html(respuesta.legalName);
			$('#estado').html(respuesta.phyState);
			$('#usDot').html(respuesta.dotNumber);
			$('#mc').html($('#searchText').val());
		});
	});

	new tempusDominus.TempusDominus(document.getElementById('pickupDate'), {
		restrictions: {

		},
		useCurrent: true,
		display: {
			viewMode: 'calendar',
			buttons: {
				close: true,
			},
			components: {
				calendar: true,
				date: true,
				month: true,
				year: true,
				clock: true,
				hours: true,
				minutes: true,
			},
		},
		promptTimeOnDateChange: true,
		promptTimeOnDateChangeTransitionDelay: 2000,
		stepping: 5
	});
});
