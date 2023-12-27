<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<div class="row">
    <div class="col-lg-7 col-sm-12 pb-2">
        <div class="border border-2 border-primary p-2 rounded">
            <h4>Detalle Conductor</h4>
            <hr>
            <div class="row">
                <div class="col-lg-6 text-primary">
                    <div class="form-floating mb-3">
                        <input class="form-control rounded border-primary" id="nombreConductor" type="text" placeholder="Nombre">
                        <label class="text-primary" for="nombreConductor">Nombre</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control rounded border-primary" id="licenciaConducir" type="text" placeholder="Nombre">
                        <label class="text-primary" for="licenciaConducir">Licencia</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control rounded border-primary" id="telefono" type="text" placeholder="Nombre">
                        <label class="text-primary" for="telefono">Teléfono</label>
                    </div>
                    <div class="form-check ps-0">
                        <label class="form-check-label float-start ms-0" for="">
                            Tanker Endorsement
                        </label>
                        <input class="form-check-input ms-1 pt-1 text-primary" type="checkbox" value="" id="flexCheckDisabled">
                    </div>
                    <div class="input-group mb-3 mt-1">
                        <input type="file" class="form-control rounded-start text-primary" id="inputGroupFile02">
                        <label class="input-group-text text-primary rounded-end" for="inputGroupFile02">Licencia</label>
                    </div>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control rounded-start text-primary" id="inputGroupFile02">
                        <label class="input-group-text text-primary rounded-end" for="inputGroupFile02">TWIC</label>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img class="img-fluid pb-1" src="https://via.placeholder.com/600x200.png?text=Licencia">
                    <img class="img-fluid pb-1" src="https://via.placeholder.com/600x200.png?text=TWIC">
                </div>
            </div>
            <hr class="text-primary">
            <div class="row">
                <div class="clearfix w-100">
                    <button type="button" class="btn btn-primary float-end">Guardar</button>
                </div>
            </div>

        </div>
    </div>
    <div class="col-lg-4 col-sm-12 pb-2">
        <div class="border border-2 border-primary p-2 rounded h-100">
            <h4>Listado de Conductores</h4>
            <hr>
            <div class="form-floating mb-3">
                <input class="form-control rounded border-primary" id="filtroNombres" type="text" placeholder="Nombre">
                <label class="text-primary" for="filtroNombres">Filtrar Nombres</label>
            </div>
            <hr>
            <table class="table table-striped table-light">
                <thead>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Licencia</th>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Robert</td>
                        <td>571-666-2617</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Tony Aguirre</td>
                        <td>571-707-9885</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Reinier</td>
                        <td>720 546 1178</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Aneudy</td>
                        <td>862-270-7929</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript" src="../js/driver.js"></script>
    <link rel="stylesheet" href="../css/driver.css">