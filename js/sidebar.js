$(document).ready(function () {
	$('.nav-pills').click(function () {
		$('sidebar li').removeClass('active');
		$(this).addClass('active');
		loadContent($(this).data('module'));
		$('sidebar').addClass('d-none');
		$('sidebar').removeClass('position-absolute');
		$('sidebar').removeClass('bg-white');
		$('.overlay').removeClass('active');
	});

	$('#btnCloseSidebar').on('click', function () {
		$('sidebar').addClass('d-none');
		$('sidebar').removeClass('position-absolute');
		$('sidebar').removeClass('bg-white');
		$('.overlay').removeClass('active');
	});

	function loadContent($modulo) {
		switch ($modulo) {
			case 'MyPolicies':
				$('#contenido').load('../views/myPolicies.php');
				break;
			case 'VIN':
				$('#contenido').load('../views/vin.php');
				break;
			case 'RFP':
				$('#contenido').load('../views/rfp.php');
				break;
			case 'Quotes':
				$('#contenido').load('../views/quotes.php');
				break;
			case 'Calendario':
				$('#contenido').load('../views/calendar.php');
				break;
			case 'Content':
				$('#contenido').load('../views/content.php');
				break;
			case 'eticket':
				$('#contenido').load('../views/eticket.php');
				break;
			case 'driver':
				$('#contenido').load('../views/driver.php');
				break;
			case 'truck':
				$('#contenido').load('../views/truck.php');
				break;
			case 'load':
				$('#contenido').load('../views/load.php');
				break;
			case 'safer':
				$('#contenido').load('../views/safer.php');
				break;
			case 'CallCenterInter':
				$('#contenido').load('../views/callCenterInterglobal.php');
				break;
			case 'Dashboard':
				$('#contenido').load('../views/dashboardAgent.php');
				break;
			default:
				$('#contenido').load('../views/content.php');
				break;
		}
	}

	$('#liCerrarSesion').on('click', function () {
		$.post('../controllers/Login.php', {
			action: 'logout',
		}).done(function (resp) {
			window.location.href = 'index.php';
		});
	});

	$(document).on('click', '#interglobalUlBtn', function() {
		if ($('#interglobalUl').hasClass('d-none')) {
			$('#interglobalUl').removeClass('d-none');
		} else {
			$('#interglobalUl').addClass('d-none');
		}
	});

	$(document).on('click', '#usTruckingUlBtn', function() {
		if ($('#usTruckingUl').hasClass('d-none')) {
			$('#usTruckingUl').removeClass('d-none');
		} else {
			$('#usTruckingUl').addClass('d-none');
		}
	})

});
