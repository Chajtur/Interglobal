<script src="../js/quotes.js"></script>
<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<script>
    $.get('../Controllers/Login.php', {
        action: 'getEmployeeInfo'
    }).done(function (resp) {
        $user = JSON.parse(resp);
        loadQuotes($user.id);
    });
</script>

<div class="row mt-5">
    <div class="col-lg-4">
        <h4>Cotizaciones Pendientes</h4>
        <table class="table table-striped">
            <thead>
                <th>Fecha Cotización</th>
                <th>Nombre</th>
                <th>Estado</th>
            </thead>
            <tbody id="tableQuotes">

            </tbody>
        </table>
    </div>
    <div class="col-lg-4 offset-1">
        <h4>Detalle de Solicitud de Cotización</h4>
        <table id="tableDetail" class="table table-striped">

        </table>
    </div>
</div>