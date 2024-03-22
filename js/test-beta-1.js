$(document).ready(function () {

	$('#referral').focus();

	function GetTodayDate() {
		var tdate = new Date();
		var dd = tdate.getDate(); //yields day
		var MM = tdate.getMonth(); //yields month
		var yyyy = tdate.getFullYear(); //yields year
		var currentDate = `${MM + 1}/${dd}/${yyyy}`;

		return currentDate;
	}

	$('#rfpDate').text(GetTodayDate());

	var $states = [
		{ Alabama: 'AL' },
		{ Alaska: 'AK' },
		{ Arizona: 'AZ' },
		{ Arkansas: 'AR' },
		{ California: 'CA' },
		{ Colorado: 'CO' },
		{ Connecticut: 'CT' },
		{ Delaware: 'DE' },
		{ 'District of Columbia': 'DC' },
		{ Florida: 'FL' },
		{ Georgia: 'GA' },
		{ Hawaii: 'HI' },
		{ Idaho: 'ID' },
		{ Illinois: 'IL' },
		{ Indiana: 'IN' },
		{ Iowa: 'IA' },
		{ Kansas: 'KS' },
		{ Kentucky: 'KY' },
		{ Louisiana: 'LA' },
		{ Maine: 'ME' },
		{ Maryland: 'MD' },
		{ Massachusetts: 'MA' },
		{ Michigan: 'MI' },
		{ Minnesota: 'MN' },
		{ Mississippi: 'MS' },
		{ Missouri: 'MO' },
		{ Montana: 'MT' },
		{ Nebraska: 'NE' },
		{ Nevada: 'NV' },
		{ 'New Hampshire': 'NH' },
		{ 'New Jersey': 'NJ' },
		{ 'New Mexico': 'NM' },
		{ 'New York': 'NY' },
		{ 'North Carolina': 'NC' },
		{ 'North Dakota': 'ND' },
		{ Ohio: 'OH' },
		{ Oklahoma: 'OK' },
		{ Oregon: 'OR' },
		{ Pennsylvania: 'PA' },
		{ 'Rhode Island': 'RI' },
		{ 'South Carolina': 'SC' },
		{ 'South Dakota': 'SD' },
		{ Tennessee: 'TN' },
		{ Texas: 'TX' },
		{ Utah: 'UT' },
		{ Vermont: 'VT' },
		{ Virginia: 'VA' },
		{ Washington: 'WA' },
		{ 'West Virginia': 'WV' },
		{ Wisconsin: 'WI' },
		{ Wyoming: 'WY' },
	];

	var $html = '';

	$.each($states, function () {
		$.each(this, function ($name, $value) {
			$html += `<option value='${$value}'>${$name}</option>`;
		});
	});
	$('#insuredState').html($html);
	$('#diState').html($html);

	$('#insuredDOT').on('focusout', function () {
		$('#spinner').modal('show');
		$.get('../controllers/Load.php', {
			action: 'generalDot',
			dot: $(this).val(),
		}).done(function (resp) {
			if (resp) {
				respuesta = JSON.parse(resp);
				$('#insuredMC').val(respuesta.mcNumber);
				$('#insuredName').val(respuesta.legalName);
				$('#insuredAddress').val(respuesta.phyStreet);
				$('#insuredCity').val(respuesta.phyCity);
				$('#insuredZipCode').val(respuesta.phyZipcode);
				$('#insuredState').val(respuesta.phyState);
				$('#insuredEmail').focus();
			}
			modalHide('spinner');
			$('#insuredMC').focus();
		});
	});

	$('#insuredMC').on('focusout', function () {
		$('#spinner').modal('show');
		$.get('../controllers/Load.php', {
			action: 'generalMC',
			mc: $(this).val(),
		}).done(function (resp) {
			if (resp) {
				respuesta = JSON.parse(resp);
				$('#insuredDOT').val(respuesta.dotNumber);
				$('#insuredName').val(respuesta.legalName);
				$('#insuredAddress').val(respuesta.phyStreet);
				$('#insuredCity').val(respuesta.phyCity);
				$('#insuredZipCode').val(respuesta.phyZipcode);
				$('#insuredState').val(respuesta.phyState);
				$('#insuredEmail').focus();
			}
			modalHide('spinner');
		});
	});

	$(document).on('click', '#addPCI', function () {
		$year = $('#pciYear').val();
		$company = $('#pciCompany').val();
		$losses = $('#pciLosses').is(':checked') ? 'Yes' : 'NO';
		$details = $('#pciDetails').val();
		$driverInvolved = $('#pciDriver').val();
		$row = `<tr class='text-start'><td>${$year}</td><td>${$company}</td><td>${$losses}</td><td>${$details}</td><td>${$driverInvolved}</td><td class='text-end'><div class="btn btn-outline-danger fw-bold removeRow"><i class="fa-solid fa-square-minus fa-lg"></i> Remove</div></tr>`;
		$('#priorCarrierInfo tbody').append($row);
		$('#pciYear').val('');
		$('#pciCompany').val('');
		$('#pciLosses').prop('checked', false);
		$('#pciDetails').val('');
		$('#pciDriver').val('');
	});

	$(document).on('click', '.removeRow', function () {
		$(this).closest('tr').remove();
	});

	$(document).on('click', '#addDI', function () {
		$driverName = $('#diDriverName').val();
		$DOB = $('#diDOB').val();
		$licenseNumber = $('#diLicenseNumber').val();
		$state = $('#diState').val();
		$dateHired = $('#diDateHired').val();
		$cdlYears = $('#diCDL').val();
		$lastYears = $('#diLastYears').val();
		$accidents = $('#diAccidents').val();
		$suspensions = $('#diSuspensions').val();
		$row = `<tr class='text-start'><td>${$driverName}</td><td>${$DOB}</td><td>${$licenseNumber}</td><td>${$state}</td><td>${$dateHired}</td><td>${$cdlYears}</td><td>${$lastYears}</td><td>${$accidents}</td><td>${$suspensions}</td><td class='text-end'><div class="btn btn-outline-danger fw-bold removeRow"><i class="fa-solid fa-square-minus fa-lg"></i> Remove</div></tr>`;
		$('#diTable tbody').append($row);
		$('#diDriverName').val('');
		$('#diDOB').val('');
		$('#diLicenseNumber').val('');
		$('#diState').val('');
		$('#diDateHired').val('');
		$('#diCDL').val('');
		$('#diLastYears').val('');
		$('#diAccidents').val('');
		$('#diSuspensions').val('');
	});

	$(document).on('click', '#addVI', function () {
		$year = $('#viYear').val();
		$type = $('#viType').val();
		$make = $('#viMake').val();
		$weight = $('#viWeight').val();
		$value = $('#viValue').val();
		$radius = $('#viMiles').val();
		$VIN = $('#viVIN').val();
		$row = `<tr class='text-start'><td>${$year}</td><td>${$type}</td><td>${$make}</td><td>${$weight}</td><td>${$value}</td><td>${$radius}</td><td>${$VIN}</td><td class='text-end'><div class="btn btn-outline-danger fw-bold removeRow"><i class="fa-solid fa-square-minus fa-lg"></i> Remove</div></tr>`;
		$('#viTable tbody').append($row);
		$('#viYear').val('');
		$('#viType').val('');
		$('#viMake').val('');
		$('#viWeight').val('');
		$('#viValue').val('');
		$('#viMiles').val('');
		$('#viVIN').val('');
	});

	$(document).on('click', '#addCargo', function () {
		$commodityTransport = $('#commodityTransport').val();
		$percentTotal = $('#percentTotal').val();
		$averageTruckload = $('#averageTruckload').val();
		$valueTruckload = $('#valueTruckload').val();
		$row = `<tr class='text-start'><td>${$commodityTransport}</td><td>${$percentTotal}</td><td>${$averageTruckload}</td><td>${$valueTruckload}</td><td class='text-end'><div class="btn btn-outline-danger fw-bold removeRow"><i class="fa-solid fa-square-minus fa-lg"></i> Remove</div></tr>`;
		$('#cargoTable tbody').append($row);
		$('#commodityTransport').val('');
		$('#percentTotal').val('');
		$('#averageTruckload').val('');
		$('#valueTruckload').val('');
	});

	$tabCounter = 0;

	$(document).on('click', '#btnPrevious', function () {
		$tabCounter = $('#tabMenu li a.active').data('id');
		if ($tabCounter > 0) {
			$('#tabMenu li a').removeClass('active');
			$(`#tabMenu li:nth-child(${$tabCounter}) a`).addClass('active');
			$li = $(`#tabMenu li:nth-child(${$tabCounter}) a`);
			$('.tab-pane').removeClass('active show');
			$(`${$li.attr('href')}`).addClass('active show');
		}
	});

	$(document).on('click', '#btnNext', function () {
		$tabCounter = $('#tabMenu li a.active').data('id') + 2;
		if ($tabCounter <= 7) {
			$('#tabMenu li a').removeClass('active');
			$(`#tabMenu li:nth-child(${$tabCounter}) a`).addClass('active');
			$li = $(`#tabMenu li:nth-child(${$tabCounter}) a`);
			$('.tab-pane').removeClass('active show');
			$(`${$li.attr('href')}`).addClass('active show');
		}
	});

	$(document).on('click', '#btnStart', function () {
		$('#tabContent').removeClass('d-none');
		$('#agencyInformation').addClass('d-none');
		$('footer').removeClass('d-none');
		$('#startBtns').addClass('d-none');
	});
});
