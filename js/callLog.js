$(document).ready(function () {
	$.post('../controllers/CallCenter.php', {
		action: 'getAgents',
	}).done(function (resp) {
		resp = JSON.parse(resp);
		$.each(resp, function (index, agent) {
			$string = '<option value =' + agent.id + '>' + agent.name + '</option>';
			$('#filterCallAgent').append($string);
		});
	});

	loadCallLog('All', 'Any', 'All');

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
});

function loadCallLog($agent, $status, $state) {
	$('#spinner').modal('show');
	$.post('../controllers/CallCenter.php', {
		action: 'getCalls',
		state: $state,
		agent: $agent,
		status: $status,
	}).done(function (resp) {
		resp = JSON.parse(resp);
		$string = '';
		$.each(resp, function (index, call) {
			switch (call.status) {
				case 'Lead':
					$bg = 'text-success';
					break;
				case 'Possible Lead':
					$bg = 'text-primary';
					break;
				case 'No Answer':
					$bg = 'text-warning';
					break;
				case 'Not Interested':
					$bg = 'text-danger';
					break;
				case 'Black List':
					$bg = 'text-dark';
					break;
                default:
                    case 'Lead':
                    $bg = 'text-info';
                    break;
			}
			$string += '<tr class="small py-1 px-0 ' + $bg + '" ';
			$string += ' data-dot=' + call.dot;
			$string += ' data-idcall=' + call.idCall;
			$string += ' data-agentname=' + call.agentName;
			$string += ' data-businessaddress=' + call.address;
			$string += ' data-phone=' + call.phone;
			$string += ' data-rep=' + call.rep;
			$string += ' data-state=' + call.state;
			$string += ' data-date=' + call.date;
			$string += '>';
			$string += '<td class="text-nowrap">' + shortDate(call.shortDate) + '</td>';
			$string += '<td>' + call.businessName + '</td>';
			$string += '<td>' + (call.note ? call.note : 'None') + '</td>';
			$string += '<td>' + (call.sentMessage == 'f' ? 'No' : "Yes") + '</td>';
			$string += '<td>' + (call.callAgain ? call.callAgain : 'No') + '</td>';
			$string += '</tr>';
		});
		$('#callLogTable').html($string);
		modalHide('spinner');
	});
}

$('#btnLoadCallLog').click(function () {
	$state = $('#filterCallState option:selected').val();
	$agent = $('#filterCallAgent option:selected').val();
	$status = $('#filterCallStatus option:selected').text();
	loadCallLog($agent, $status, $state);
});
