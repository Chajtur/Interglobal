<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<div class="row text-primary">
    <div class="col-lg-4 col-sm-12 pb-2 order-last d-none">
        <div class="border border-2 border-primary p-2 rounded h-100 text-primary">
            <h4>Detalle Camión</h4>
            <hr>
            <div class="row">
                <div class="text-primary">
                    <div class="form-floating mb-3">
                        <input class="form-control rounded border-primary" id="carrier" type="text" placeholder="Nombre" disabled>
                        <label class="text-primary" for="carrier">Empresa</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control rounded border-primary" id="vin" type="text" placeholder="Nombre">
                        <label class="text-primary" for="vin">VIN</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control rounded border-primary" id="truckNumber" type="number" placeholder="Nombre">
                        <label class="text-primary" for="truckNumber">Número de Camión</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control rounded border-primary" id="trailerNumber" type="number" placeholder="Nombre">
                        <label class="text-primary" for="trailerNumber">Número de Remolque</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control rounded border-primary" id="trailerNumber" type="number" placeholder="Nombre">
                        <label class="text-primary" for="trailerNumber">Peso Máximo</label>
                    </div>
                    <div class="">
                        <label for="truckType" class="form-label text-primary">Tipo</label>
                        <select class="form-select border-primary" id='truckType'>
                            <option value="0">Reefer</option>
                            <option value="1">Dry Van</option>
                            <option value="2">Flatbed</option>
                            <option value="3">Hotshot</option>
                            <option value="4">Power Only</option>
                        </select>
                    </div>
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
    <div class="col-lg-7 col-sm-12 pb-2">
        <div class="border border-2 border-primary p-2 rounded h-100">
            <h4>Listado de Camiones</h4>
            <hr>
            <div class="form-floating mb-3">
                <input class="form-control rounded border-primary" id="filtroNombres" type="text" placeholder="Nombre">
                <label class="text-primary" for="filtroNombres">Filtrar Camiones</label>
            </div>
            <hr>
            <ul class="list-group">
                <li class="list-group-item" type="button" data-bs-toggle="collapse" data-bs-target="#RomeTransportation" aria-expanded="false" aria-controls="RomeTransportation">
                    <div class="row align-items-center pe-0">
                        <span class="col-1">1.-</span>
                        <span class="col-8">Rome Transportation LLC</span>
                        <span class="col-2">4 Camiones</span>
                    </div>
                    <table id="RomeTransportation" class="table table-striped collapse table-hover table-responsive-md">
                        <thead>
                            <th>VIN</th>
                            <th>Número de Camión</th>
                            <th>Despachador</th>
                            <th class="text-center">Estado</th>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr>
                                <td>asd1f65as1d5f</td>
                                <td>1</td>
                                <td>Alejandro Flores</td>
                                <td class="btn border-round bg-success text-white w-100">Activo</td>
                            </tr>
                            <tr>
                                <td>j520i43foeri</td>
                                <td>2</td>
                                <td>Josué Peña</td>
                                <td class="btn border-round bg-success text-white w-100">Activo</td>
                            </tr>
                            <tr>
                                <td>fpjdsofpk</td>
                                <td>3</td>
                                <td>Alejandro Flores</td>
                                <td class="btn border-round bg-success text-white w-100">Activo</td>
                            </tr>
                            <tr>
                                <td>934if9wj93</td>
                                <td>4</td>
                                <td>Josué Peña</td>
                                <td class="btn border-round bg-success text-white w-100">Activo</td>
                            </tr>
                        </tbody>
                        <tfoot class=" table-group-divider">
                            <tr>
                                <td colspan="4" >
                                    <span class="col btn btn-primary">Agregar Camión</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </li>
                <li class="list-group-item" type="button" data-bs-toggle="collapse" data-bs-target="#TonyAguirre" aria-expanded="false" aria-controls="TonyAguirre">
                    <div class="row">
                        <span class="col-1">2.-</span>
                        <span class="col-8">Pablo Moore Trucking Services LLC</span>
                        <span class="col-2">1 Camión</span>
                    </div>
                    <table id="TonyAguirre" class="table table-striped collapse table-hover table-responsive-md">
                        <thead>
                            <th>VIN</th>
                            <th>Número de Camión</th>
                            <th>Despachador</th>
                            <th class="text-center">Estado</th>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr>
                                <td>934if9wj93</td>
                                <td>4</td>
                                <td>Josué Peña</td>
                                <td class="btn border-round bg-success text-white w-100">Activo</td>
                            </tr>
                        </tbody>
                        <tfoot class=" table-group-divider">
                            <tr>
                                <td colspan="4" >
                                    <span class="col btn btn-primary">Agregar Camión</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </li>
                <li class="list-group-item" type="button" data-bs-toggle="collapse" data-bs-target="#ChrisLion" aria-expanded="false" aria-controls="ChrisLion">
                    <div class="row">
                        <span class="col-1">3.-</span>
                        <span class="col-8">ChrisLion Transport LLC</span>
                        <span class="col-2">7 Camiones</span>
                    </div>
                    <table id="ChrisLion" class="table table-striped collapse table-hover table-responsive-md">
                        <thead>
                            <th>VIN</th>
                            <th>Número de Camión</th>
                            <th>Despachador</th>
                            <th class="text-center">Estado</th>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr>
                                <td>asd1f65as1d5f</td>
                                <td>1</td>
                                <td>Alejandro Flores</td>
                                <td class="btn border-round bg-success text-white w-100">Activo</td>
                            </tr>
                            <tr>
                                <td>j520i43foeri</td>
                                <td>2</td>
                                <td>Josué Peña</td>
                                <td class="btn border-round bg-success text-white w-100">Activo</td>
                            </tr>
                            <tr>
                                <td>fpjdsofpk</td>
                                <td>3</td>
                                <td>Alejandro Flores</td>
                                <td class="btn border-round bg-danger text-white w-100">Inactivo</td>
                            </tr>
                            <tr>
                                <td>934if9wj93</td>
                                <td>4</td>
                                <td>Josué Peña</td>
                                <td class="btn border-round bg-success text-white w-100">Activo</td>
                            </tr>
                            <tr>
                                <td>j520i43fkgsdfpg2oeri</td>
                                <td>5</td>
                                <td>Josué Peña</td>
                                <td class="btn border-round bg-success text-white w-100">Activo</td>
                            </tr>
                            <tr>
                                <td>9jfimcev</td>
                                <td>6</td>
                                <td>Alejandro Flores</td>
                                <td class="btn border-round bg-success text-white w-100">Activo</td>
                            </tr>
                            <tr>
                                <td>93jg5iefmdkl</td>
                                <td>9</td>
                                <td>Josué Peña</td>
                                <td class="btn border-round bg-success text-white w-100">Activo</td>
                            </tr>
                        </tbody>
                        <tfoot class=" table-group-divider">
                            <tr>
                                <td colspan="4" >
                                    <span class="col btn btn-primary">Agregar Camión</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </li>
                <li class="list-group-item" type="button" data-bs-toggle="collapse" data-bs-target="#BullTransportation" aria-expanded="false" aria-controls="BullTransportation">
                    <div class="row">
                        <span class="col-1">4.-</span>
                        <span class="col-8">Bull Transportation LLC</span>
                        <span class="col-2">2 Camiones</span>
                    </div>
                    <table id="BullTransportation" class="table table-striped collapse table-hover table-responsive-md">
                        <thead>
                            <th>VIN</th>
                            <th>Número de Camión</th>
                            <th>Despachador</th>
                            <th class="text-center">Estado</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>934if9wj93</td>
                                <td>4</td>
                                <td>Josué Peña</td>
                                <td class="btn border-round bg-success text-white w-100">Activo</td>
                            </tr>
                            <tr>
                                <td>nalfkgansdo</td>
                                <td>7</td>
                                <td>Josué Peña</td>
                                <td class="btn border-round bg-danger text-white w-100">Inactivo</td>
                            </tr>
                        </tbody>
                        <tfoot class=" table-group-divider">
                            <tr>
                                <td colspan="4" >
                                    <span class="btn btn-primary">Agregar Camión</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </li>
            </ul>
        </div>
    </div>
    <script type="text/javascript" src="../js/truck.js"></script>
    <link rel="stylesheet" href="../css/truck.css">