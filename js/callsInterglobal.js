var $months = [
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

$(document).ready(function () {
	var $states = [
		{ All: 'All' },
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
	$('#filterCallState').html($html);

	getNewCall();

	var $today = new Date();
	sessionStorage.setItem('year', $today.getFullYear());
	sessionStorage.setItem('month', $months[$today.getMonth()]);
	sessionStorage.setItem('monthNumber', $today.getMonth());
	$today = $today.getFullYear() + '-' + ($today.getMonth() + 1) + '-' + $today.getDate();

	$(document)
		.off()
		.on('click', '#btnNextBusiness', function () {
			getNewCall(
				$('#filterCallState option:selected').val(),
				$('#filterCallStatus option:selected').val(),
				$('#filterCallType option:selected').val()
			);
			$('.callAgain').removeClass('bg-success');
			$('.btnStatus').removeClass('active');
			$('#callNotes').val('');
			$('#sentMessage').prop('checked', false);
		});

	drawCalendar(sessionStorage.getItem('monthNumber'));

	$(document).on('click', '#btnSearchByPhoneOrDot', function () {
		getBusinessByPhoneOrDot($('#inputSearchByPhoneOrDot').val());
	});

	$(document).on('click', '.btnMenu', function () {
		$('.btnMenu.active').removeClass('active');
		$(this).addClass('active');
		switch ($(this).text()) {
			case 'Calls':
				$('#callCenterInterglobalContenido').load('../views/callsInterglobal.php');
				break;
			case 'Call Log':
				$('#callCenterInterglobalContenido').load('../views/myLeads.php');
				break;
		}
	});

	$(document).on('click', '.fa-forward-fast', function () {
		$monthNumber = sessionStorage.getItem('monthNumber');
		$monthNumber++;
		if ($monthNumber == 12) {
			$monthNumber = 0;
		}
		sessionStorage.setItem('monthNumber', $monthNumber);
		$('#monthLookup').html($months[$monthNumber]);
		drawCalendar($monthNumber);
	});

	$(document).on('click', '.fa-backward-fast', function () {
		$monthNumber = sessionStorage.getItem('monthNumber');
		$monthNumber--;
		if ($monthNumber == -1) {
			$monthNumber = 11;
		}
		sessionStorage.setItem('monthNumber', $monthNumber);
		$('#monthLookup').html($months[$monthNumber]);
		drawCalendar($monthNumber);
	});

	$(document).on('click', '.callAgain', function () {
		$('.callAgain').removeClass('bg-success');
		$(this).addClass('bg-success');
	});

	$(document).on('click', '.btnStatus', function () {
		$('.btnStatus').removeClass('active');
		$(this).addClass('active');
	});

	$(document).on('click', '#btnSaveCall', function () {
		if ($('.btnStatus.active').text() == '') {
			$('#infoModalTitle').html('Error!');
			$('#infoModalText').html('You must select one result for the call Lead/Possible/No Answer...');
			$('#infoModal').modal('show');
			return false;
		}
		$.post('../controllers/CallCenter.php', {
			action: 'saveCall',
			DOT: $('#businessDOT').text(),
			status: $('.btnStatus.active').text(),
			callAgain: $('.callAgain.bg-success').data('fecha'),
			notes: $('#callNotes').val(),
			sentMessage: $('#sentMessage').is(':checked') ? 'true' : 'false',
		}).done(function () {
			$('#infoModalTitle').html('Call Saved!');
			$('#infoModalText').html('Call was saved successfully!!');
			$('#infoModal').modal('show');
			getNewCall(
				$('#filterCallState option:selected').val(),
				$('#filterCallStatus option:selected').val(),
				$('#filterCallType option:selected').val()
			);
			updateReminders();
		});
	});
});

function getNewCall($state, $status, $type) {
	$('#spinner').modal('show');
	$('#businessDOT').html('');
	$('#businessDOT').attr('data-DOT', '');
	$('#businessMC').html('');
	$('#businessName').html('');
	$('#businessAddress').html('');
	$('#businessRep').html('');
	$('#businessState').html('');
	$('#businessPhone').html('');
	$('.btnStatus').removeClass('active');
	$('.callAgain').removeClass('bg-success');
	$('#listDate').html('');
	$('#callNotes').val('');
	$('#sentMessage').prop('checked', false);
	$type = $type || 1;
	$status = $status || 1;
	$state = $state || 'All';
	$.post('../controllers/CallCenter.php', {
		action: 'getNewCall',
		state: $state,
		status: $status,
		type: $type,
	})
		.done(function (resp) {
			if (resp != 'null') {
				resp = JSON.parse(resp);
				$('#businessDOT').html(resp.DOT);
				$('#businessDOT').attr('data-DOT', resp.DOT);
				$('#businessMC').html('MC: ' + resp.Docket);
				$('#businessName').html('Name: ' + resp.Legal_Name);
				$('#businessAddress').html('Address: ' + resp.Business_Address);
				$('#businessRep').html('Rep: ' + resp.Company_Rep1);
				$('#businessState').html('State: ' + resp.Business_State);
				$('#businessPhone').html(
					'+1 (' + resp.Phone.substr(0, 3) + ') ' + resp.Phone.substr(3, 3) + '-' + resp.Phone.substr(6, 4)
				);
				navigator.clipboard
					.writeText(resp.Phone)
					.then(() => {
						console.log('Phone number copied to clipboard');
					})
					.catch((err) => {
						console.error('Could not copy phone number: ', err);
					});
				$('#businessPhone').attr('data-phone', resp.Phone);
				$('#listDate').html('List Date: ' + resp.Upload_Date);
				$('#insuranceName').html('Insurer: ' + resp.Insurer);
				$('#insurancePolicy').html('Policy Number: ' + resp.Policy_Number);
				$('#insuranceType').html('Type: ' + resp.Insurance_Type);
				$('#insuranceExpirationDate').html(
					'Expiration Date: ' +
						shortDate('0000-' + resp.Policy_Expiration_Month + '-' + resp.Policy_Expiration_Day)
				);
				if (resp.Insurer != null) {
					$('#insuranceDetails').removeClass('d-none');
				} else {
					$('#insuranceDetails').addClass('d-none');
				}
				$('#spinner').modal('hide');
				callHistory(resp.DOT);
			} else {
				$('#infoModalTitle').html('No New Ventures!');
				$textString = 'No business profiles were found that match the filters selected';
				$('#infoModalText').html($textString);
				$('#spinner').modal('hide');
				$('#infoModal').modal('show');
			}
		})
		.done(function () {
			updateReminders();
		});
}

function drawCalendar($month) {
	console.log($month);
	var $year = new Date().getFullYear();
	var $htmlString = '';
	$htmlString += '<div class="row p-0">';
	$day = 1;
	$row = 1;
	$contador = 1;
	$firstDay = new Date($year, $month, 1).getDay();
	//$firstDay = $firstDay == 0 ? 7 : $firstDay;
	$totalDays = new Date($year, parseInt($month) + 1, 0).getDate();
	console.log('First Day ' + $firstDay);
	$('#monthLookup').html($months[$month]);
	while ($contador <= $firstDay) {
		$htmlString += '<div class="dia col bg-white p-1"></div>';
		$contador++;
	}
	while ($day <= $totalDays) {
		$htmlString += '<div ';
		$htmlString += 'data-fecha="' + $year + '-' + (parseInt($month) + 1) + '-' + $day + '"';
		$htmlString += 'class="dia col text-black callAgain text-center p-1">';
		/* Aquí va el día */
		$htmlString += $day;
		$htmlString += '</div>';
		if ($contador % 7 == 0) {
			$row++;
			$htmlString += "</div><div class='row p-0'>";
			$contador = 0;
		}
		$day++;
		$contador++;
	}
	$contador--;
	while ($contador % 7 != 0) {
		$htmlString += '<div class="col dia p-1"></div>';
		$contador++;
	}
	$htmlString += '</div>';
	$htmlString += '</div>';
	$('#calendarBody').html($htmlString);
}

function updateReminders() {
	$('#spinner').modal('show');
	$.post('../controllers/CallCenter.php', {
		action: 'getReminders',
	}).done(function (resp) {
		if (resp) {
			resp = JSON.parse(resp);
			$('#tableReminders').html('');
			$.each(resp, function (index, call) {
				$string = '';
				$string += '<tr class="rowReminder"';
				$string += ' data-dot=' + call.dot;
				$string += ' data-agentname="' + call.agentName + '"';
				$string += ' data-businessaddress="' + call.address + '"';
				$string += ' data-phone=' + call.phone;
				$string += ' data-rep="' + call.rep + '"';
				$string += ' data-state="' + call.state + '"';
				$string += ' data-date="' + call.callAgain + '"';
				$string += '>';
				$string += '<td class="small py-1 px-0">' + shortDate(call.callAgain) + '</td>';
				$string += '<td class="small py-1 px-0">' + call.businessName + '</td';
				$string += '</tr>';
				$('#tableReminders').append($string);
			});
		}
		$('#spinner').modal('hide');
	});
}

function shortDate($date) {
	$shortMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	[$ano, $mes, $dia] = $date.split('-');
	$mes = $shortMonths[parseInt($mes) - 1];
	return $mes + ' ' + $dia;
}

function callHistory($dot) {
	$('#spinner').modal('show');
	$.post('../controllers/CallCenter.php', {
		action: 'getCallHistory',
		dot: $dot,
	}).done(function (resp) {
		if (resp) {
			resp = JSON.parse(resp);
			$('#tableCallHistory').html('');
			$.each(resp, function (index, call) {
				switch (call.status) {
					case 'Lead':
						$bg = 'bg-success';
						break;
					case 'Possible Lead':
						$bg = 'bg-info';
						break;
					case 'No Answer':
						$bg = 'bg-warning';
						break;
					case 'Not Interested':
						$bg = 'bg-danger';
						break;
					case 'Black List':
						$bg = 'bg-dark';
						break;
				}
				$string = '';
				$string += '<tr class="text-white ' + $bg + '"';
				$string += ' data-dot=' + call.dot;
				$string += ' data-agentname="' + call.agentName + '"';
				$string += ' data-businessaddress="' + call.address + '"';
				$string += ' data-phone=' + call.phone;
				$string += ' data-rep="' + call.rep + '"';
				$string += ' data-state="' + call.state + '"';
				$string += ' data-callAgainDate="' + (call.callAgain || '0000-00-00') + '"';
				$string += ' data-date="' + call.date + '"';
				$string += ' data-sentMessage="' + call.sentMessage + '"';
				$string += ' data-status="' + call.status + '"';
				$string += ' data-notes="' + call.notes + '"';
				$string += ' >';
				$string += '<td class="rounded-start border-0">' + shortDate(call.date) + '</td>';
				$string +=
					'<td class="rounded-end border-0">' + (call.notes == null ? 'No notes' : call.notes) + '</td>';
				$string += '</tr>';
				$('#tableCallHistory').append($string);
			});
		}
	});
}

function getBusinessByPhoneOrDot($searchParam) {
	if (!$searchParam) {
		$('#infoModalTitle').html('Error!!');
		$('#infoModalText').html('You have to input a phone number or DOT to search for');
		$('#infoModal').modal('show');
	} else {
		$.post('../controllers/CallCenter.php', {
			action: 'checkIfExists',
			param: $searchParam,
		}).done(function (resp) {
			if (resp != 0) {
				$('#inputSearchByPhoneOrDot').val('');
				getNewCall(resp);
			} else {
				$('#infoModalTitle').html('Error!!');
				$('#infoModalText').html('No Company was found on our Lists with that phone number or DOT');
				$('#infoModal').modal('show');
			}
		});
	}
}

$('.clickableCalls').on('click', 'tr', function () {
	getNewCall($(this).data('dot'));
});

$('.clickableCallHistory').on('click', 'tr', function () {
	$('#infoModalTitle').html('Call Details');
	$string = "<table class='table table-borderless border rounded'>";
	$string += '<tbody>';
	$string += '<tr>';
	$string += '<td>Date:</td>';
	$string += '<td>' + shortDate($(this).data('date')) + '</td>';
	$string += '</tr>';
	$string += '<tr>';
	$string += '<td>Caller:</td>';
	$string += '<td>' + $(this).data('agentname') + '</td>';
	$string += '</tr>';
	$string += '<tr>';
	$string += '<td>Status:</td>';
	$string += '<td>' + $(this).data('status') + '</td>';
	$string += '</tr>';
	$string += '<tr>';
	$string += '<td>Notes:</td>';
	$string += '<td>' + ($(this).data('notes') == null ? 'No notes' : $(this).data('notes')) + '</td>';
	$string += '</tr>';
	$string += '<tr>';
	$string += '<td>Sent Message:</td>';
	$string += '<td>' + ($(this).data('sentmessage') == 'f' ? 'No' : 'Yes') + '</td>';
	$string += '</tr>';
	$string += '<tr>';
	$string += '<td>Call Again:</td>';
	$string +=
		'<td>' +
		($(this).data('callagaindate') == '0000-00-00' ? 'No' : shortDate($(this).data('callagaindate'))) +
		'</td>';
	$string += '</tr>';
	$string += '</tbody>';
	$string += '</table>';
	$('#infoModalText').html($string);
	$('#infoModal').modal('show');
});

$(document).on('click', '#businessPhone', function (element) {
	alert('Phone Number copied to clipboard');
	var $temp = $('<input>');
	$('body').append($temp);
	$temp.val($(element).text()).select();
	document.execCommand('copy');
	$temp.remove();
});
