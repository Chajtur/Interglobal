<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common.php';
startSession();
checkActivity();

?>
<sidebar class="flex-col h-screen bg-sky-950 shadow-xl shadow-indigo-600 hidden md:flex">
    <?php include 'sidebar.php'; ?>
</sidebar>
<content class="flex flex-col h-full w-full">
    <div id="menuSwipe" class="w-full h-1"></div>
    <content class="h-full overflow-y-auto" id="contenido">
        <div class="w-full">
            <div class="flex-row">
                <div class="text-center">
                    <img src="../assets/logo-small.png" alt="" class="mx-auto">
                </div>
            </div>
        </div>
    </content>
    <footer class="footer mt-auto w-full hidden">
        <?php include 'footer.php'; ?>
    </footer>
</content>

<!-- Modal for general information -->
<div class="fixed z-10 inset-0 overflow-y-auto hidden modal bg-gray-300 bg-opacity-60" tabindex="-1" id="infoModal">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="modalTitle">
                <h3 class="text-lg leading-6 font-medium" id="infoModalTitle"></h3>
                <button id="modalClose" type="button" class="absolute right-0 top-0 m-3 border-2 modalClose"><i
                        class="fa fa-solid fa-close"></i></button>
            </div>
            <div class="px-4 py-5 sm:p-6" id="infoModalText">
                <p>Your session has expired due to inactivity, you will need to log in again to continue.</p>
            </div>
            <div class="bg-white border-t px-4 py-3 sm:px-6 sm:flex justify-end" id="infoModalButtons">
                <button type="button" class="w-full btn-info sm:ml-3 sm:w-auto sm:text-sm modalClose">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para avisar cierre de sesión -->
<div class="fixed z-10 inset-0 overflow-y-auto hidden modal bg-gray-300" tabindex="-1" id="sesionExpirada">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="modalTitle bg-red-800">
                <h3 class="text-lg leading-6 font-medium" id="infoModalTitle">Session has expired</h3>
                <button type="button" class="absolute right-0 top-0 m-3 border-2 modalClose" aria-label="Close"><i
                        class="fa fa-solid fa-close"></i></button>
            </div>
            <div class="px-4 py-5 sm:p-6" id="infoModalText">
                <p>Your session has expired due to inactivity, you will need to log in again to continue.</p>
            </div>
            <div class="bg-white border-t px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse" id="infoModalButtons">
                <button type="button" class="w-full btn-info sm:ml-3 sm:w-auto sm:text-sm modalClose">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for loading spinner -->
<div class="fixed z-40 inset-0 overflow-y-auto modal hidden bg-gray-300" id="spinner" tabindex="-1" role="dialog"
    aria-labelledby="spinnerLabel">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white z-50 rounded-lg text-center overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="p-6">
                <div class="animate-spin rounded-full mx-auto h-24 w-24 border-t-4 border-b-4 border-sky-950"></div>
                <div class="text-sky-950 mt-4">
                    <p>Please wait while we fetch your data<br><br><span class="font-bold text-sm">Interglobal Insurance
                            / US Trucking for Hire</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast for quick notifications -->
<div id="liveToast" class="toast-container z-50 fixed top-2 left-1/2 transform -translate-x-1/2 hidden">
    <div class="toast rounded-lg w-full text-white" role="alert" aria-live="assertive" aria-atomic="true"
        data-autohide="true" data-delay="5000" data-animation="true">
        <div class="toast-header">
            <h4>Error</h4>
            <button type="button" class="absolute py-1 px-2 m-3 right-0 top-0 border-2 toastClose" aria-label="Close"><i
                    class="fa fa-solid fa-close"></i></button>
        </div>
        <div class="toast-body mt-2">
            Commission percentage must be between 5 and 40
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
        clearInterval(checkUser);
        checkUser = setInterval(checkUser, 30000);
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

    var observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            if (mutation.attributeName === "class") {
                var element = mutation.target;
                if (element.classList.contains("hidden")) {
                    window.location.href = "index.php";
                }
            }
        });
    });

    var element = document.querySelector("#sesionExpirada");
    observer.observe(element, {
        attributes: true
    });
</script>