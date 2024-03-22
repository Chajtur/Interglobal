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

var $flag = false;

$('body').on('keyup', function (e) {
	if (e.ctrlKey && e.key == 'q') {
		getNewCall(
			$('#filterCallState option:selected').val(),
			$('#filterCallStatus option:selected').val(),
			$('#filterCallType option:selected').val()
		);
		$('.callAgain').removeClass('bg-green-800');
		$('.btnStatus').removeClass('active');
		$('#callNotes').val('');
		$('#sentMessage').prop('checked', false);
	}
});

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
			$('.callAgain').removeClass('bg-green-800');
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
		$('.callAgain').removeClass('bg-green-800 text-white');
		$('.callAgain').addClass('text-black');
		$(this).addClass('bg-green-800 text-white');
		$(this).removeClass('text-black');
	});

	$(document).on('click', '.btnStatus', function () {
		$('.btnStatus').removeClass('active');
		$(this).addClass('active');
	});

	$(document).on('click', '#btnSaveCall', function () {
		if ($('.btnStatus.active').text() == '') {
			$('#infoModalTitle').html('Error!');
			$('#infoModalText').html('You must select one result for the call Lead/Possible/No Answer...');
			$('#infoModalTitle').parent().removeClass();
			$('#infoModalTitle').parent().addClass('modalTitle bg-red-400');
			modalShow('infoModal');
			return false;
		}
		$.post('../controllers/CallCenter.php', {
			action: 'saveCall',
			DOT: $('#businessDOT').text(),
			status: $('.btnStatus.active').text(),
			callAgain: $('.callAgain.bg-green-800').data('fecha'),
			notes: $('#callNotes').val(),
			sentMessage: $('#sentMessage').is(':checked') ? 'true' : 'false',
		}).done(function () {
			$('#infoModalTitle').html('Call Saved!');
			$('#infoModalText').html('Call was saved successfully!!');
			$('#infoModalTitle').parent().removeClass();
			$('#infoModalTitle').parent().addClass('modalTitle bg-green-400');
			modalShow('infoModal');
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
	modalShow('spinner');
	$('#businessDOT').html('');
	$('#businessDOT').attr('data-DOT', '');
	$('#businessMC').html('');
	$('#businessName').html('');
	$('#businessAddress').html('');
	$('#businessRep').html('');
	$('#businessState').html('');
	$('#businessPhone').html('');
	$('.btnStatus').removeClass('active');
	$('.callAgain').removeClass('bg-green-800');
	$('.callAgain').removeClass('text-white');
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
				$('#businessMC').html('Email: ' + (resp.Email == null ? 'Not Provided' : resp.Email));
				$('#businessName').html('Name: ' + resp.Legal_Name);
				$('#businessAddress').html('Address: ' + resp.Business_Address);
				$('#businessRep').html('Rep: ' + (resp.Company_Rep1 == null ? 'Not Provided' : resp.Company_Rep1));
				$('#businessState').html('State: ' + resp.Business_State);
				$('#businessPhone').html(
					'+1 (' + resp.Phone.substr(0, 3) + ') ' + resp.Phone.substr(3, 3) + '-' + resp.Phone.substr(6, 4)
				);
				$('#businessPhoneLink').attr('href', 'tel:+1' + resp.Phone);
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
				$year = new Date(resp.Upload_Date).getFullYear();
				if (resp.Insurer != null) {
					$effectiveDate =
						resp.Policy_Effective_Date == '0000-00-00'
							? 'Not Provided'
							: shortDate(resp.Policy_Effective_Date);
					$expirationDate =
						resp.Policy_Expiration_Date == '0000-00-00'
							? shortDate($year + '-' + resp.Policy_Expiration_Month + '-' + resp.Policy_Expiration_Day)
							: shortDate(resp.Policy_Expiration_Date);
					$('#insuranceType').html('Effective Date: ' + $effectiveDate);
					console.log($year);
					$('#insuranceExpirationDate').html('Expiration Date: ' + $expirationDate);
					$('#insuranceDetails').removeClass('hidden');
				} else {
					$('#insuranceDetails').addClass('hidden');
				}
				modalHide('spinner');
				callHistory(resp.DOT);
			} else {
				$('#infoModalTitle').html('No New Ventures!');
				$('#infoModalTitle').parent().removeClass();
				$('#infoModalTitle').parent().addClass('modalTitle bg-red-400');
				$textString = 'No business profiles were found that match the filters selected';
				$('#infoModalText').html($textString);
				modalHide('spinner');
				modalShow('infoModal');
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
	$htmlString += '<div class="flex flex-row p-0">';
	$day = 1;
	$row = 1;
	$contador = 1;
	$firstDay = new Date($year, $month, 1).getDay();
	$totalDays = new Date($year, parseInt($month) + 1, 0).getDate();
	console.log('First Day ' + $firstDay);
	$('#monthLookup').html($months[$month]);
	while ($contador <= $firstDay) {
		$htmlString += '<div class="dia bg-white p-1"></div>';
		$contador++;
	}
	while ($day <= $totalDays) {
		$htmlString += '<div ';
		$htmlString += 'data-fecha="' + $year + '-' + (parseInt($month) + 1) + '-' + $day + '"';
		$htmlString += 'class="dia callAgain text-center p-1 h-10">';
		/* Aquí va el día */
		$htmlString += $day;
		$htmlString += '</div>';
		if ($contador % 7 == 0) {
			$row++;
			$htmlString += "</div><div class='flex flex-row p-0'>";
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
	modalShow('spinner');
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
		modalHide('spinner');
	});
}

function shortDate($date) {
	$shortMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	[$ano, $mes, $dia] = $date.split('-');
	$mes = $shortMonths[parseInt($mes) - 1];
	return $mes + ' ' + $dia + ' ' + $ano;
}

function callHistory($dot) {
	modalShow('spinner');
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
						$bg = 'bg-green-800';
						break;
					case 'Possible Lead':
						$bg = 'bg-sky-950';
						break;
					case 'No Answer':
						$bg = 'bg-yellow-500';
						break;
					case 'Not Interested':
						$bg = 'bg-red-700';
						break;
					case 'Black List':
						$bg = 'bg-black';
						break;
				}
				$string = '';
				$string += '<tr class="text-white rounded ' + $bg + '"';
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
		$('#infoModalTitle').parent().removeClass();
		$('#infoModalTitle').parent().addClass('modalTitle bg-red-400');
		modalShow('infoModal');
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
				$('#infoModalTitle').parent().removeClass();
				$('#infoModalTitle').parent().addClass('modalTitle bg-red-400');
				modalShow('infoModal');
			}
		});
	}
}

$('.clickableCalls').on('click', 'tr', function () {
	getNewCall($(this).data('dot'));
});

$('.clickableCallHistory').on('click', 'tr', function () {
	switch ($(this).data('status')) {
		case 'Lead':
			$bg = 'text-green-800';
			break;
		case 'Possible Lead':
			$bg = 'text-sky-950';
			break;
		case 'No Answer':
			$bg = 'text-yellow-500';
			break;
		case 'Not Interested':
			$bg = 'text-red-700';
			break;
		case 'Black List':
			$bg = 'text-black';
			break;
	}
	$('#infoModalTitle').html('Call Details');
	$('#infoModalTitle').parent().removeClass();
	$('#infoModalTitle').parent().addClass('modalTitle bg-blue-500');
	$string = "<table class='table w-full border-2 rounded-lg border-blue-500'>";
	$string += '<tbody>';
	$string += '<tr class="border-b">';
	$string += '<td class="p-2">Date:</td>';
	$string += '<td>' + shortDate($(this).data('date')) + '</td>';
	$string += '</tr>';
	$string += '<tr class="border-b">';
	$string += '<td class="p-2">Caller:</td>';
	$string += '<td>' + $(this).data('agentname') + '</td>';
	$string += '</tr>';
	$string += '<tr class="border-b">';
	$string += '<td class="p-2">Status:</td>';
	$string += '<td class="' + $bg + '">' + $(this).data('status') + '</td>';
	$string += '</tr>';
	$string += '<tr class="border-b">';
	$string += '<td class="p-2">Notes:</td>';
	$string += '<td>' + ($(this).data('notes') == null ? 'No notes' : $(this).data('notes')) + '</td>';
	$string += '</tr>';
	$string += '<tr class="border-b">';
	$string += '<td class="p-2">Sent Message:</td>';
	$string +=
		'<td class="p-2 ' +
		($(this).data('sentmessage') == 'f' ? 'text-red-800' : 'text-green-800') +
		'">' +
		($(this).data('sentmessage') == 'f' ? 'No' : 'Yes') +
		'</td>';
	$string += '</tr>';
	$string += '<tr class="border-b">';
	$string += '<td class="p-2">Call Again:</td>';
	$string +=
		'<td class="' +
		($(this).data('callagaindate') == '0000-00-00' ? 'text-red-800' : 'text-green-800') +
		'">' +
		($(this).data('callagaindate') == '0000-00-00' ? 'No' : shortDate($(this).data('callagaindate'))) +
		'</td>';
	$string += '</tr>';
	$string += '</tbody>';
	$string += '</table>';
	$('#infoModalText').html($string);
	modalShow('infoModal');
});

$(document).on('click', '#businessPhone', function (element) {
	alert('Phone Number copied to clipboard');
	var $temp = $('<input>');
	$('body').append($temp);
	$temp.val($(element).text()).select();
	document.execCommand('copy');
	$temp.remove();
});
