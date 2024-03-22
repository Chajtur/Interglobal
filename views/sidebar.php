<?php
$user = new User();
if (isset($_SESSION['user']['id'])) {
    $user->load($_SESSION['user']['id']);
} else {
    header('Location: ../index.php');
}
?>
<link rel="stylesheet" href="../css/sidebar.css">
<script src="../js/sidebar.js"></script>
<div class="text-white" id="sidebar">
    <div class="mt-3 text-center">
        <a class="" href="#" data-config-id="brand">
            <i class="fas fa-user fa-3x text-white"></i>
        </a>
    </div>
    <hr class="mt-3" >
    <div class="rounded-div bg-zinc-400 mt-3 mx-auto fw-bold" title="Human Resources" data-id="hr">HR</div>
    <div class="icon-group" data-id="hr">
        <div class="mt-3 icon ms-4" data-module="Dashboard">
            <div class="align-items-center" href="#">
                <span class="fa-solid fa-chart-line fa-xl text-white"></span>
                <span class="sidebar-text text-white">Dashboard</span>
            </div>
        </div>
        <div class="mt-3 icon ms-4" data-module="Calendario">
            <div class="align-items-center" href="#">
                <span class="fa-solid fa-calendar-days fa-xl text-white"></span>
                <span class="sidebar-text text-white">Calendar</span>
            </div>
        </div>
    </div>
    <hr class="mt-3" >
    <?php if ($user->hasPermission('interglobal')) { ?>
        <div class="rounded-div bg-zinc-400 mt-3 mx-auto fw-bold" data-id='ii' title="Interglobal Insurance">II</div>
        <div class="icon-group" data-id='ii'>
            <div class="mt-3 icon ms-4" data-module="VIN">
                <div class="align-items-center" href="#">
                    <span class="fa-solid fa-car-side fa-xl text-white"></span>
                    <span class="sidebar-text text-white">Search VIN</span>
                </div>
            </div>
            <?php if ($user->hasPermission('callCenter')) { ?>
                <div class="mt-3 icon ms-4" data-module="CallCenterInter">
                    <div class="align-items-center" href="#">
                        <span class="fa-solid fa-headset fa-xl text-white"></span>
                        <span class="sidebar-text text-white">Call Center</span>
                    </div>
                </div>
            <?php } ?>
            <?php if ($user->hasPermission('polizas')) { ?>
                <div class="mt-3 icon ms-4" data-module="MyPolicies">
                    <div class="align-items-center" href="#">
                        <span class="fa-solid fa-briefcase fa-xl text-white"></span>
                        <span class="sidebar-text text-white">Portfolio</span>
                    </div>
                </div>
            <?php } ?>
            <?php if ($user->hasPermission('cotizaciones')) { ?>
                <div class="mt-3 icon ms-4" data-module="Quotes">
                    <div class="align-items-center" href="#">
                        <span class="fa-solid fa-pen-to-square fa-xl text-white"></span>
                        <span class="sidebar-text text-white">Quotes</span>
                    </div>
                </div>
            <?php } ?>
            <?php if ($user->hasPermission('rfp')) { ?>
                <div class="mt-3 icon ms-4" data-module="RFP">
                    <div class="align-items-center" href="#">
                        <span class="fa-solid fa-file-contract fa-xl text-white"></span>
                        <span class="sidebar-text text-white">RFP</span>
                    </div>
                </div>
            <?php } ?>
        </div>
        <hr class="mt-3" >    
    <?php } ?>
    <?php if ($user->hasPermission('usTrucking')) { ?>
        <div class="rounded-div bg-zinc-400 mt-3 mx-auto fw-bold" data-id='ut' title="US Trucking for Hire">UT</div>
        <div class="icon-group" data-id="ut">
            <?php if ($user->hasPermission('cargas')) { ?>
                <div class="mt-3 icon ms-4" data-module="load">
                    <div class="align-items-center" href="#">
                        <span class="fa-solid fa-route fa-xl text-white"></span>
                        <span class="sidebar-text text-white">Loads</span>
                    </div>
                </div>
            <?php } ?>
            <?php if ($user->hasPermission('camiones')) { ?>
                <div class="mt-3 icon ms-4" data-module="trucks">
                    <div class="align-items-center" href="#">
                        <span class="fa-solid fa-truck-moving fa-xl text-white"></span>
                        <span class="sidebar-text text-white">Trucks</span>
                    </div>
                </div>
            <?php } ?>
            <?php if ($user->hasPermission('conductores')) { ?>
                <div class="mt-3 icon ms-4" data-module="drivers">
                    <div class="align-items-center" href="#">
                        <span class="fa-solid fa-user-tie fa-xl text-white"></span>
                        <span class="sidebar-text text-white">Drivers</span>
                    </div>
                </div>
            <?php } ?>
        </div>
        <hr class="mt-3" >
    <?php } ?>
    <?php if ($user->hasPermission('configurarSistema')) { ?>
        <div class="mt-3 icon ms-4" data-module="systemConfig">
            <div class="align-items-center" href="#">
                <span class="fa-solid fa-gears fa-xl text-white"></span>
                <span class="sidebar-text text-white">Parameters</span>
            </div>
        </div>
    <?php } ?>
    <div class="mt-3 icon ms-4" data-module="eticket">
        <div class="align-items-center" href="#">
            <span class="fa-solid fa-list-check fa-xl text-white"></span>
            <span class="sidebar-text text-white">E-Tickets</span>
        </div>
    </div>
    <div class="mt-3 icon ms-4" id="logOut">
        <div class="align-items-center" href="#">
            <span class="fa-solid fa-power-off fa-xl text-white"></span>
            <span class="sidebar-text text-white">Logout</span>
        </div>
    </div>
</div>