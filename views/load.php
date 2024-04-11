<div class="row">
    <div class="col-lg-4">
        <div class="border rounded border-primary p-3">
            <div id="testData" class="h4 text-info">Detalle Corredora</div>
            <div class="form-floating mb-3">
                <input class="form-control rounded border-primary" id="searchText" type="text" placeholder="Nombre">
                <label class="text-primary" for="searchText">Ingrese el dato a buscar</label>
            </div>
            <div class="text-info h5">
                Buscar por:
            </div>
            <div class="btn-group" role="group" aria-label="Buscar Por">
                <button type="button" class="btn btn-info" id="mcSearch">MC</button>
                <button type="button" class="btn btn-info" id="dotSearch">DOT</button>
            </div>
            <hr>
            <div class="fs-6">
                <p class="my-7">
                    <span class="label border border-1 rounded-start border-info bg-info p-2 text-white">Estatus de Operación: </span><span id="estatusOperacion" class="border rounded-end border-1 border-info text-info p-2"></span>
                </p>
                <p class="my-7">
                    <span class="label border border-1 rounded-start border-info bg-info p-2 text-white">Nombre Legal: </span><span id="nombreLegal" class="border rounded-end border-1 border-info text-info p-2"></span>
                </p>
                <p class="my-7">
                    <span class="label border border-1 rounded-start border-info bg-info p-2 text-white">Estado: </span><span id="estado" class="border rounded-end border-1 border-info text-info p-2"></span>
                </p>
                <p class="my-7">
                    <span class="label border border-1 rounded-start border-info bg-info p-2 text-white">USDOT: </span><span id="usDot" class="border rounded-end border-1 border-info text-info p-2"></span>
                </p>
                <p class="my-7">
                    <span class="label border border-1 rounded-start border-info bg-info p-2 text-white">MC/MX/FF: </span><span id="mc" class="border rounded-end border-1 border-info text-info p-2"></span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="row">
            <div class="border rounded border-primary p-3">
                <div class="h4 text-info">Detalle Camión</div>
            </div>
        </div>
        <div class="row">
            <div class="border rounded border-primary p-3 mt-3">
                <div class="h4 text-info">Detalle Carga</div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-lg-8">
        <div class="border rounded border-primary p-3">
            <div class="h4 text-info">Detalle Ruta</div>
            <div class="row mt-5">
                <div class="col-lg-3">
                    <div class="form-floating mb-3">
                        <input class="form-control rounded border-primary" id="rutaOrigen" type="text" placeholder="Nombre">
                        <label class="text-primary" for="nombreConductor">Origen</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control rounded border-primary" id="pickupDate" type="text" placeholder="Nombre">
                        <label class="text-primary" for="nombreConductor">Fecha de Recolección</label>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-floating mb-3">
                        <input class="form-control rounded border-primary" id="rutaDestino" type="text" placeholder="Nombre">
                        <label class="text-primary" for="nombreConductor">Destino</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control rounded border-primary" id="deliveryDate" type="text" placeholder="Nombre">
                        <label class="text-primary" for="nombreConductor">Fecha de Entrega</label>
                    </div>
                </div>
                <div class="col">
                    Mapa
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    $(document).ready(function() {
        $('#nombreModulo').text('Cargas');
        $('#nombreModuloM').text('Cargas');

        $('#dotSearch').on('click', function() {
            $.get('../controllers/Load.php', {
                action: 'generalDot',
                dot: $('#searchText').val(),
            }).done(function(resp) {
                respuesta = JSON.parse(resp);
                $('#estatusOperacion').html(respuesta.commonAuthorityStatus);
                $('#nombreLegal').html(respuesta.legalName);
                $('#estado').html(respuesta.phyState);
                $('#usDot').html(respuesta.dotNumber);
            });
        });

        $('#mcSearch').on('click', function() {
            $.get('../controllers/Load.php', {
                action: 'generalMC',
                mc: $('#searchText').val(),
            }).done(function(resp) {
                respuesta = JSON.parse(resp);
                $('#estatusOperacion').html(respuesta.commonAuthorityStatus);
                $('#nombreLegal').html(respuesta.legalName);
                $('#estado').html(respuesta.phyState);
                $('#usDot').html(respuesta.dotNumber);
                $('#mc').html($('#searchText').val());
            });
        });

        new tempusDominus.TempusDominus(document.getElementById('pickupDate'), {
            restrictions: {

            },
            useCurrent: true,
            display: {
                viewMode: 'calendar',
                buttons: {
                    close: true,
                },
                components: {
                    calendar: true,
                    date: true,
                    month: true,
                    year: true,
                    clock: true,
                    hours: true,
                    minutes: true,
                },
            },
            promptTimeOnDateChange: true,
            promptTimeOnDateChangeTransitionDelay: 2000,
            stepping: 5
        });
    });
</script>