<?php
include_once '../controllers/Login.php';
startSession();
checkActivity();

$user = new User();
?>
<main class="p-2">
    <div class="flex flex-col lg:flex-row text-sky-950">
        <div class="flex-col lg:w-2/3 md:w-full" id='calendarDiv'>
            <?php include('../components/calendarHR.php'); ?>
        </div>
        <div class="flex-col lg:w-1/3 md:w-full lg:ms-2">
            <div class="border-b-4 border-red-900">
                <h4>Options</h4>
            </div>
            <form class="form-control border-2 p-3">
                <div class="flex flex-col" id="empleadoSelectDiv">
                    <label for="empleadoSelect" class="form-label">Select Employee</label>
                    <select class="block w-full md:w-2/3 bg-white border border-gray-400 hover:border-gray-500 hover:border-2 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" id='empleadoSelect' data-show='<?php echo $user->hasPermission('listarMarcacionesPersonal'); ?>' data-employee='<?php echo $_SESSION['user']['id']; ?>'></select>
                </div>
                <div class="mt-2">
                    <div>
                        <label for="year" class="form-label">Input year</label>
                        <input type="integer" class="block w-full md:w-2/3 bg-white border border-gray-400 hover:border-gray-500 hover:border-2 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" id="year" placeholder="Input the Year" value="2024">
                    </div>
                    <div class="col-12 col-lg-6">
                        <label for="month" class="form-label">Select month</label>
                        <select class="block w-full md:w-2/3 bg-white border border-gray-400 hover:border-gray-500 hover:border-2 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" id='mesSelect'>
                            <option value="0">January</option>
                            <option value="1">February</option>
                            <option value="2">March</option>
                            <option value="3">April</option>
                            <option value="4">May</option>
                            <option value="5">June</option>
                            <option value="6">July</option>
                            <option value="7">August</option>
                            <option value="8">September</option>
                            <option value="9">October</option>
                            <option value="10">November</option>
                            <option value="11">December</option>
                        </select>
                    </div>
                </div>
                <div class="text-right w-full md:w-2/3 my-1">
                    <button type="button" class="btn-primary" id='generarBtn'>Generate</button>
                </div>
                <hr class="my-2">
                <div class="flex-col hidden" id="estadisticasDiv">
                    <div class="ps-0 border-b-2 border-red-600">
                        <h2 class="ps-0">Statistics</h2>
                    </div>
                    <div class="ps-0">
                        <h4 class="ps-0 pt-2">Late Minutes</h4>
                    </div>
                    <div class="">
                        <table class="table rounded">
                            <thead>
                                <tr class="text-red-600">
                                    <th>Month Total :</th>
                                    <th id="totalMes" class="text-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-sky-950">
                                    <td>1st Fortnight :</td>
                                    <td id="primeraQuincena" class="text-end"></td>
                                </tr>
                                <tr class="text-sky-950">
                                    <td>2nd Fortnight :</td>
                                    <td class="text-end" id="segundaQuincena"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<link rel="stylesheet" href="../css/calendar.css">

<script>
    $(document).ready(function () {
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
		modalHide('infoModal');
		$('#infoModalTitle').html('Vacation Request');
		$('#infoModalTitle').parent().removeClass();
		$('#infoModalTitle').parent().addClass('bg-blue-500 modalTitle');
		$('#infoModalText').load('../components/solicitarVacaciones.php', { fecha: $fecha });
		$modalButtons =
			'<button type="button" class="btn-danger modalClose">Cancel</button>' +
			'<button type="button" class="btn-success ms-2" id="solicitarVacacion">Save</button>';
		$('#infoModalButtons').html($modalButtons);
		modalShow('infoModal');
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

	$('body').on('click', '.fa-angles-left', function () {
		if ($('#mesSelect').val() == 0) {
			$('#mesSelect').val(11);
			$('#year').val($('#year').val() - 1);
		} else {
			$('#mesSelect').val($('#mesSelect').val() - 1);
		}
		$mes = $('#mesSelect').val();
		$year = $('#year').val();
		$empleado = $('#empleadoSelect').val();
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

	$('body').on('click', '.fa-angles-right', function () {
		if ($('#mesSelect').val() == 11) {
			$('#mesSelect').val(0);
			$('#year').val(parseInt($('#year').val()) + 1);
		} else {
			$('#mesSelect').val(parseInt($('#mesSelect').val()) + 1);
		}
		$mes = $('#mesSelect').val();
		$year = $('#year').val();
		$empleado = $('#empleadoSelect').val();
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
				$('#infoModalButtons').html('<button type="button" class="btn-info modalClose">Ok</button>');
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

</script>