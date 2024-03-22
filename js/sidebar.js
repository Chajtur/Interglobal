$(document).ready(function () {

	let resizeObserver = new ResizeObserver(() => { 
		if ($('sidebar').width() >= 140) {
			$('.sidebar-text').css('display', 'inline');
			console.log('Sidebar width: ' + $('sidebar').width());
		} else {
			$('.sidebar-text').css('display', 'none');
			console.log('Sidebar width: ' + $('sidebar').width());
		}
	}); 
	  
	let $div = document.querySelector('sidebar');

	if($div !== null){
		resizeObserver.observe($div);
	} else {
		console.log('No existe el elemento .sidebar');
	}

	$('sidebar .icon').on('click', function () {
		$('sidebar .icon').removeClass('active');
		$(this).addClass('active');
		loadContent($(this).data('module'));
	});

	$('.rounded-div').on('click', function () {
		$('.icon-group[data-id=' + $(this).data('id') + ']').slideToggle();
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

	$('#logOut').on('click', function () {
		$.post('../controllers/Login.php', {
			action: 'logout',
		}).done(function (resp) {
			window.location.href = 'index.php';
		});
	});

});
