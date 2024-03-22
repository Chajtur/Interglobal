<?php

include_once '../models/User.php';
include_once '../controllers/Login.php';

startSession();
checkActivity();

?>

<body class="flex h-screen w-screen bg-white">
    <sidebar class="flex-col h-screen bg-gradient-to-r from-blue-800/75 to-sky-950 shadow-xl shadow-indigo-600 hidden md:flex">
        <?php include 'sidebar.php'; ?>
    </sidebar>
    <content class="flex flex-col h-full w-full">
        <div id="menuSwipe" class="w-full h-1"></div>
        <content class="h-full" id="contenido">
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
    <div class="fixed z-10 inset-0 overflow-y-auto hidden modal bg-gray-300 bg-opacity-20" tabindex="-1" id="infoModal">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
                <div class="modalTitle">
                    <h3 class="text-lg leading-6 font-medium" id="infoModalTitle"></h3>
                    <button type="button" class="absolute right-0 top-0 m-3 border-2 modalClose" aria-label="Close"><i class="fa fa-solid fa-close"></i></button>
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
    <div class="fixed z-10 inset-0 overflow-y-auto hidden modal bg-gray-300 bg-opacity-20" tabindex="-1" id="sesionExpirada">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
                <div class="modalTitle">
                    <h3 class="text-lg leading-6 font-medium" id="infoModalTitle">Session has expired</h3>
                    <button type="button" class="absolute right-0 top-0 m-3 border-2 modalClose" aria-label="Close"><i class="fa fa-solid fa-close"></i></button>
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
    <div class="fixed z-10 inset-0 overflow-y-auto hidden modal" id="spinner" tabindex="-1" role="dialog" aria-labelledby="spinnerLabel">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg text-center overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
                <div class="p-6">
                    <div class="animate-spin rounded-full mx-auto h-24 w-24 border-t-4 border-b-4 border-sky-950"></div>
                    <div class="text-sky-950 mt-4">
                        <p>Please wait while we fetch your data<br><br><span class="font-bold text-sm">Interglobal Insurance / US Trucking for Hire</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    $(document).on('click', '.modalClose', function () {
	console.log('Closing modal');
	$(this).closest('.modal').addClass('hidden');
});
</script>