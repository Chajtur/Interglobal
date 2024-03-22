modalShow('spinner');

$(document).ready(function () {
	$('#nombreModulo').text('Call Center');
	$('#nombreModuloM').text('Call Center');

	$('.btnMenu').click(function () {
		$('.btnMenu.active').removeClass('active');
		$(this).addClass('active');
		switch ($(this).text()) {
			case 'Calls':
				$('#callCenterInterglobalContenido').load('../views/callsInterglobal.php');
				break;
			case 'Call Log':
				$('#callCenterInterglobalContenido').load('../views/callLog.php');
				break;
            case 'Lists':
                $('#callCenterInterglobalContenido').load('../views/lists.php');
				break;
		}
	});

	modalHide('spinner');
});

$('.clickableCalls').on('click','tr', function() {
	getNewCall($(this).data('dot'));
});

$('#callCenterInterglobalContenido').load('../views/callsInterglobal.php');
