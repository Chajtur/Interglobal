$(document).ready(function () {
	$('#nombreModulo').text('Calendario');
	$('#nombreModuloM').text('Calendario');
	$('#spinner').modal('show');
	const d = new Date();
	let month = d.getMonth();
	$('#mesSelect option[value=' + month + ']').attr('selected', 'selected');
	$meses = [
		'Enero',
		'Febrero',
		'Marzo',
		'Abril',
		'Mayo',
		'Junio',
		'Julio',
		'Agosto',
		'Septiembre',
		'Octubre',
		'Noviembre',
		'Diciembre',
	];

	function crearFeriado($fecha) {
		$('#infoModalTitle').text($fechaDisplay);
		$modalContent =
			'<div class="row">' +
			'<h4>Creación de Feriado</h4>' +
			'<div class="form-floating mb-3">' +
			'<input class="form-control rounded" id="nombreFeriado" type="text" placeholder="Nombre">' +
			'<label for="nombreFeriado">Nombre del Feriado</label>' +
			'</div>' +
			'<div class="form-floating mb-3">' +
			'<textArea class="form-control rounded h-100" id="descripcionFeriado" type="text" maxlength="256" rows="8" placeholder="Nombre"></textArea>' +
			'<label for="descripcionFeriado">Descripción del Feriado</label>' +
			'<span class="float-end my-n5 px-1 bg-info rounded small text-white" id="count_message"></span>' +
			'</div>' +
			'<span>Se otorgará :</span>' +
			'<div id="checkBoxGroup" class="ml-3">' +
			'<div class="form-check">' +
			'<input class="form-check-input" type="radio" name="flexRadioDefault" id="diaCompleto" checked>' +
			'<label class="form-check-label" for="flexRadioDefault1">Día Completo</label>' +
			'</div>' +
			'<div class="form-check">' +
			'<input class="form-check-input" type="radio" name="flexRadioDefault" id="medioDia">' +
			'<label class="form-check-label" for="flexRadioDefault2">Medio Día</label>' +
			'</div>' +
			'</div>';
		$('#infoModalText').html($modalContent);
		$modalButtons =
			'<button type="button" class="btn btn-success" id="btnGuardarFeriado" data-date="' +
			$fecha +
			'">Guardar</button>' +
			'<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>';
		$('#infoModalButtons').html($modalButtons);
		var text_max = 256;
		$('#count_message').html('0/' + text_max);
		$('#descripcionFeriado').on('keyup', function () {
			var text_length = $('#descripcionFeriado').val().length;
			$('#count_message').html(text_length + '/' + text_max);
		});
	}

	function solicitarVacaciones($fecha) {
		$('#infoModalTitle').html('Solicitud de Vacaciones');
		$modalContent =
			'<div class="row">' +
			'<h4>Rango de Días Solicitados</h4>' +
			'<div class="form-floating mb-3">' +
			'<input disabled class="form-control rounded border-primary" id="primerDiaVacaciones" type="date" value="' +
			$fecha +
			'" placeholder="Desde">' +
			'<label class="text-primary" for="primerDiaVacaciones">Desde</label>' +
			'</div>' +
			'<div class="form-floating mb-3">' +
			'<input class="form-control rounded border-primary" id="ultimoDiaVacaciones" type="date" min="' +
			$fecha +
			'" placeholder="Hasta">' +
			'<label class="text-primary" for="ultimoDiaVacaciones">Hasta</label>' +
			'</div>' +
			'<div class="form-floating mb-3">' +
			'<textArea class="form-control rounded h-100" id="motivoVacaciones" type="text" maxlength="256" rows="5" placeholder="Nombre"></textArea>' +
			'<label for="descripcionFeriado">Motivo</label>' +
			'<span class="float-end my-n5 px-1 bg-info rounded small text-white" id="count_message"></span>' +
			'</div>' +
			'</div>'; //cerrar body
		$('#infoModalText').html($modalContent);
		$modalButtons =
			'<button type="button" class="btn btn-success" id="solicitarVacacion">Guardar</button>' +
			'<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>';
		$('#infoModalButtons').html($modalButtons);
	}

	function solicitarPermiso($fecha) {
		$modalContent =
			'<div class="modal-dialog">' +
			'<div class="modal-content">' +
			'<div class="modal-header">' +
			'<h1 class="modal-title fs-5">' +
			'Solicitud de Permiso para el ' +
			$fechaDisplay +
			'</h1>' +
			'<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>' +
			'</div>' +
			'<div class="modal-body">' +
			'<div class="row">' +
			'<h4>Seleccionar Hora del Permiso</h4>' +
			'<div class="form-floating mb-3">' +
			'<input class="form-control rounded border-primary" id="horaPermiso" type="time" placeholder="Hora">' +
			'<label class="text-primary" for="horaPermiso">Hora</label>' +
			'</div>' +
			'</div>' + //cerrar body
			'<div class="modal-footer">' + // footer
			'<button type="button" class="btn btn-success">Guardar</button>' +
			'<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>' +
			'</div>' +
			'</div>' + //cerrar content
			'</div>'; //cerrar dialog
		$('#infoModal').html($modalContent);
		$('#infoModal').modal('show');
	}

	function cargarMenu($fechaDisplay, resp) {
		$('#infoModalTitle').text($fechaDisplay);
		/** Cargar data al modal */
		$modalContent =
			"<div id='seccionFeriados'></div><hr><div id='seccionVacaciones'></div><hr><div id='seccionPermisos'></div>";
		$('#infoModalText').html($modalContent);
		$modalContent = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
		$('#infoModalButtons').html($modalContent);
		$('#seccionFeriados').load('../components/seccionFeriados.php', { fecha: $searchDate });
		$('#seccionPermisos').load('../components/seccionPermisos.php', { fecha: $searchDate });
		$('#seccionVacaciones').load('../components/seccionVacaciones.php', { fecha: $searchDate }, function () {
			$('#spinner').modal('hide');
			$('#infoModal').modal('show');
		});
	}

	$('#generarBtn').click(function () {
		$empleado = $('#empleadoSelect').val();
		$mes = $('#mesSelect').val();
		$year = $('#year').val();
		$('#spinner').modal('show');
		$('#calendarDiv').load(
			'../components/calendarHR.php',
			{
				year: $year,
				month: parseInt($mes) + 1,
				employee: $empleado,
			},
			function () {
				$('.modal').modal('hide');
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

	/*function loadPunches($mes, $year) {
		//$('#spinner').modal('show');
		$primeraQuincena = 0;
		$segundaQuincena = 0;
		$diasNoMarcados = 0;
		$htmlString =
			"<div class='row border-bottom border-danger border-4'><div class='col'><h4>" +
			$('#mesSelect option:selected').text() +
			"</h4></div><div class='col'><h4>" +
			$year +
			'</h4></div></div>';
		var week = ['LUN', 'MAR', 'MIE', 'JUE', 'VIE', 'SAB', 'DOM'];
		$htmlString += '<div class="row border-2 border-bottom border-danger pt-2">';
		for ($i = 0; $i <= 6; $i++) {
			$htmlString += '<div class="col dia">';
			$htmlString += '    <h6>' + week[$i] + '</h6>';
			$htmlString += '</div>';
		}
		$htmlString += '</div>';
		$htmlString += '<div class="row text-white">';
		$day = 1;
		$row = 1;
		$contador = 1;
		$firstDay = new Date($year, $mes, 1).getDay();
		$firstDay = $firstDay == 0 ? 7 : $firstDay;
		$totalDays = new Date($year, parseInt($mes) + 1, 0).getDate();
		while ($contador < $firstDay) {
			$bgColor = $contador >= 6 ? 'bg-white' : 'bg-white';
			$htmlString += '<div class="dia p-0 p-md-2 col rounded border border-white ' + $bgColor + '"></div>';
			$contador++;
		}
		while ($day <= $totalDays) {
			$entrada = 'N/A';
			$fechaEntrada = $year + '-' + (parseInt($mes) + 1) + '-' + $day + ' 07:00:00';
			let i = 0;
			while (i < $marcas.length) {
				if (parseInt($marcas[i].Fecha) == parseInt($day)) {
					$entrada = $marcas[i].Entrada;
					break;
				}
				i++;
			}
			$class =
				$entrada != 'N/A' && $entrada >= '07:00:00'
					? 'bg-danger calendarClickable'
					: 'bg-success calendarClickable';
			$class = $entrada == 'N/A' ? 'bg-secondary calendarClickable' : $class;
			$class = $contador >= 6 ? 'bg-primary' : $class;
			if ($entrada != 'N/A' && $entrada >= '07:00:00' && $contador <= 5) {
				$fechaMarca = $year + '-' + (parseInt($mes) + 1) + '-' + $day + ' ' + $entrada;
				$diff = new Date($fechaMarca).getTime() - new Date($fechaEntrada).getTime();
				$diff = Math.floor($diff / 1000 / 60);
				if ($day <= 15) {
					$primeraQuincena += $diff;
				} else {
					$segundaQuincena += $diff;
				}
			}
			$fechaDiv = $day + ' de ' + $meses[$mes] + ' del ' + $year;
			$fechaSearch =
				$year +
				'-' +
				(parseInt($mes) + 1 < 10 ? '0' : '') +
				(parseInt($mes) + 1) +
				'-' +
				(parseInt($day) < 10 ? '0' : '') +
				parseInt($day);
			$htmlString +=
				'<div data-day="' +
				$fechaDiv +
				'" data-searchDate="' +
				$fechaSearch +
				'" class="p-0 p-md-2 rounded col dia border ' +
				$class +
				'">';
			$htmlString += '    <div class="small p-2">';
			$htmlString += '        <p>' + $day + '</p>';
			$htmlString += '    </div>';
			$htmlString += '    <div class="small">';
			$htmlString += '        <p class="text-end">' + ($entrada == 'N/A' ? '' : $entrada) + '<small>';
			$htmlString += '    </div>';
			$htmlString += '</div>';
			if ($contador % 7 == 0) {
				$row++;
				$htmlString += "</div><div class='row text-white'>";
				$contador = 0;
			}
			$day++;
			$contador++;
		}
		$contador--;
		while ($contador % 7 != 0) {
			$htmlString += '<div class="col dia rounded border p-0 p-md-2 border-white"></div>';
			$contador++;
		}
		$htmlString += '</div>';
		$htmlString += '</div>';
		//$('#calendarDiv').html($htmlString);
		$('#primeraQuincena').html($primeraQuincena + ' minutos');
		$('#segundaQuincena').html($segundaQuincena + ' minutos');
		$('#totalMes').html($primeraQuincena + $segundaQuincena + ' minutos');
		$('#estadisticasDiv').removeClass('d-none');
		$('#spinner').modal('hide');
		console.log('Cerrando modal spinner después de cargar calendario');
	}*/

	$('body').on('click', '#btnGuardarFeriado', function () {
		$('#spinner').modal('show');
		$.post('../controllers/Calendar.php', {
			action: 'saveHoliday',
			fecha: $(this).data('date'),
			nombre: $('#nombreFeriado').val(),
			detalle: $('#descripcionFeriado').val(),
			diaCompleto: $('#diaCompleto').is(':checked') ? 'true' : 'false',
		}).done(function (resp) {
			$('#spinner').modal('hide');
			resp = JSON.parse(resp);
			console.log(resp);
			if (resp.status == 'error') {
				console.log('Error guardando feriado');
				$('#infoModalTitle').html('Error!!');
				$('#infoModalText').html(
					'No se pudo crear el feriado en esta fecha, puede que ya exista un feriado para esta fecha'
				);
				$('#infoModalButtons').html(
					'<button type="button" class="btn btn-info" data-bs-dismiss="modal">Ok</button>'
				);
			} else {
				console.log('Se guardó feriado con éxito');
				$('#infoModalTitle').html('Feriado Creado!!');
				$('#infoModalText').html('El feriado ha sido creado con éxito!');
				$('#infoModalButtons').html(
					'<button type="button" class="btn btn-info" data-bs-dismiss="modal">Ok</button>'
				);
				//$('#infoModal').modal('show');
			}
		});
	});

	$('body').on('click', '.calendarClickable', function () {
		$('#spinner').modal('show');
		$('#infoModal').modal('hide');
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
		$('#spinner').modal('show');
		$.post('../controllers/Calendar.php', {
			action: 'askDayOff',
			from: $('#primerDiaVacaciones').val(),
			to: $('#ultimoDiaVacaciones').val(),
			reason: $('#motivoVacaciones').val(),
		}).done(function (resp) {
			console.log(resp);
			$('#spinner').modal('hide');
			resp = JSON.parse(resp);
			if (resp['status'] == 'success') {
				$('#infoModalTitle').html('Solicitud Exitosa!!');
			} else {
				$('#infoModalTitle').html('Error en la Solicitud!!');
			}
			$('#infoModalText').html(resp['text']);
			$('#infoModalButtons').html(
				'<button type="button" class="btn btn-info" data-bs-dismiss="modal">Ok</button>'
			);
		});
	});

	$('body').on('click', '.asignarFeriado', function () {
		crearFeriado($(this).data('searchdate'));
	});

	$('body').on('click', '.eliminarFeriado', function () {
		$('#spinner').modal('show');
		$.post('../controllers/Calendar.php', {
			action: 'removeHoliday',
			fecha: $(this).data('searchdate'),
		}).done(function (resp) {
			$('#spinner').modal('hide');
			if (resp) {
				$('#infoModalTitle').html('Feriado Eliminado!!');
				$('#infoModalText').html('El Feriado ha sido eliminado con éxito');
				$('#infoModalButtons').html(
					'<button type="button" class="btn btn-info" data-bs-dismiss="modal">Ok</button>'
				);
			} else {
				$('#infoModalTitle').html('Error!!');
				$('#infoModalText').html('Ocurrió un error eliminando el feriado, puede que este ya no exista');
				$('#infoModalButtons').html(
					'<button type="button" class="btn btn-info" data-bs-dismiss="modal">Ok</button>'
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
