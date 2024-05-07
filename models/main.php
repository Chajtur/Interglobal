<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common.php';

startSession();
checkActivity();

?>

<body class="flex flex-row w-screen h-screen bg-slate-100">
    <sidebar class="lg:w-auto h-screen">
        <?php include 'sidebar.php'; ?>
    </sidebar>
    <content class="flex flex-col h-full w-full">
        <content class="h-full" id="contenido">
            <div class="container-fluid">
                <div class="flex-row">
                    <div class="text-center">
                        <img src="../assets/logo-small.png" alt="">
                    </div>
                </div>
            </div>
        </content>
        <footer class="footer mt-auto w-full hidden">
            <?php include 'footer.php'; ?>
        </footer>
    </content>

    <!-- Modal para información general -->
    <div class="modal" tabindex="-1" id="infoModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="infoModalText">
                    <p>Your session has expired due to inactivity, you will need to log in again to continue.</p>
                </div>
                <div class="modal-footer" id="infoModalButtons">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para avisar cierre de sesión -->
    <div class="modal" tabindex="-1" id="sesionExpirada">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Session has expired</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">
                    <p>Your session has expired due to inactivity, you will need to log in again to continue.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de espera mientras cargan datos -->
    <div class="modal fade" id="spinner" tabindex="-1" role="dialog" aria-labelledby="spinnerLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="spinner-border text-info" style="width: 4rem; height:4rem"></div>
                    <div clas="text-primary">
                        <p>Please wait while we fetch your data<br><br><small class="fw-bold">Interglobal Insurance / US Trucking for Hire</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>