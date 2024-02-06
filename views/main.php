<?php

include_once '../models/User.php';
include_once '../controllers/Login.php';

startSession();
checkActivity();

?>

<body class="d-flex vh-100 vw-100">
    <sidebar class="col-lg-auto d-none min-vh-100 shadow-lg">
        <?php include 'sidebar.php'; ?>
    </sidebar>
    <content class="d-flex flex-column h-100 w-100">
        <div>
            <?php include '../components/menu.php'; ?>
            <content class="h-100" id="contenido">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <h1 class="text-center">Welcome to Interglobal Insurance</h1>
                        </div>
                    </div>
                </div>
            </content>
        </div>
        <footer class="footer mt-auto w-100 d-none">
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
                    <p>Tu sesión ha expirado debido a inactividad, deberás volver a iniciar sesión</p>
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
                    <h5 class="modal-title">Sesión Expirada</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">
                    <p>Tu sesión ha expirado debido a inactividad, deberás volver a iniciar sesión</p>
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