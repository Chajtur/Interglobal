$(document).ready(function () {
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

	$('#insuredDOT').on('focusout', function () {
		$('#spinner').modal('show');
		$.get('../controllers/Load.php', {
			action: 'generalDotWeb',
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
				modalHide('spinner');
				$('#ownersName').focus();
			} else {
				modalHide('spinner');
				$('#insuredMC').focus();
			}
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
				modalHide('spinner');
				$('#ownersName').focus();
			}
			modalHide('spinner');
		});
	});

	$('#sameAddress').on('change', function() {
		if ($(this).is(':checked')) {
			$('#parkingAddress').addClass('d-none');
		} else {
			$('#parkingAddress').removeClass('d-none');
		}
	})

	$('#requestQuote').on('click', function () {
        $proposedDate = $('#rfpProposedDate').val();
		$dot = $('#insuredDOT').val();
		$mc = $('#insuredMC').val();
		$name = $('#insuredName').val();
		$ownersName = $('#ownersName').val();
		$address = $('#insuredAddress').val();
		$city = $('#insuredCity').val();
		$state = $('#insuredState').val();
		$zip = $('#insuredZipCode').val();
		$email = $('#insuredEmail').val();
		$phone = $('#insuredPhone').val();
		$driversLicense = $('#insuredDriverLicense').val();
		$.post('../controllers/Quote.php', {
            proposedDate : $proposedDate,
			dot: $dot,
			mc: $mc,
            name : $name,
            ownersName : $ownersName,
            address : $address,
            city : $city,
            state : $state,
            zip : $zip,
            email : $email,
            phone : $phone,
            driversLicense : $driversLicense,
			action: 'newQuote',
		}).done(function (resp) {
            if (resp = 1) {
                $('#quoteSuccess').modal('show');
            } else {
                alert('Error');
            }
        });
	});
	
});
