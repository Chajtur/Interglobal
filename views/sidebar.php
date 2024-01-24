<?php
$user = new User();
$user->load($_SESSION['user']['id']);
?>
<link rel="stylesheet" href="../css/sidebar.css">
<script src="../js/sidebar.js"></script>
<div class="position-relative navbar-menu">
  <div class="position-fixed top-0 start-0 bottom-0 w-75 mw-sm-xs pt-6 overflow-auto">
    <div class="px-6 pb-0 position-relative d-flex justify-content-center">
      <div class="d-inline-flex align-items-center text-center">
        <a class="" href="#" data-config-id="brand">
          <i class="fas fa-user fa-6x text-primary"></i>
        </a>
      </div>
    </div>
    <h5 class="text-primary text-center"><?= $user->firstName?></h5>
    <h5 class="text-primary text-center"><?= $user->lastName?></h5>
    <div class="py-0 px-6">
      <ul class="nav flex-column mb-8">
        <li class="nav-item nav-pills" data-module='Dashboard'>
          <a class="nav-link  p-3 d-flex align-items-center" href="#">
            <span class="fa-solid fa-chart-line fa-lg"></span>
            <span class="mx-4 small">Dashboard</span>
          </a>
        </li>
        <li class="nav-item nav-pills" data-module='Calendario'>
          <a class="nav-link  p-3 d-flex align-items-center" href="#">
            <span class="fa-solid fa-calendar-days fa-lg"></span>
            <span class="mx-4 small" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Marcación, Feriados, Vacaciones, Permisos...">Calendar</span>
          </a>
        </li>
        <li class="nav-item nav-pills" data-module='VIN'>
          <a class="nav-link  p-3 d-flex align-items-center" href="#">
            <span class="fa-solid fa-car-side fa-lg"></span>
            <span class="mx-4 small ms-2">Search VIN</span>
          </a>
        </li>
      </ul>
      <hr>
      <?php if ($user->hasPermission('interglobal')) { ?>
        <h3 class="btn border-0 ps-0 text-primary mb-2 text-uppercase small fw-bold" id="interglobalUlBtn">Interglobal Insurance</h3>
      <?php } ?>
      <ul class="nav flex-column mb-8 d-none" id="interglobalUl">
        <?php if ($user->hasPermission('callCenter')) { ?>
          <li class="nav-item nav-pills" data-module='CallCenterInter'>
            <a class="nav-link  p-3 d-flex align-items-center" href="#">
              <span class="fa-solid fa-headset fa-lg"></span>
              <span class="mx-4 small" data-config-id="link3">Call Center</span>
            </a>
          </li>
        <?php } ?>
        <?php if ($user->hasPermission('polizas')) { ?>
          <li class="nav-item nav-pills" data-module='MyPolicies'>
            <a class="nav-link  p-3 d-flex align-items-center" href="#">
              <span class="fa-solid fa-briefcase fa-lg"></span>
              <span class="mx-4 small" data-config-id="link3">My Portfolio</span>
            </a>
          </li>
        <?php } ?>
        <?php if ($user->hasPermission('cotizaciones')) { ?>
          <li class="nav-item nav-pills" data-module='Quotes'>
            <a class="nav-link  p-3 d-flex align-items-center" href="#">
              <span class="fa fa-pen-to-square fa-lg" aria-hidden="true"></span>
              <span class="small mx-4" data-config-id="link5">Quotes</span>
            </a>
          </li>
        <?php } ?>
        <?php if ($user->hasPermission('rfp')) { ?>
          <li class="nav-item nav-pills" data-module='RFP'>
            <a class="nav-link  p-3 d-flex align-items-center" href="#">
              <span class="fa fa-file-contract fa-lg" aria-hidden="true"></span>
              <span class="small mx-4" data-config-id="link5">RFP</span>
            </a>
          </li>
        <?php } ?>
      </ul>
      <?php if ($user->hasPermission('usTrucking')) { ?>
        <h3 class="btn border-0 ps-0 text-primary mb-2 text-uppercase small fw-bold" id="usTruckingUlBtn">US Trucking for Hire</h3>
      <?php } ?>
      <ul class="nav flex-column d-none" id="usTruckingUl">
        <?php if ($user->hasPermission('cargas')) { ?>
          <li class="nav-item nav-pills" data-module="load">
            <a class="nav-link p-3 d-flex align-items-center" href="#">
              <span class="fa-solid fa-route fa-lg"></span>
              <span class="mx-4 small" data-config-id="link7">Loads</span>
            </a>
          </li>
        <?php } ?>
        <?php if ($user->hasPermission('camiones')) { ?>
          <li class="nav-item nav-pills" data-module="truck">
            <a class="nav-link  p-3 d-flex align-items-center" href="#">
              <span class="fa-solid fa-truck-moving fa-lg"></span>
              <span class="mx-4 small" data-config-id="link8">Trucks</span>
            </a>
          </li>
        <?php } ?>
        <?php if ($user->hasPermission('conductores')) { ?>
          <li class="nav-item nav-pills" data-module="driver">
            <a class="nav-link p-3 d-flex align-items-center" href="#">
              <span class="fa-solid fa-users fa-lg"></span>
              <span class="mx-4 small" data-config-id="link9">Drivers</span>
            </a>
          </li>
        <?php } ?>
        <?php if ($user->hasPermission('callCenter')) { ?>
          <li class="nav-item nav-pills" data-module='CallCenter'>
            <a class="nav-link  p-3 d-flex align-items-center" href="#">
              <span class="fa-solid fa-headset fa-lg"></span>
              <span class="mx-4 small" data-config-id="link3">Call Center</span>
            </a>
          </li>
        <?php } ?>
        <?php if ($user->hasPermission('safer')) { ?>
          <li class="nav-item nav-pills" data-module="safer">
            <a class="nav-link p-3 d-flex align-items-center" href="#">
              <span class="fa-solid fa-s fa-lg"></span>
              <span class="small mx-4" data-config-id="link10">Safer</span>
            </a>
          </li>
        <?php } ?>
      </ul>
      <hr>
      <ul class="nav flex-column mb-1">
        <li class="nav-item nav-pills" data-module='eticket'>
          <a class="nav-link  p-3 d-flex align-items-center" href="#">
            <span class="fa-solid fa-list-check fa-lg"></span>
            <span class="mx-4 small" data-config-id="link11">E-Tickets</span>
          </a>
        </li>
        <li class="nav-item nav-pills" id="liCerrarSesion">
          <a class="nav-link  p-3 d-flex align-items-center" href="#">
            <span class="fa-solid fa-power-off fa-lg"></span>
            <span class="mx-4 small" data-config-id="link12">Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>