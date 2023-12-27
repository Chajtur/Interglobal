<script src="../js/vin.js"></script>
<link rel="stylesheet" href="../css/vin.css">
<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<div class="row text-center">
    <div class="col-md-4 col-sm-12 mx-auto justify-content-center">
        <div class="form-floating mb-3 w-75 mx-auto">
            <input class="form-control rounded border-primary" id="vinSearch" type="text" placeholder="VIN #">
            <label class="text-primary" for="vinSearch">Ingrese el VIN a buscar</label>
        </div>
        <button class="btn btn-info" id="vinSearchBtn">Cargar</button>
        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <thead>
                    <th>Propiedad</th>
                    <th>Valor</th>
                </thead>
                <tbody id="vinTable"></tbody>
            </table>
        </div>
    </div>
</div>