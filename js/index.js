$(document).ready(function () {
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});
});

$(document).on('click', '.modalClose', function () {
	console.log('Closing modal');
	$(this).closest('.modal').addClass('hidden');
});

function modalShow($modal) {
	$("#" + $modal).removeClass('hidden');
}

function modalHide($modal) {
	$("#" + $modal).addClass('hidden');
}

$("#menuSwipe").on("swipe",function(){
	$(sidebar).toggleClass('hidden');
  });