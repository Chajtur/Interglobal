$(document).ready(function () {
	$('#nombreModulo').text('Calendario');
	$('#nombreModuloM').text('Calendario');
	modalShow('spinner');
	const d = new Date();
	let month = d.getMonth();
	$('#mesSelect option[value=' + month + ']').attr('selected', 'selected');
	$meses = [
		'January',
		'February',
		'March',
		'April',
		'May',
		'June',
		'July',
		'August',
		'September',
		'October',
		'November',
		'December',
	];

	function crearFeriado($fecha) {
		$('#infoModalTitle').text($fechaDisplay);
		$modalContent =
			'<div class="flex flex-col">' +
			'<h4 mt-0>Holiday Creation</h4>' +
			'<label for="nombreFeriado" class="mt-2">Holiday Name</label>' +
			'<input class="border-gray-400 rounded border px-3 py-4 cursor-pointer hover:border-2" id="nombreFeriado" type="text" placeholder="Name">' +
			'<label for="descripcionFeriado" class="mt-2">Holiday Description</label>' +
			'<textArea class="border-gray-400 rounded border px-3 py-4 cursor-pointer hover:border-2" id="descripcionFeriado" type="text" maxlength="256" rows="8" placeholder="Nombre"></textArea>' +
			'<span class="float-end my-n5 px-1 bg-info rounded small text-white" id="count_message"></span>' +
			'<span>Shall be given:</span>' +
			'<div id="checkBoxGroup" class="ml-3">' +
			'<div class="form-check">' +
			'<input class="form-check-input" type="radio" name="flexRadioDefault" id="diaCompleto" checked>' +
			'<label class="form-check-label ms-1" for="flexRadioDefault1">Full Day</label>' +
			'</div>' +
			'<div class="form-check">' +
			'<input class="form-check-input" type="radio" name="flexRadioDefault" id="medioDia">' +
			'<label class="form-check-label ms-1" for="flexRadioDefault2">Half a Day</label>' +
			'</div>' +
			'</div>';
		$('#infoModalText').html($modalContent);
		$modalButtons =
			'<button type="button" class="btn-success" id="btnGuardarFeriado" data-date="' +
			$fecha +
			'">Save</button>' +
			'<button type="button" class="btn-danger modalClose mx-2" data-bs-dismiss="modal">Cancel</button>';
		$('#infoModalButtons').html($modalButtons);
		var text_max = 256;
		$('#count_message').html('0/' + text_max);
		$('#descripcionFeriado').on('keyup', function () {
			var text_length = $('#descripcionFeriado').val().length;
			$('#count_message').html(text_length + '/' + text_max);
		});
	}

	function solicitarVacaciones($fecha) {
		$('#infoModalTitle').html('Vacation Request');
		$modalContent =
			'<div class="row">' +
			'<h4>Start and end dates of Vacation Request</h4>' +
			'<div class="form-floating mb-3">' +
			'<input disabled class="form-control rounded border-primary" id="primerDiaVacaciones" type="date" value="' +
			$fecha +
			'" placeholder="From">' +
			'<label class="text-primary" for="primerDiaVacaciones">From</label>' +
			'</div>' +
			'<div class="form-floating mb-3">' +
			'<input class="form-control rounded border-primary" id="ultimoDiaVacaciones" type="date" min="' +
			$fecha +
			'" placeholder="To">' +
			'<label class="text-primary" for="ultimoDiaVacaciones">To</label>' +
			'</div>' +
			'<div class="form-floating mb-3">' +
			'<textArea class="form-control rounded h-100" id="motivoVacaciones" type="text" maxlength="256" rows="5" placeholder="Reason for request"></textArea>' +
			'<label for="descripcionFeriado">Reason for Request</label>' +
			'<span class="float-end my-n5 px-1 bg-info rounded small text-white" id="count_message"></span>' +
			'</div>' +
			'</div>'; //cerrar body
		$('#infoModalText').html($modalContent);
		$modalButtons =
			'<button type="button" class="btn-success" id="solicitarVacacion">Save</button>' +
			'<button type="button" class="btn-danger modalClose" data-bs-dismiss="modal">Cancel</button>';
		$('#infoModalButtons').html($modalButtons);
	}

	function solicitarPermiso($fecha) {
		$modalContent =
			'<div class="modal-dialog">' +
			'<div class="modal-content">' +
			'<div class="modal-header">' +
			'<h1 class="modal-title fs-5">' +
			'Permit Request for ' +
			$fechaDisplay +
			'</h1>' +
			'</div>' +
			'<div class="modal-body">' +
			'<div class="row">' +
			'<h4>Select the time for the permit</h4>' +
			'<div class="form-floating mb-3">' +
			'<label class="text-primary" for="horaPermiso">Hour</label>' +
			'<input class="form-control rounded border-primary" id="horaPermiso" type="time" placeholder="Hour">' +
			'</div>' +
			'</div>' + //cerrar body
			'<div class="modal-footer">' + // footer
			'<button type="button" class="btn-success">Save</button>' +
			'<button type="button" class="btn-danger modalClose">Cancel</button>' +
			'</div>' +
			'</div>' + //cerrar content
			'</div>'; //cerrar dialog
		$('#infoModal').html($modalContent);
		modalShow('infoModal');
	}

	function cargarMenu($fechaDisplay, resp) {
		$('#infoModalTitle').html($fechaDisplay);
		$('#infoModalTitle').parent().removeClass();
		$('#infoModalTitle').parent().addClass('bg-blue-500 modalTitle');
		/** Cargar data al modal */
		$modalContent =
			"<div id='seccionFeriados'></div><hr class='my-2'><div id='seccionVacaciones'></div><hr class='my-2'><div id='seccionPermisos'></div>";
		$('#infoModalText').html($modalContent);
		$modalContent = '<button type="button" class="btn-danger modalClose">Close</button>';
		$('#infoModalButtons').html($modalContent);
		$('#seccionFeriados').load('../components/seccionFeriados.php', { fecha: $searchDate });
		$('#seccionPermisos').load('../components/seccionPermisos.php', { fecha: $searchDate });
		$('#seccionVacaciones').load('../components/seccionVacaciones.php', { fecha: $searchDate }, function () {
			modalHide('spinner');
			modalShow('infoModal');
		});
	}

	$('#generarBtn').click(function () {
		$empleado = $('#empleadoSelect').val();
		$mes = $('#mesSelect').val();
		$year = $('#year').val();
		modalShow('spinner');
		$('#calendarDiv').load(
			'../components/calendarHR.php',
			{
				year: $year,
				month: parseInt($mes) + 1,
				employee: $empleado,
			},
			function () {
				modalHide('spinner');
			}
		);
	});

	if ($('#empleadoSelect').data('show')) {
		$.get('../controllers/Login.php', { action: 'getEmployeeList' })
			.done(function (resp) {
				$employees = JSON.parse(resp);
				$($employees).each(function (i, empleado) {
					$('<option/>').val(empleado.id).text(empleado.fullName).appendTo('#empleadoSelect');
				});
			})
			.done(function () {
				$('#empleadoSelect').val($('#empleadoSelect').data('employee')).change();
				$('#generarBtn').click();
			});
	} else {
		$('<option/>')
			.val($('#empleadoSelect').data('employee'))
			.text('Employee')
			.attr('selected', 'selected')
			.appendTo('#empleadoSelect');
		$('#empleadoSelectDiv').hide();
		$('#generarBtn').click();
	}

	$('body').on('click', '#btnGuardarFeriado', function () {
		modalShow('spinner');
		$.post('../controllers/Calendar.php', {
			action: 'saveHoliday',
			fecha: $(this).data('date'),
			nombre: $('#nombreFeriado').val(),
			detalle: $('#descripcionFeriado').val(),
			diaCompleto: $('#diaCompleto').is(':checked') ? 'true' : 'false',
		}).done(function (resp) {
			modalHide('spinner');
			resp = JSON.parse(resp);
			console.log(resp);
			if (resp.status == 'error') {
				console.log('There was an error saving the holiday');
				$('#infoModalTitle').html('Error!!');
				$('#infoModalTitle').parent().removeClass();
				$('#infoModalTitle').parent().addClass('bg-red-500 modalTitle');
				$('#infoModalText').html(
					'There was an error saving the holiday, please try again later or contact the system administrator'
				);
				$('#infoModalButtons').html(
					'<button type="button" class="btn-info modalClose" data-bs-dismiss="modal">Ok</button>'
				);
			} else {
				console.log('Se guardó feriado con éxito');
				$('#infoModalTitle').html('Holiday Created!!');
				$('#infoModalText').html('The holiday has been created successfully!');
				$('#infoModalButtons').html(
					'<button type="button" class="btn-info modalClose" data-bs-dismiss="modal">Ok</button>'
				);
			}
		});
	});

	$('body').on('click', '.calendarClickable', function () {
		modalShow('spinner');
		modalHide('infoModal');
		$infoDate = null;
		$searchDate = $(this).data('searchdate');
		$fechaDisplay = $(this).data('day');
		$.post('../controllers/Calendar.php', {
			date: $(this).data('searchdate'),
			action: 'getHoliday',
		}).done(function (resp) {
			cargarMenu($fechaDisplay, resp);
		});
	});

	$('body').on('click', '#solicitarVacacion', function () {
		modalShow('spinner');
		$.post('../controllers/Calendar.php', {
			action: 'askDayOff',
			from: $('#primerDiaVacaciones').val(),
			to: $('#ultimoDiaVacaciones').val(),
			reason: $('#motivoVacaciones').val(),
		}).done(function (resp) {
			console.log(resp);
			modalHide('spinner');
			resp = JSON.parse(resp);
			if (resp['status'] == 'success') {
				$('#infoModalTitle').html('Request Sent!!');
			} else {
				$('#infoModalTitle').html('Error!!');
			}
			$('#infoModalText').html(resp['text']);
			$('#infoModalButtons').html(
				'<button type="button" class="btn-info modalClose" data-bs-dismiss="modal">Ok</button>'
			);
		});
	});

	$('body').on('click', '.asignarFeriado', function () {
		crearFeriado($(this).data('searchdate'));
	});

	$('body').on('click', '.eliminarFeriado', function () {
		modalShow('spinner');
		$.post('../controllers/Calendar.php', {
			action: 'removeHoliday',
			fecha: $(this).data('searchdate'),
		}).done(function (resp) {
			modalHide('spinner');
			if (resp) {
				$('#infoModalTitle').html('Holiday Deleted!!');
				$('#infoModalText').html('The holiday has been deleted successfully!');
				$('#infoModalButtons').html(
					'<button type="button" class="btn-info modalClose" data-bs-dismiss="modal">Ok</button>'
				);
			} else {
				$('#infoModalTitle').html('Error!!');
				$('#infoModalText').html('There was an error deleting the holiday, please try again later');
				$('#infoModalButtons').html(
					'<button type="button" class="btn-info modalClose">Ok</button>'
				);
			}
		});
	});

	$('body').on('click', '.solicitarVacaciones', function () {
		solicitarVacaciones($(this).data('searchdate'));
	});

	$('body').on('click', '.solicitarPermiso', function () {
		solicitarPermiso($(this).data('day'));
	});
});
