<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Login.php';
startSession();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!doctype html>

<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"
		integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
	<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.3/dist/chart.umd.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
	<script src="https://kit.fontawesome.com/55b2ee1815.js" crossorigin="anonymous"></script>
	<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

	<link rel="stylesheet" href="../css/tailwind.css">
	<link rel="stylesheet" href="../css/index.css">

	<title>
		INTERGLOBAL INSURANCE CO. | US TRUCKING FOR HIRE
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<link rel="icon"
		href="https://interglobalus.com/wp-content/uploads/2021/12/cropped-LOGO-INTERGLOBAL-01-270x270.png">
</head>

<body id="allContent" class="flex h-screen w-screen bg-slate-100">
	<?php
	if (isset($_SESSION['isLoggedIn']))
	{
		if ($_SESSION['isLoggedIn'] != true)
		{
			include 'login.php';
		} else
		{
			include 'main.php';
		}
	} else
	{
		include 'login.php';
	}
	?>
</body>

<script>
	$(document).ready(function () {
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
		});
		clearInterval(checkUser);
		checkUser = setInterval(checkUser, 30000);
	});

	$(document).on('click', '.modalClose', function () {
		console.log('Closing modal');
		$(this).closest('.modal').addClass('hidden');
	});

	// Add a click event listener directly to the #modalClose button
	$('#modalClose').on('click', function () {
		console.log('Modal close button clicked');
		$(this).closest('.modal').addClass('hidden');
	});

	function modalShow($modal) {
		$('#' + $modal).removeClass('hidden');
	}

	function modalHide($modal) {
		$('#' + $modal).addClass('hidden');
	}

	function toast($message, $type) {
		switch ($type) {
			case 'success':
				$bg = 'bg-green-800';
				$title = 'Success';
				break;
			case 'error':
				$bg = 'bg-red-800';
				$title = 'Error';
				break;
			case 'warning':
				$bg = 'bg-yellow-800';
				$title = 'Warning';
				break;
			default:
				$bg = 'bg-blue-800';
				$title = 'Information';
				break;
		}
		$('#liveToast h4').text($title);
		$('#liveToast .toast').removeClass().addClass('toast p-4 rounded-lg w-full text-white ' + $bg);
		$('#liveToast .toast-body').text($message);
		$('#liveToast').removeClass('hidden');
		$('#liveToast').slideDown(400);
		setTimeout(function () {
			$('#liveToast').slideUp(400);
			$('#liveToast').addClass('hidden');
		}, 5000);
	}

	$('.toastClose').on('click', function () {
		$('#liveToast').slideUp(400);
		$('#liveToast').addClass('hidden');
	});

	$('#infoModal').click(function () {
		if ($('#infoModalTitle').parent().hasClass('successMessage')) {
			modalHide('infoModal');
		}
	});

	$('#menuSwipe').on('swipe', function () {
		$(sidebar).toggleClass('hidden');
	});

	function checkUser() {
		console.log('Checking if user is logged in...');
		$.post('../controllers/Login.php', {
			action: 'isLoggedIn',
		}).done(function (resp) {
			console.log(resp);
			if (resp == 0) {
				modalShow('sesionExpirada');
				location.reload();
			}
		});
	}
</script>