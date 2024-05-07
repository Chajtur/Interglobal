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
$('#modalClose').on('click', function() {
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

$('#infoModal').click(function() {
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